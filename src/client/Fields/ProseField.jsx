import {IconToggleLeft, IconToggleRight} from "@tabler/icons-react";
import {EditorContent, useEditor} from "@tiptap/react";
import {useEffect, useState} from "react";
import {Extensions, getEditorProps} from "../TipTap";
import Toolbar from "../TipTap/Toolbar/Toolbar";
import TextAreaField from "./TextAreaField";

export default function ProseField({
    name,
    value,
    onChange = function () {},
    decorators,
    readOnly,
    className,
}) {
    const {toolbar, blocks, raw} = decorators;

    const [showRaw, setShowRaw] = useState(false);

    const [rawContent, setRawContent] = useState("[]");

    const editor = useEditor({
        editorProps: getEditorProps(readOnly),
        extensions: Extensions.resolve(toolbar),
        onUpdate({editor}) {
            onChange(name, editor.getJSON().content);
        },
    });

    function setContent(editor) {
        editor.commands.setContent({type: "doc", content: value});
    }

    function setBlocks(editor) {
        editor.fieldset = name => blocks.find(set => set.name === name);
    }

    function toggleShowRaw() {
        setShowRaw(!showRaw);
    }

    function handleJsonChange(_, value) {
        setRawContent(value);
    }

    function handleRawUpdate(e) {
        try {
            const json = JSON.parse(e.target.value);
            editor.commands.setContent({type: "doc", content: json});
        } catch (error) {}
    }

    useEffect(() => {
        if (editor) {
            setBlocks(editor);
            setContent(editor);

            if (readOnly) {
                return editor.setEditable(false);
            }
        }
    }, [editor, readOnly]);

    useEffect(() => {
        try {
            setRawContent(JSON.stringify(value ?? [], null, 2));
        } catch (error) {}
    }, [value]);

    return (
        editor && (
            <div className={className}>
                {showRaw ? (
                    <div>
                        <TextAreaField
                            className="min-h-[170px] font-mono"
                            value={rawContent}
                            onChange={handleJsonChange}
                            onBlur={handleRawUpdate}
                        />
                    </div>
                ) : (
                    <div>
                        {!readOnly && <Toolbar editor={editor} tools={toolbar} blocks={blocks} />}
                        <EditorContent editor={editor} />
                    </div>
                )}
                {raw && (
                    <div className="mt-1 flex justify-end px-1">
                        <button
                            className="ml-auto inline-flex items-center space-x-1 text-xs text-slate-500"
                            onClick={toggleShowRaw}
                        >
                            {showRaw ? <IconToggleLeft size={16} /> : <IconToggleRight size={16} />}{" "}
                            <span>Raw</span>
                        </button>
                    </div>
                )}
            </div>
        )
    );
}
