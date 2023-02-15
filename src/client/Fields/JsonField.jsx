import classNames from "classnames";
import Label from "../Components/Label";
import FieldFactory from "./Factory";

export default function JsonField({
    name,
    label,
    className,
    value: state,
    onChange,
    schema,
    readOnly,
    ...props
}) {
    state = state ?? {};

    function handleChange(key, value) {
        if (!onChange) return;

        onChange(name, {...state, [key]: value});
    }

    return (
        <div className={classNames(className, "space-y-3")}>
            {Object.entries(schema).map(([key, {type, value, label, ...props}]) => {
                const Field = FieldFactory.make(type);

                return (
                    <div key={key} className="flex overflow-hidden rounded border border-slate-200">
                        <Label
                            className="w-40 text-ellipsis border-r border-slate-200 p-3"
                            htmlFor={key + name}
                        >
                            {label}
                        </Label>
                        <Field
                            readOnly={readOnly}
                            className="rounded-none border-none"
                            id={key + name}
                            value={state[key]}
                            onChange={handleChange}
                            {...props}
                        />
                    </div>
                );
            })}
        </div>
    );
}
