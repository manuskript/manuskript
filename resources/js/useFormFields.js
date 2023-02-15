import { useState } from "react";

export function useFormFields(initial = []) {
    const [fields, setFields] = useState(
        [...initial].reduce((state, field) => {
            state[field.name] = field;
            return state;
        }, {})
    )

    const data = Object.entries(fields)
        .reduce((payload, [key, field]) => {
            payload[key] = field.value;
            return payload;
        }, {});

    function setData(key, value) {
        setFields(current => {
            return {...current, [key]: {...current[key], value}}
        });
    }

    return { data, setData, fields };
}
