import InputField from "./InputField";

export default function EmailField({name, value, onChange, ...props}) {
    function handleChange(e) {
        if (!onChange) return;

        onChange(name, e.target.value);
    }

    return (
        <InputField
            id={name}
            type="email"
            name={name}
            value={value ?? ""}
            onChange={handleChange}
            {...props}
        />
    );
}
