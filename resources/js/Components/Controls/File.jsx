import {IconFile} from "@tabler/icons-react";
import {forwardRef} from "react";

const File = forwardRef(({as: Element = "div", className, name, ...props}, ref) => (
    <Element ref={ref} {...props}>
        <IconFile size={24} className="mx-auto" />
        <span title={name} className="block truncate text-center text-sm text-slate-500">
            {name}
        </span>
    </Element>
));

export default File;
