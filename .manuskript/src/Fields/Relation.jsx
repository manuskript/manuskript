import {Link} from "@inertiajs/react";
import {IconEye} from "@tabler/icons-react";
import React from "react";
import SelectResource from "../Components/SelectResource";
import CellFactory from "../Forms/TableCell/Factory";
import {useRelation} from "../Resources/Relation";

export default function Relation({name, value: entries, readOnly, onChange, ...props}) {
    const isCollection = Array.isArray(entries);

    const items = makeCollection();

    const resource = useRelation(name);

    function makeCollection() {
        if (!entries) {
            return [];
        }

        return isCollection ? entries : [entries];
    }

    function handleChange(value) {
        onChange(name, isCollection ? [...entries, value] : value);
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
                                    className="flex justify-between rounded border border-slate-200 bg-slate-50 py-2 px-3"
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
                                    <Link
                                        className="flex items-center text-sm text-slate-500"
                                        href={url}
                                    >
                                        Open <IconEye size={18} className="ml-2" />
                                    </Link>
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
