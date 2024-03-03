import {Link} from "@inertiajs/react";
import classNames from "classnames";
import {forwardRef} from "react";

const Breadcrumb = forwardRef(({as: Element = "ul", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "flex divide-x divide-slate-200 text-slate-400")} {...props} />
));

Breadcrumb.Item = forwardRef(({as: Element = "li", active, className, ...props}, ref) => {
    const InnerElement = active ? "span" : Link;

    return (
        <Element ref={ref} className={classNames(className, "px-5 py-2 text-sm")}>
            <InnerElement
                className={classNames(
                    "border-b border-transparent",
                    active ? "text-slate-600" : "hover:border-blue-600 hover:text-slate-600"
                )}
                {...props}
            />
        </Element>
    );
});

export default Breadcrumb;
