import {IconAsteriskSimple, IconDatabase, IconPencilOff} from "@tabler/icons-react";
import classNames from "classnames";
import Label from "../Components/Label";
import Factory from "../Fields/Factory";

export default function ({
    fields,
    values,
    onChange,
    className,
    context,
    readOnly,
    resource,
    errors = {},
    ...props
}) {
    return (
        <div className={classNames(className, "divide-y divide-slate-100")} {...props}>
            {fields.map(({type, value, label, readOnly: readOnlyField, required, ...props}, i) => {
                const Field = Factory.make(type);

                const noEdit = readOnly || readOnlyField;

                return (
                    <div key={props.name} className="p-6 xl:flex xl:space-x-6">
                        <div className="w-80">
                            <Label htmlFor={props.name} className="whitespace-nowrap">
                                {label}
                                {required && (
                                    <IconAsteriskSimple
                                        className="inline align-top text-red-500"
                                        size={8}
                                    />
                                )}
                            </Label>
                            {type === "relation" && (
                                <span className="mt-2 flex items-center text-xs italic tracking-wide text-slate-400">
                                    <IconDatabase size={16} className="mr-1" /> Relationship
                                </span>
                            )}
                            {noEdit && (
                                <span className="mt-2 flex items-center text-xs italic tracking-wide text-slate-400">
                                    <IconPencilOff size={16} className="mr-1" /> readonly
                                </span>
                            )}
                        </div>
                        <div className="w-full">
                            <Field
                                label={label}
                                context={context}
                                className="w-full"
                                id={props.name}
                                value={values[props.name]}
                                onChange={onChange}
                                readOnly={noEdit}
                                resource={resource}
                                {...props}
                            />
                            {!!errors[props.name] && (
                                <div className="mt-1 w-full text-xs text-red-500">
                                    {errors[props.name]}
                                </div>
                            )}
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
