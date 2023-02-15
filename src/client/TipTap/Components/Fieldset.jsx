import {IconGripVertical} from "@tabler/icons-react";
import {NodeViewWrapper} from "@tiptap/react";
import classNames from "classnames";
import Label from "../../Components/Label";
import FieldFactory from "../../Fields/Factory";

export default function Block({editor, node, updateAttributes, selected}) {
    const {attrs} = node;

    const readOnly = !editor.options.editable;

    const {value, label, type, ...props} = editor.fieldset(attrs.name);

    const Field = FieldFactory.make(type);

    function handleChange(key, value) {
        updateAttributes({...attrs, value});
    }

    return (
        <NodeViewWrapper
            className={classNames(
                "my-3 overflow-hidden rounded border bg-slate-50",
                selected ? "border-slate-300" : "border-slate-200"
            )}
        >
            <div
                data-drag-handle
                className="flex cursor-grab items-center border-b border-slate-200 bg-slate-100 px-0.5 pb-1.5 pt-1"
            >
                <IconGripVertical className="mr-2" size={12} />
                <Label className={selected ? "font-semibold" : "font-normal"}>{label}</Label>
            </div>
            <Field
                className="w-full p-3"
                value={attrs.value}
                onChange={handleChange}
                readOnly={readOnly}
                {...props}
            />
        </NodeViewWrapper>
    );
}
