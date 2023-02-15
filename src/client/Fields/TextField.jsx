import InputField from "./InputField";

export default function TextField({name, value, onChange, ...props}) {
    function handleChange(e) {
        if (!onChange) return;

        onChange(name, e.target.value);
    }

    return (
        <InputField
            type="text"
            id={name}
            name={name}
            value={value ?? ""}
            onChange={handleChange}
            {...props}
        />
    );
}
