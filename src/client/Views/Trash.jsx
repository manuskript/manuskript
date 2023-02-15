import {Link, router} from "@inertiajs/react";
import React, {useState} from "react";
import Button from "../Components/Button";
import Head from "../Components/Head";
import Search from "../Components/Search";
import Table from "../Forms/Table";
import Layout from "../Layout";

const Trash = ({
    columns,
    rows,
    actions = [],
    label,
    meta,
    links,
    softDeletes,
    perPage,
    can,
    searchable,
    ...props
}) => {
    const [selected, setSelected] = useState([]);

    function handleRestore() {
        router.visit(`${meta.path}/restore`, {
            method: "post",
            data: {models: selected},
            onBefore: () =>
                confirm(
                    `Are you sure you want to restore ${selected.length} ${
                        selected.length > 1 ? "entry" : "entries"
                    }?`
                ),
        });
    }

    function handleSearch(q) {
        router.visit(urls.current, {
            method: "get",
            data: {q, perPage: meta.per_page},
            only: ["rows", "meta", "links"],
            preserveState: true,
            preserveScroll: true,
        });
    }

    function handleDelete() {
        router.visit(`${meta.path}/destroy`, {
            method: "post",
            data: {models: selected},
            onBefore: () =>
                confirm(
                    `Are you sure you want to permanently delete ${selected.length} ${
                        selected.length > 1 ? "entry" : "entries"
                    }?`
                ),
        });
    }

    function toggle(e) {
        function add(value) {
            setSelected([...selected, value]);
        }

        function remove(value) {
            setSelected(selected.filter(current => current !== value));
        }

        selected.includes(e.target.value) ? remove(e.target.value) : add(e.target.value);
    }

    function toggleAll(e) {
        e.target.checked ? setSelected(rows.map(r => r.key.toString())) : setSelected([]);
    }

    return (
        <React.Fragment>
            <Head title={label} />

            <div className="flex items-center justify-between space-x-6">
                <div className="flex items-center space-x-6">
                    <div className="flex items-center divide-x divide-slate-400 text-sm">
                        <Link className="px-3" href={meta.path.replace("trashed", "")}>
                            All
                        </Link>
                        <span className="px-3 font-semibold text-blue-500">
                            Trash{" "}
                            <span className="ml-1 rounded-md border bg-white p-1 text-xs text-slate-600">
                                {meta.total}
                            </span>
                        </span>
                    </div>
                    {searchable && <Search onSearch={handleSearch} />}
                </div>
                {!!selected.length && (
                    <div className="flex items-center space-x-6">
                        <span>
                            {selected.length} {selected.length > 1 ? "entry" : "entries"} selected.
                        </span>
                        {can.restore && (
                            <Button className="border-slate-300" onClick={handleRestore}>
                                Restore
                            </Button>
                        )}
                        {can.delete && (
                            <Button className="border-red-500 text-red-500" onClick={handleDelete}>
                                Delete
                            </Button>
                        )}
                    </div>
                )}
            </div>
            <Table
                className="my-10 overflow-hidden"
                columns={columns}
                rows={rows}
                meta={meta}
                links={links}
                selected={selected}
                perPage={perPage}
                onToggle={toggle}
                onToggleAll={toggleAll}
            />
        </React.Fragment>
    );
};

Trash.layout = page => <Layout children={page} />;

export default Trash;
