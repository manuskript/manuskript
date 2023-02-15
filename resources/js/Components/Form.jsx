import {IconAsteriskSimple} from "@tabler/icons-react";
import classNames from "classnames";
import {forwardRef} from "react";
import * as Controls from "~/Components/Controls";

const Form = forwardRef(({as: Element = "form", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "w-full divide-y divide-slate-100")} {...props} />
));

Form.Section = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "space-y-2 p-6 xl:flex xl:space-x-6 xl:space-y-0")}
        {...props}
    />
));

export default Form;

export const Label = forwardRef(({as: Element = "label", className, required, children, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "block whitespace-nowrap text-sm font-semibold text-slate-700")}
        {...props}
    >
        {children}
        {required && <IconAsteriskSimple className="inline align-top text-red-500" size={8} />}
    </Element>
));

export const Field = forwardRef(({type, ...props}, ref) => {
    let Control;

    switch (type) {
        case "checkbox":
            Control = Controls.Checkbox;
            break;

        default:
            Control = Controls.Input;
            break;
    }

    return <Control type={type} {...props} />;
});
