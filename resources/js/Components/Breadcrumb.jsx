import {Link} from "@inertiajs/react";
import classNames from "classnames";
import {forwardRef} from "react";

const Breadcrumb = forwardRef(({as: Element = "ul", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "flex text-slate-400 overflow-hidden")} {...props} />
));

Breadcrumb.Item = forwardRef(({as: Element = "li", active, className, ...props}, ref) => {
    const InnerElement = active ? "span" : Link;

    return (
        <Element ref={ref} className={classNames(className, "overflow-hidden rounded-t")}>
            <InnerElement
                className={classNames(
                    "truncate px-5 py-2 text-sm block",
                    active ? "bg-white text-slate-600" : "hover:text-slate-600"
                )}
                {...props}
            />
        </Element>
    );
});

export default Breadcrumb;
