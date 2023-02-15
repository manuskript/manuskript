import {useEffect, useRef} from "react";
import Checkbox from "~/Components/Controls/Checkbox";
import Table from "~/Components/Table";

export default function ResourcesTable({columns, data, selected, selectable, onChange, onClick}) {
    const bulk = useRef();

    const allSelected = selected.length === data.length;

    useEffect(() => {
        bulk.current.indeterminate = !!selected.length && !allSelected;
    }, [selected]);

    function toggleAll() {
        if (allSelected) {
            return onChange([]);
        }

        return onChange([...data].map(({key}) => key));
    }

    function toggle(value) {
        if (selected.includes(value)) {
            return onChange([...selected].filter(v => v != value));
        }

        return onChange([...selected, value]);
    }

    return (
        <Table>
            <Table.Head>
                <Table.Row>
                    {selectable && (
                        <Table.Cell className="w-10">
                            <Checkbox checked={allSelected} onChange={toggleAll} ref={bulk} />
                        </Table.Cell>
                    )}
                    {columns.map(({label, name, order}) => (
                        <Table.Cell key={name} as="th">
                            {label}
                        </Table.Cell>
                    ))}
                </Table.Row>
            </Table.Head>
            <Table.Body>
                {data.map(({key, fields, ...props}) => (
                    <Table.Row key={key}>
                        {selectable && (
                            <Table.Cell>
                                <Checkbox checked={selected.includes(key)} onChange={() => toggle(key)} value={key} />
                            </Table.Cell>
                        )}
                        {fields.map(({name, type, value}) => (
                            <Table.Cell
                                key={`${key}-${name}`}
                                onClick={() => onClick({key, fields, ...props})}
                                className="cursor-pointer"
                            >
                                {value}
                            </Table.Cell>
                        ))}
                    </Table.Row>
                ))}
            </Table.Body>
        </Table>
    );
}
