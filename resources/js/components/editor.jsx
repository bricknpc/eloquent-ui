import React from "react";
import { createRoot } from "react-dom/client";
import { useCreateBlockNote } from "@blocknote/react";
import { BlockNoteView } from "@blocknote/mantine";
// Default styles for the mantine editor
import "@blocknote/mantine/style.css";
// Include the included Inter font
import "@blocknote/core/fonts/inter.css";

function Editor({ value, onChange }) {
    const editor = useCreateBlockNote({
        initialContent: value ? JSON.parse(value) : undefined,
    });

    return (
        <BlockNoteView
            editor={editor}
            onChange={() => {
                onChange(JSON.stringify(editor.document));
            }}
        />
    );
}

export function mountEditor(el) {
    const value = el.dataset.value || "";

    const root = createRoot(el);
    root.render(
        <Editor
            value={value}
            onChange={(val) => {
                el.querySelector("input").value = val;
            }}
        />
    );
}