import {Link} from "@inertiajs/react";
import {IconEye, IconLinkOff} from "@tabler/icons-react";
import React, {useEffect, useRef} from "react";
import CreateResource from "../Components/CreateResource";
import SelectResource from "../Components/SelectResource";
import CellFactory from "../Forms/TableCell/Factory";
import {useRelation} from "../Resources/Relation";

export default function Relation({
    name,
    label,
    value: entries,
    readOnly,
    onChange,
    context,
    decorators = {},
    resource,
    ...props
}) {
    const isCollection = Array.isArray(entries);

    const items = makeCollection();

    const {assign, create} = useRelation(resource, name);

    const type = decorators.type;

    const unlinkable = useRef();

    useEffect(() => {
        unlinkable.current =
            ["BelongsTo", "BelongsToMany", "MorphToMany"].includes(type) || context === "create";
    }, [decorators, context]);

    function makeCollection() {
        if (!entries) {
            return [];
        }

        return isCollection ? entries : [entries];
    }

    function handleChange(value) {
        onChange(name, isCollection ? [...entries, value] : value);
    }

    function unlink(value) {
        onChange(name, isCollection ? [...entries.filter(({key}) => key != value)] : null);
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
                                        {unlinkable.current && !readOnly && (
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
                    <div className="mt-2 flex space-x-6">
                        <SelectResource selected={items} onChange={handleChange} {...assign} />
                        {!!decorators.allowCreating && (
                            <CreateResource onChange={handleChange} {...create} />
                        )}
                    </div>
                )}
            </div>
        </React.Fragment>
    );
}
