import {Menu} from "@headlessui/react";
import {Link, router} from "@inertiajs/react";
import {IconFilter, IconSettings, IconTrash} from "@tabler/icons-react";
import classNames from "classnames";
import React, {useState} from "react";
import Button from "../Components/Button";
import DropDown, {DropDownButton, DropDownItem, DropDownList} from "../Components/DropDown";
import Flag from "../Components/Flag";
import Head from "../Components/Head";
import Search from "../Components/Search";
import Table from "../Forms/Table";
import Layout from "../Layout";

const Index = ({
    columns,
    rows,
    filters = [],
    actions = [],
    softDeletes,
    perPage,
    meta,
    links,
    label,
    urls,
    can,
    resource,
    searchable,
    ...props
}) => {
    const [selected, setSelected] = useState([]);

    const [filter, setFilter] = useState(
        filters.filter(({active}) => active).map(({name}) => name)
    );

    const requiresConsent = ["consent", "danger"];

    function handleFilter(e) {
        e.preventDefault();

        router.visit(urls.current, {
            method: "get",
            data: {filter, perPage: meta.per_page},
            only: ["rows", "filters", "meta", "links"],
        });
    }

    function handleSearch(q) {
        router.visit(urls.current, {
            method: "get",
            data: {filter, q, perPage: meta.per_page},
            only: ["rows", "filters", "meta", "links"],
            preserveState: true,
            preserveScroll: true,
        });
    }

    function handleAction({name, label: action, level}) {
        router.visit(`${urls.current}/actions/${name}`, {
            method: "post",
            data: {models: selected},
            only: ["rows", "meta", "links"],
            onBefore: () =>
                requiresConsent.includes(level) &&
                confirm(
                    `Are you sure you want to run the "${action}" action on ${selected.length} entries?`
                ),
        });
    }

    function updateFilter(e) {
        function add(value) {
            setFilter([...filter, value]);
        }

        function remove(value) {
            setFilter(filter.filter(current => current !== value));
        }

        filter.includes(e.target.value) ? remove(e.target.value) : add(e.target.value);
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
                        <span className="px-3 font-semibold text-blue-500">
                            All{" "}
                            <span className="ml-1 rounded-md border bg-white p-1 text-xs text-slate-600">
                                {meta.total}
                            </span>
                        </span>
                        {softDeletes && (
                            <Link className="px-3" href={`${urls.current}/trashed`}>
                                Trash
                            </Link>
                        )}
                    </div>
                    {searchable && <Search onSearch={handleSearch} />}
                </div>
                <div className="flex items-center space-x-5">
                    {!!selected.length && (
                        <div className="flex items-center">
                            {selected.length} {selected.length > 1 ? "Entry" : "Entries"} selected.
                            {!!actions.length && (
                                <Menu as={DropDown} className="ml-2">
                                    <Menu.Button
                                        as={DropDownButton}
                                        className="border-slate-200 p-2"
                                    >
                                        <IconSettings size={20} />
                                    </Menu.Button>
                                    <Menu.Items
                                        className="min-w-[196px] text-left"
                                        as={DropDownList}
                                    >
                                        {actions.map(action => (
                                            <Menu.Item
                                                className={classNames("flex", {
                                                    "text-red-500": action.level === "danger",
                                                })}
                                                key={action.name}
                                                as={DropDownItem}
                                                onClick={() => handleAction(action)}
                                            >
                                                {action.name === "destroy" && (
                                                    <IconTrash size={20} className="mr-2" />
                                                )}
                                                {action.label}
                                            </Menu.Item>
                                        ))}
                                    </Menu.Items>
                                </Menu>
                            )}
                        </div>
                    )}

                    {!!filters.length && (
                        <Menu as={DropDown}>
                            <Menu.Button as={DropDownButton} className="border-slate-200 p-2">
                                <Flag active={!!filters.filter(({active}) => active).length}>
                                    <IconFilter size={20} />
                                </Flag>
                            </Menu.Button>
                            <Menu.Items className="min-w-[196px] text-left" as={DropDownList}>
                                <div className="max-h-96 space-y-2  overflow-y-auto p-2 font-normal">
                                    {filters.map(({label, name}) => (
                                        <label className="block" key={name} htmlFor={name}>
                                            <input
                                                className="mr-1"
                                                id={name}
                                                value={name}
                                                type="checkbox"
                                                onChange={updateFilter}
                                                checked={filter.includes(name)}
                                            />{" "}
                                            {label}
                                        </label>
                                    ))}
                                </div>
                                <button
                                    className="block w-full bg-slate-50 p-2 text-center hover:bg-slate-100"
                                    onClick={handleFilter}
                                >
                                    Apply
                                </button>
                            </Menu.Items>
                        </Menu>
                    )}

                    {can.create && (
                        <Button primary as={Link} href={urls.create}>
                            New {label}
                        </Button>
                    )}
                </div>
            </div>

            <Table
                className="my-10 overflow-hidden"
                columns={columns}
                rows={rows}
                meta={meta}
                links={links}
                perPage={perPage}
                filter={filter}
                selected={selected}
                onToggle={toggle}
                onToggleAll={toggleAll}
            />
        </React.Fragment>
    );
};

Index.layout = page => <Layout children={page} />;

export default Index;
