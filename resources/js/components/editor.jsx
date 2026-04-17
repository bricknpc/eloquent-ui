import React from "react";
import { createRoot } from "react-dom/client";
import { useCreateBlockNote } from "@blocknote/react";
import { BlockNoteView } from "@blocknote/mantine";
import { BlockNoteSchema, defaultInlineContentSpecs } from "@blocknote/core";
import { filterSuggestionItems } from "@blocknote/core/extensions";
import { SuggestionMenuController, createReactInlineContentSpec } from "@blocknote/react";
import "@blocknote/mantine/style.css";

const EntityReference = createReactInlineContentSpec(
    {
        type: "entity",
        propSchema: {
            data: { default: "{}" },
        },
        content: "styled",
    },
    {
        render: (props) => {
            const wrapperRef = React.useRef(null);

            const handleDelete = (e) => {
                e.preventDefault();
                e.stopPropagation();

                const tiptap = props.editor._tiptapEditor;
                const nodeDOM = wrapperRef.current;
                if (!nodeDOM) return;

                // posAtDOM with offset 0 lands before the node, offset 1 lands inside
                // Try both to find the actual inline node
                const posInside = tiptap.view.posAtDOM(nodeDOM, 1);
                const resolvedPos = tiptap.state.doc.resolve(posInside);
                const nodeStart = resolvedPos.before();
                const nodeEnd = nodeStart + resolvedPos.parent.nodeSize;

                // Walk up to find the inline node specifically
                let found = false;
                tiptap.state.doc.nodesBetween(nodeStart, nodeEnd, (node, pos) => {
                    if (found) return false;
                    if (node.type.name === "entity") {
                        found = true;
                        tiptap.chain()
                            .setTextSelection({ from: pos, to: pos + node.nodeSize })
                            .deleteSelection()
                            .run();
                        return false;
                    }
                });
            };

            return (
                <span
                    className={"badge border border-primary-subtle rounded-3 p-2 bg-primary-subtle text-primary-emphasis d-inline-flex align-items-center"}
                    ref={wrapperRef}
                    style={{
                        cursor: "text",
                        userSelect: "none",
                        border: "1px solid var(--bs-primary-border-subtle)",
                    }}
                >
            <span ref={props.contentRef} />
            <span
                onClick={handleDelete}
                style={{
                    cursor: "pointer",
                    lineHeight: 1,
                    opacity: 0.6,
                }}
                className={"mx-1"}
                title="Remove"
            >
                ×
            </span>
        </span>
            );
        },
    }
);

const defaultSchema = BlockNoteSchema.create();

const mentionsSchema = BlockNoteSchema.create({
    inlineContentSpecs: {
        ...defaultInlineContentSpecs,
        entity: EntityReference,
    },
});

async function fetchReferenceItems(editor, query, mentionsUrl) {
    try {
        const url = new URL(mentionsUrl, window.location.origin);
        url.searchParams.set("q", query);

        const response = await fetch(url.toString());
        if (!response.ok) return [];

        const results = await response.json();

        return results.map((result) => ({
            title: result.title,
            subtext: result.subtext ?? "",
            onItemClick: () => {
                editor.insertInlineContent([
                    {
                        type: "entity",
                        content: result.title,
                        props: {
                            data: JSON.stringify(result.props ?? {}),
                        },
                    },
                    " ",
                ]);
            },
        }));
    } catch (e) {
        console.error("[BlockNote mentions] Failed to fetch:", e);
        return [];
    }
}

function Editor({ value, onChange, mentionsUrl, mentionsTrigger }) {
    const hasMentions = Boolean(mentionsUrl);
    const schema = hasMentions ? mentionsSchema : defaultSchema;

    const editor = useCreateBlockNote({
        schema,
        initialContent: value ? JSON.parse(value) : undefined,
    });

    return (
        <BlockNoteView
            editor={editor}
            onChange={() => onChange(JSON.stringify(editor.document))}
        >
            {hasMentions && (
                <SuggestionMenuController
                    triggerCharacter={mentionsTrigger}
                    getItems={async (query) =>
                        filterSuggestionItems(
                            await fetchReferenceItems(editor, query, mentionsUrl),
                            query
                        )
                    }
                />
            )}
        </BlockNoteView>
    );
}

export function mountEditor(el) {
    const value       = el.dataset.value || "";
    const target      = el.dataset.inputTarget;
    const mentionsUrl = el.dataset[`${window.EloquentUIConfig.ns}Mentions`] === "true"
        ? el.dataset[`${window.EloquentUIConfig.ns}MentionsUrl`]
        : null;
    const mentionsTrigger = (el.dataset[`${window.EloquentUIConfig.ns}MentionsTrigger`] ?? "@")[0];

    const root = createRoot(el);
    root.render(
        <Editor
            value={value}
            onChange={(val) => {
                const input = document.querySelector(target);
                input.value = val;
                input.dispatchEvent(new Event("input", { bubbles: true }));
            }}
            mentionsUrl={mentionsUrl}
            mentionsTrigger={mentionsTrigger}
        />
    );
}