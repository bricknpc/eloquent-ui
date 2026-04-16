import React from "react";
import { createRoot } from "react-dom/client";
import { useCreateBlockNote } from "@blocknote/react";
import { BlockNoteView } from "@blocknote/mantine";
import { BlockNoteSchema, defaultInlineContentSpecs } from "@blocknote/core";
import { filterSuggestionItems } from "@blocknote/core/extensions";
import { SuggestionMenuController, createReactInlineContentSpec } from "@blocknote/react";
import "@blocknote/mantine/style.css";

// The inline content spec — stores everything in one "data" prop
const EntityReference = createReactInlineContentSpec(
    {
        type: "entity",
        propSchema: {
            display: { default: "" },   // for rendering the label
            data:    { default: "{}" }, // JSON-stringified props from backend
        },
        content: "none",
    },
    {
        render: (props) => {
            const handleDelete = (e) => {
                e.preventDefault();
                e.stopPropagation();
                props.editor.removeBlocks
                // BlockNote doesn't have a direct "remove inline content" API,
                // so we select the node and delete it via the underlying editor
                const { editor } = props;
                editor._tiptapEditor.commands.deleteSelection();
            };

            return (
                <span
                    style={{
                        display: "inline-flex",
                        alignItems: "center",
                        gap: "2px",
                        backgroundColor: "#dbeafe",
                        color: "#1d4ed8",
                        borderRadius: "3px",
                        padding: "1px 4px",
                        fontWeight: "bold",
                    }}
                >
                {props.inlineContent.props.display}
                    <span
                        onMouseDown={(e) => {
                            e.preventDefault();
                            e.stopPropagation();

                            const tiptap = props.editor._tiptapEditor;
                            const nodeDOM = e.currentTarget.parentElement;
                            const pos = tiptap.view.posAtDOM(nodeDOM, 0);
                            const node = tiptap.state.doc.nodeAt(pos);

                            if (node) {
                                tiptap.chain()
                                    .setTextSelection({ from: pos, to: pos + node.nodeSize })
                                    .deleteSelection()
                                    .run();
                            }
                        }}
                        style={{
                            cursor: "pointer",
                            fontSize: "0.75em",
                            lineHeight: 1,
                            opacity: 0.7,
                            userSelect: "none",
                            padding: "0 1px",
                        }}
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
            // When inserting, serialize result.props to JSON
            onItemClick: () => {
                editor.insertInlineContent([
                    {
                        type: "entity",
                        props: {
                            display: result.title,
                            data:    JSON.stringify(result.props ?? {}),
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
    const value      = el.dataset.value || "";
    const target     = el.dataset.inputTarget;
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