import {Listbox} from "@headlessui/react";
import {IconCheck, IconSelector, IconX} from "@tabler/icons-react";
import classNames from "classnames";
import {useEffect, useRef} from "react";

export default function SelectField({
    name,
    label,
    value,
    className,
    default: fallback,
    decorators = {},
    style = {},
    onChange = function () {},
    readOnly,
    ...props
}) {
    const options = useRef([]);

    const multiple = useRef(null);

    useEffect(() => {
        multiple.current = !!decorators.multiple;

        options.current = (decorators.options ?? []).map(option =>
            typeof option === "object" && !!option ? option : {label: option, value: option}
        );
    }, [decorators]);

    useEffect(() => {
        if (value) {
            return;
        }

        if (fallback) {
            onChange(
                name,
                multiple.current ? (Array.isArray(fallback) ? fallback : [fallback]) : fallback
            );
        } else {
            onChange(name, multiple.current ? [] : "");
        }
    }, [value]);

    function removeFromValues(val) {
        const filtered = [...value].filter(v => v !== val);

        onChange(name, filtered);
    }

    function handleChange(value) {
        if (!onChange) return;

        onChange(name, value);
    }

    return (
        value !== null && (
            <div className={classNames(className, "relative")}>
                <Listbox
                    value={value}
                    onChange={handleChange}
                    multiple={multiple.current}
                    readOnly={readOnly}
                >
                    <Listbox.Button
                        className={classNames(
                            "flex w-full items-center justify-between rounded-lg border px-3 py-2 outline-none focus:shadow-md",
                            readOnly ? "bg-slate-100" : "bg-white"
                        )}
                    >
                        <span className="block w-full overflow-hidden pr-4 text-left">
                            <span className="block truncate">
                                {multiple.current
                                    ? `${value.length} item(s) selected`
                                    : (() => {
                                          const option = options.current.find(
                                              option => option.value === value
                                          );

                                          return option ? option.label : "";
                                      })()}
                            </span>
                        </span>
                        <IconSelector className="flex-none" size={16} />
                    </Listbox.Button>
                    <Listbox.Options className="absolute mt-1 max-h-60 w-full overflow-auto rounded-lg border bg-white text-left outline-none focus:shadow-md">
                        {options.current.map(option => (
                            <Listbox.Option
                                key={option.value}
                                value={option.value}
                                className={({active}) =>
                                    classNames(
                                        "relative cursor-default select-none px-3 py-2",
                                        active ? "bg-slate-50 text-slate-800" : "text-slate-500"
                                    )
                                }
                            >
                                {({selected}) => (
                                    <span
                                        className={classNames(
                                            "flex items-center justify-between space-x-2",
                                            {
                                                "text-slate-800": selected,
                                            }
                                        )}
                                    >
                                        <span className="flex-1 truncate">{option.label}</span>
                                        {selected && (
                                            <IconCheck className="flex-shrink-0" size={16} />
                                        )}
                                    </span>
                                )}
                            </Listbox.Option>
                        ))}
                    </Listbox.Options>
                </Listbox>
                {multiple.current && (
                    <div className="-mx-1 mt-1">
                        {options.current
                            .filter(option => value.includes(option.value))
                            .map(({label, value}) => (
                                <button
                                    key={value}
                                    className="m-1 inline-flex items-center space-x-2 rounded-md bg-slate-100 px-2 py-1"
                                    onClick={() => removeFromValues(value)}
                                >
                                    <span className="max-w-[120px] truncate text-sm">{label}</span>
                                    <IconX size={12} />
                                </button>
                            ))}
                    </div>
                )}
            </div>
        )
    );
}
