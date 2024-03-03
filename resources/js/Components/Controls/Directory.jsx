import {IconFolder} from "@tabler/icons-react";
import {forwardRef} from "react";

const Directory = forwardRef(({as: Element = "div", className, name, ...props}, ref) => (
    <Element ref={ref} {...props}>
        <IconFolder size={24} className="mx-auto" />
        <span title={name} className="block truncate text-center text-sm text-slate-500">
            {name}
        </span>
    </Element>
));

export default Directory;
