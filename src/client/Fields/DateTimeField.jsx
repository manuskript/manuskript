import InputField from "./InputField";

export default function DateTimeField({name, value, onChange, readOnly, ...props}) {
    function handleChange(e) {
        if (readOnly) return;

        onChange(name, e.target.value);
    }

    return (
        <InputField
            readOnly={readOnly}
            id={name}
            type="datetime-local"
            value={value}
            name={name}
            onChange={handleChange}
            {...props}
        />
    );
}
