import classNames from "classnames";
import {forwardRef} from "react";

const Layout = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "flex min-h-screen w-full items-start bg-slate-50 text-slate-600")}
        {...props}
    />
));

Layout.Sidebar = forwardRef(({as: Element = "nav", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(
            className,
            "sticky top-0 min-h-screen w-1/4 max-w-xs border-r border-slate-200 bg-slate-100"
        )}
        {...props}
    />
));

Layout.Main = forwardRef(({as: Element = "nav", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "w-full p-6")} {...props} />
));

export default Layout;