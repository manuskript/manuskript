import {useEffect, useState} from "react";
import InputField from "./InputField";

export default function DateTimeField({name, value, onChange, readOnly, ...props}) {
    const [datetime, setDatetime] = useState("");

    useEffect(() => {
        validate(new Date(value)).then(dt => setDatetime(normalizedIsoString(dt)));
    }, [value]);

    function normalizedIsoString(date) {
        date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        return date.toISOString().slice(0, 16);
    }

    function handleChange(e) {
        if (readOnly) return;

        validate(new Date(e.target.value)).then(dt => onChange(name, normalizedIsoString(dt)));
    }

    function validate(date) {
        return new Promise((resolve, reject) => {
            date.toString() === "Invalid Date"
                ? console.error(["Invalid Date", reject()])
                : resolve(date);
        });
    }

    return (
        <InputField
            readOnly={readOnly}
            id={name}
            type="datetime-local"
            value={datetime}
            name={name}
            onChange={handleChange}
            {...props}
        />
    );
}
