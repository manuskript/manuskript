import {IconDatabase, IconPencilOff} from "@tabler/icons-react";
import classNames from "classnames";
import Label from "../Components/Label";
import Factory from "../Fields/Factory";

export default function ({fields, values, onChange, className, readOnly, ...props}) {
    return (
        <div className={classNames(className, "divide-y divide-slate-100 bg-white")} {...props}>
            {fields.map(({type, value, label, ...props}) => {
                const Field = Factory.make(type);

                const noEdit = readOnly && type !== "relation";

                return (
                    <div key={props.name} className="p-6 xl:flex xl:space-x-6">
                        <div className="w-80">
                            <Label htmlFor={props.name}>{label}</Label>
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
                        <Field
                            className="w-full"
                            id={props.name}
                            value={values[props.name]}
                            onChange={onChange}
                            readOnly={readOnly}
                            {...props}
                        />
                    </div>
                );
            })}
        </div>
    );
}
