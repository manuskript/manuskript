import {Dialog} from "@headlessui/react";
import {IconChevronDown, IconChevronUp, IconLink} from "@tabler/icons-react";
import classNames from "classnames";
import React, {useState} from "react";
import CellFactory from "../Forms/TableCell/Factory";

export default function SelectResource({
    selected = [],
    columns,
    rows,
    onChange,
    pagination,
    init,
    next,
    prev,
}) {
    const [booted, setBooted] = useState(false);

    const [open, setOpen] = useState(false);

    function handleOpen() {
        if (!booted) {
            boot();
        }
        setOpen(true);
    }

    function handleChange(value) {
        if (exists(value)) {
            return;
        }

        onChange(value);

        setOpen(false);
    }

    function exists(value) {
        return selected.map(({key}) => key).includes(value.key);
    }

    function boot() {
        init();
        setBooted(true);
    }

    return (
        <React.Fragment>
            <button onClick={handleOpen} className="flex items-center text-sm text-blue-500">
                <IconLink className="mr-2" size={16} /> Link entry
            </button>

            <Dialog open={open} onClose={() => setOpen(false)}>
                <div className="fixed inset-0 flex justify-end bg-slate-300/40 pl-20">
                    <Dialog.Panel className="w-full max-w-4xl overflow-y-scroll bg-white shadow-lg">
                        <table className="w-full table-auto border-collapse bg-white text-left text-sm">
                            <thead className="border-b border-slate-200 bg-slate-50">
                                <tr>
                                    {columns.map(({name, label, order}) => (
                                        <th
                                            className="px-6 py-3 font-medium text-slate-900"
                                            key={name}
                                        >
                                            {!!order ? (
                                                <button
                                                    className="flex items-center"
                                                    onClick={() => handleSort(name, order)}
                                                >
                                                    <span>{label}</span>
                                                    <span className="ml-2 -space-y-3">
                                                        <IconChevronUp
                                                            size={20}
                                                            className={
                                                                order == "desc"
                                                                    ? "text-slate-600"
                                                                    : "text-slate-400"
                                                            }
                                                        />
                                                        <IconChevronDown
                                                            size={20}
                                                            className={
                                                                order == "asc"
                                                                    ? "text-slate-600"
                                                                    : "text-slate-400"
                                                            }
                                                        />
                                                    </span>
                                                </button>
                                            ) : (
                                                label
                                            )}
                                        </th>
                                    ))}
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 border-t border-slate-200">
                                {rows.map(row => (
                                    <tr
                                        className={classNames(
                                            exists(row)
                                                ? "opacity-20"
                                                : "cursor-pointer hover:bg-slate-50"
                                        )}
                                        key={row.key}
                                    >
                                        {columns.map(({name: column}) => {
                                            const {type, ...props} = row.fields.find(
                                                ({name}) => name === column
                                            );

                                            const Cell = CellFactory.make(type);
                                            return (
                                                <td
                                                    onClick={() => handleChange(row)}
                                                    className="px-6 py-3"
                                                    key={`${column}_${row.key}`}
                                                >
                                                    <Cell {...props} />
                                                </td>
                                            );
                                        })}
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </Dialog.Panel>
                </div>
            </Dialog>
        </React.Fragment>
    );
}
