import {Menu} from "@headlessui/react";
import {IconArrowDown, IconArrowUp, IconSquareRoundedPlus, IconTrash} from "@tabler/icons-react";
import classNames from "classnames";
import React, {useEffect, useState} from "react";
import DropDown, {DropDownItem, DropDownList} from "../Components/DropDown";
import Label from "../Components/Label";
import Factory from "./Factory";

function AddFieldButton({position = null, className, blocks, onClick}) {
    return (
        <div className={classNames(className, "flex justify-center")}>
            <Menu as={DropDown}>
                <Menu.Button className="flex">
                    <IconSquareRoundedPlus size={22} />
                </Menu.Button>
                <Menu.Items as={DropDownList} className="min-w-[128px]">
                    {blocks.map(field => (
                        <Menu.Item
                            as={DropDownItem}
                            key={field.name + "_menu"}
                            onClick={() => onClick(field, position)}
                        >
                            {field.label}
                        </Menu.Item>
                    ))}
                </Menu.Items>
            </Menu>
        </div>
    );
}

export default function Repeat({name, value: values, onChange, decorators, className, readOnly}) {
    const {blocks} = decorators;

    const [fields, setFields] = useState([]);

    const schema = blocks.reduce((data, block) => {
        data[block.name] = block;
        return data;
    }, {});

    const availables = Object.keys(schema);

    useEffect(() => {
        const initial = normalizeValues(values ?? []);

        setFields(
            initial.map(({name, value}) => {
                if (!availables.includes(name)) {
                    return console.error(name, "Matching block not found.");
                }

                return {...schema[name], value};
            })
        );
    }, [values]);

    function normalizeValues(values) {
        if (Array.isArray(values)) {
            return values;
        }

        try {
            return normalizeValues(JSON.parse(values));
        } catch {
            console.error("name", "Unsupported value type.");

            return [];
        }
    }

    function sync(fields) {
        if (!onChange) return;

        setFields(fields);
        onChange(
            name,
            fields.map(({name, value}) => ({name, value}))
        );
    }

    function remove(position) {
        if (!confirm("Are you sure you want to delete this item?")) {
            return;
        }

        const clone = [...fields];
        delete clone[position];

        sync(clone.filter(obj => obj));
    }

    function moveDown(position) {
        const a = fields[position];
        const b = fields[position + 1];

        const sorted = [...fields];
        sorted[position] = b;
        sorted[position + 1] = a;

        sync(sorted);
    }

    function moveUp(position) {
        const a = fields[position];
        const b = fields[position - 1];

        const sorted = [...fields];
        sorted[position] = b;
        sorted[position - 1] = a;

        sync(sorted);
    }

    function addField(field, position) {
        const updatedFields = [...fields];

        if (position == null) {
            updatedFields.push(field);
        } else {
            updatedFields.splice(position, 0, field);
        }

        setFields(updatedFields);
    }

    function handleChange([k, v], i) {
        const updatedFields = [...fields];
        updatedFields[i] = {...fields[i], value: v};

        sync(updatedFields);
    }

    return (
        <div className={className}>
            {fields.map(({type, label, ...props}, i) => {
                const Field = Factory.make(type);

                return (
                    <React.Fragment key={props.name + i}>
                        {!readOnly && (
                            <AddFieldButton blocks={blocks} onClick={addField} position={i} />
                        )}

                        <div className="my-1 overflow-hidden rounded border border-slate-200 bg-slate-50">
                            <div className="flex items-center justify-between border-b border-slate-200 px-3">
                                <Label className="py-2">{label}</Label>
                                {!readOnly && (
                                    <div className="flex space-x-3">
                                        {i > 0 && (
                                            <button onClick={() => moveUp(i)}>
                                                <IconArrowUp size={20} />
                                            </button>
                                        )}
                                        {i < fields.length - 1 && (
                                            <button onClick={() => moveDown(i)}>
                                                <IconArrowDown size={20} />
                                            </button>
                                        )}
                                        <div className="flex items-center border-l border-slate-200 py-2">
                                            <button className="ml-3" onClick={() => remove(i)}>
                                                <IconTrash size={20} />
                                            </button>
                                        </div>
                                    </div>
                                )}
                            </div>
                            <Field
                                readOnly={readOnly}
                                className="w-full p-3"
                                id={props.name + i}
                                onChange={(...args) => handleChange(args, i)}
                                {...props}
                            />
                        </div>
                    </React.Fragment>
                );
            })}
            {!readOnly && <AddFieldButton blocks={blocks} onClick={addField} />}
        </div>
    );
}
