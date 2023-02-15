import {EditorContent, useEditor} from "@tiptap/react";
import {useEffect, useState} from "react";
import {Extensions, getEditorProps} from "../TipTap";
import Toolbar from "../TipTap/Toolbar/Toolbar";

export default function ProseField({name, value, onChange, decorators, readOnly, className}) {
    const {toolbar, blocks} = decorators;

    const [rendered, setRendered] = useState(false);

    const editor = useEditor({
        editorProps: getEditorProps(readOnly),
        extensions: Extensions.resolve(toolbar),
    });

    function setContent(editor) {
        editor.commands.setContent({type: "doc", content: value});
    }

    function setBlocks(editor) {
        editor.fieldset = name => blocks.find(set => set.name === name);
    }

    useEffect(() => {
        if (editor && !rendered) {
            setRendered(true);
        }
    }, [rendered, editor]);

    useEffect(() => {
        if (rendered) {
            console.log("hello");
            setBlocks(editor);
            setContent(editor);

            if (readOnly) {
                return editor.setEditable(false);
            }

            editor.on("update", ({editor}) => {
                console.log("change");
                onChange(name, editor.getJSON().content);
            });
        }
    }, [rendered, readOnly]);

    return (
        editor && (
            <div className={className}>
                {!readOnly && <Toolbar editor={editor} tools={toolbar} blocks={blocks} />}
                <EditorContent editor={editor} />
            </div>
        )
    );
}
