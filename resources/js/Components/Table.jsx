import classNames from "classnames";
import {forwardRef} from "react";

const Table = forwardRef(({as: Element = "table", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "w-full table-auto border-collapse bg-white text-left text-sm")}
        {...props}
    />
));

Table.Head = forwardRef(({as: Element = "thead", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "border-b border-slate-200 bg-slate-50 font-medium text-slate-700")}
        {...props}
    />
));

Table.Body = forwardRef(({as: Element = "tbody", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "divide-y divide-slate-100 border-t border-slate-200")}
        {...props}
    />
));

Table.Row = forwardRef(({as: Element = "tr", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "[&>td]:hover:bg-slate-50")} {...props} />
));

Table.Cell = forwardRef(({as: Element = "td", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "px-6 py-3 font-inherit")} {...props} />
));

export default Table;
