import Form, {Field, Label} from "~/Components/Form";

export default function ResourceFields({fields = {}, onChange}) {
    return (
        <Form>
            {Object.entries(fields).map(([name, {label, required, ...props}]) => (
                <Form.Section key={name}>
                    <div className="w-80">
                        <Label required={required} htmlFor={name}>
                            {label}
                        </Label>
                    </div>
                    <div className="w-full">
                        <Field id={name} required={required} onChange={value => onChange(name, value)} {...props} />
                    </div>
                </Form.Section>
            ))}
        </Form>
    );
}
