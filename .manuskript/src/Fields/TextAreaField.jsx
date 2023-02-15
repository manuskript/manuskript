import {useEffect, useRef} from "react";
import InputField from "./InputField";

export default function TextAreaField({name, value, onChange, ...props}) {
    const ref = useRef();

    useEffect(() => {
        if (ref) {
            ref.current.style.height = "0px";
            const scrollHeight = ref.current.scrollHeight;

            ref.current.style.height = scrollHeight + "px";
        }
    }, [ref, value]);

    function handleChange(e) {
        if (!onChange) return;

        onChange(name, e.target.value);
    }

    return (
        <InputField
            ref={ref}
            as="textarea"
            id={name}
            name={name}
            value={value ?? ""}
            onChange={handleChange}
            {...props}
        />
    );
}
