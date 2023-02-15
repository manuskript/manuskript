import {Link, router} from "@inertiajs/react";
import {IconChevronDown, IconChevronUp} from "@tabler/icons-react";
import {useEffect, useRef} from "react";
import Card from "../Components/Card";
import Checkbox from "../Components/Checkbox";
import {Links, PerPage} from "../Components/Pagination";
import Factory from "./TableCell/Factory";

export default function Table({
    columns,
    links,
    rows,
    meta,
    selected,
    filter,
    perPage,
    onToggle,
    onToggleAll,
    ...props
}) {
    const bulkToogle = useRef();

    const isIndeterminate = !!selected.length && selected.length !== rows.length;

    useEffect(() => {
        bulkToogle.current.indeterminate = isIndeterminate;
    }, [selected]);

    function currentSort() {
        const candidates = columns.filter(({order}) => !!order && order !== "none");

        if (!candidates.length) {
            return {};
        }

        return candidates[0];
    }

    function handlePerPage(count) {
        const {name: sortBy, order: dir} = currentSort();

        router.visit(meta.path, {
            method: "get",
            data: {
                filter,
                sortBy,
                dir,
                perPage: count,
            },
        });
    }

    function handleSort(column, order) {
        router.visit(meta.path, {
            method: "get",
            data: {
                filter,
                sortBy: column,
                dir: order == "asc" ? "desc" : "asc",
                perPage: meta.per_page,
            },
        });
    }

    return (
        <Card {...props}>
            <table className="w-full table-auto border-collapse bg-white text-left text-sm">
                <thead className="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th className="w-10 px-6 py-3">
                            <Checkbox
                                ref={bulkToogle}
                                checked={selected.length === rows.length}
                                onChange={onToggleAll}
                            />
                        </th>
                        {columns.map(({name, label, order}) => (
                            <th className="px-6 py-3 font-medium text-slate-900" key={name}>
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
                        <tr className="hover:bg-slate-50" key={row.key}>
                            <td className="w-10 px-6 py-3">
                                <Checkbox
                                    value={row.key}
                                    checked={selected.includes(row.key.toString())}
                                    onChange={onToggle}
                                />
                            </td>
                            {columns.map(({name: column}) => {
                                const {type, ...props} = row.fields.find(
                                    ({name}) => name === column
                                );

                                const Cell = Factory.make(type);
                                return (
                                    <Link
                                        href={row.url}
                                        as="td"
                                        className="px-6 py-3 hover:cursor-pointer"
                                        key={`${column}_${row.key}`}
                                    >
                                        <Cell {...props} />
                                    </Link>
                                );
                            })}
                        </tr>
                    ))}
                </tbody>
            </table>
            <div className="flex justify-between border-t border-slate-200 px-6 py-2 text-sm">
                <Links
                    current={meta.current_page}
                    last={meta.last_page}
                    next={links.next}
                    prev={links.prev}
                />
                <PerPage
                    className="ml-2"
                    items={perPage}
                    current={meta.per_page}
                    onChange={handlePerPage}
                />
            </div>
        </Card>
    );
}
