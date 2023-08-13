import Form, { Error, Label } from "~/Components/Form";
import Input from "~/Components/Controls/Input";
import Factory from "~/Field";


export default function ResourceFields({fields = {}, errors = {}, onChange, readOnly: globalReadOnly = false}) {
    return (
        <Form>
            {Object.entries(fields).map(([name, { label, type, required, readOnly, ...props }]) => {

                const Field = Factory.resolve(type)
                return (
                    <Form.Section key={name}>
                        <div className="w-80">
                            <Label required={required} htmlFor={name}>
                                {label}
                            </Label>
                        </div>
                        <div className="w-full">
                            <Field id={name} type={type} readOnly={readOnly ?? globalReadOnly} required={required} onChange={value => onChange(name, value)} {...props} />
                            {!!errors[name] && <Error>{errors[name]}</Error>}
                        </div>
                    </Form.Section>
                )
            })}
        </Form>
    );
}
