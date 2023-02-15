import {Link} from "@inertiajs/react";
import {IconEye, IconLinkOff} from "@tabler/icons-react";
import React, {useEffect, useRef, useState} from "react";
import SelectResource from "../Components/SelectResource";
import CellFactory from "../Forms/TableCell/Factory";
import {useEntries} from "../Resources/Entries";

export default function EntryField({
    name,
    value: entries,
    readOnly,
    onChange,
    decorators,
    ...props
}) {
    const store = useRef({});

    const [items, setItems] = useState([]);

    const resource = useEntries(decorators.resource, decorators.columns ?? []);

    const {init: initRelations, rows: relations} = useEntries(
        decorators.resource,
        decorators.columns ?? []
    );

    useEffect(() => {
        const loaded = Object.keys(store.current);

        const diff = (Array.isArray(entries) ? entries : []).filter(
            id => !loaded.includes(id.toString())
        );

        if (diff.length) {
            initRelations(diff);
        }

        makeCollection(Array.isArray(entries) ? entries : []);
    }, [entries]);

    useEffect(() => {
        relations.forEach(entry => {
            store.current[entry.key] = entry;
        });

        makeCollection(Array.isArray(entries) ? entries : []);
    }, [relations]);

    function makeCollection(ids) {
        const items = ids.map(id => store.current[id]).filter(i => i);

        setItems(items);
    }

    function handleChange(value) {
        store.current[value.key] = value;

        onChange(name, Array.isArray(entries) ? [...entries, value.key] : [value.key]);
    }

    function unlink(value) {
        onChange(name, Array.isArray(entries) ? [...entries.filter(key => key != value)] : []);
    }

    return (
        <React.Fragment>
            <div {...props}>
                {!!entries && (
                    <div className="space-y-2">
                        {!!items &&
                            items.map(({key, fields, url}) => (
                                <div
                                    key={`${name}_${key}`}
                                    className="flex justify-between rounded border border-slate-200 bg-slate-50 px-3 py-2"
                                >
                                    <div className="flex items-center space-x-2">
                                        {fields.map(({type, name, ...props}) => {
                                            const Cell = CellFactory.make(type);

                                            return (
                                                <Cell
                                                    key={`${name}_${key}`}
                                                    name={name}
                                                    {...props}
                                                />
                                            );
                                        })}
                                    </div>
                                    <div className="flex items-center space-x-6">
                                        {!readOnly && (
                                            <button
                                                className="flex items-center text-sm text-slate-500"
                                                onClick={() => unlink(key)}
                                            >
                                                Unlink <IconLinkOff size={18} className="ml-2" />
                                            </button>
                                        )}
                                        <Link
                                            className="flex items-center text-sm text-slate-500"
                                            href={url}
                                        >
                                            Open <IconEye size={18} className="ml-2" />
                                        </Link>
                                    </div>
                                </div>
                            ))}
                    </div>
                )}
                {!readOnly && (
                    <div className="mt-2">
                        <SelectResource selected={items} onChange={handleChange} {...resource} />
                    </div>
                )}
            </div>
        </React.Fragment>
    );
}
