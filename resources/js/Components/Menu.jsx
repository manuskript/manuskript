import {IconChevronDown, IconChevronUp} from "@tabler/icons-react";
import classNames from "classnames";
import {forwardRef} from "react";

const Menu = forwardRef(({as: Element = "dl", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "divide-y divide-slate-200")} {...props} />
));

Menu.Group = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "py-8")} {...props} />
));

Menu.Label = forwardRef(({as: Element = "dt", className, children, open, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(
            className,
            "flex cursor-pointer items-center justify-between px-8 text-xs uppercase tracking-wider text-slate-400"
        )}
        {...props}
    >
        <span>{children}</span>
        {open ? <IconChevronUp size={16} /> : <IconChevronDown size={16} />}
    </Element>
));

Menu.Panel = forwardRef(({as: Element = "dd", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "pt-6")} {...props} />
));

Menu.Items = forwardRef(({as: Element = "ul", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "space-y-6 px-8")} {...props} />
));

Menu.Link = forwardRef(({as: Element = "a", className, active, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, {"text-blue-600": active})} {...props} />
));

export default Menu;
