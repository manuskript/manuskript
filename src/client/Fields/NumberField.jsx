import InputField from "./InputField";

export default function NumberField({name, value, onChange, decorators = {}, ...props}) {
    const {min, max, step} = decorators;

    function handleChange(e) {
        if (!onChange) return;

        onChange(name, e.target.value);
    }

    return (
        <InputField
            type="number"
            min={min}
            max={max}
            step={step}
            id={name}
            name={name}
            value={value ?? ""}
            onChange={handleChange}
            {...props}
        />
    );
}
