import {Switch} from "@headlessui/react";
import classNames from "classnames";

export default function BooleanField({name, className, value, onChange, decorators, ...props}) {
    const {label} = decorators ?? {};

    function handleChange(value) {
        if (!onChange) return;

        onChange(name, value);
    }

    return (
        <div className={classNames(className, "flex items-center space-x-4")}>
            <Switch
                checked={value ?? false}
                onChange={handleChange}
                className={classNames(
                    "relative inline-flex h-6 w-12 items-center rounded-full",
                    value ? "bg-blue-500" : "bg-slate-200"
                )}
            >
                <span
                    className={classNames(
                        "block h-6 w-6 transform rounded-full bg-white shadow transition",
                        value ? "translate-x-0" : "translate-x-6"
                    )}
                />
            </Switch>
            <span>{label}</span>
        </div>
    );
}
