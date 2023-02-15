import {Dialog} from "@headlessui/react";
import {
    IconChevronDown,
    IconChevronLeft,
    IconChevronRight,
    IconChevronUp,
    IconLink,
} from "@tabler/icons-react";
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
    console.log(pagination, next);
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
                <IconLink className="mr-1" size={16} /> Link entry
            </button>

            <Dialog open={open} onClose={() => setOpen(false)}>
                <div className="fixed inset-0 z-20 flex justify-end bg-slate-300/40 pl-20">
                    <Dialog.Panel className="flex h-full w-full max-w-4xl flex-col justify-between overflow-y-scroll bg-white shadow-lg">
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
                        <div className="flex items-center space-x-5 border-t border-slate-200 bg-slate-50 px-6 py-3">
                            <span>
                                {pagination.current_page} of {pagination.last_page}
                            </span>
                            <button
                                className={classNames("flex items-center", {
                                    "cursor-not-allowed text-slate-300": !pagination.prev,
                                })}
                                onClick={prev}
                            >
                                <IconChevronLeft size={16} className="mr-1" /> Prev
                            </button>
                            <button
                                className={classNames("flex items-center", {
                                    "cursor-not-allowed text-slate-300": !pagination.next,
                                })}
                                onClick={next}
                            >
                                Next <IconChevronRight size={16} className="ml-1" />
                            </button>
                        </div>
                    </Dialog.Panel>
                </div>
            </Dialog>
        </React.Fragment>
    );
}
