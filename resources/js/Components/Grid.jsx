import classNames from "classnames";
import {forwardRef} from "react";

const Grid = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "w-full bg-white text-left text-sm")} {...props} />
));

Grid.Head = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "border-b border-slate-200 bg-slate-50 font-medium text-slate-700")}
        {...props}
    />
));

Grid.Body = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "grid")} {...props} />
));

Grid.Item = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "p-5 hover:bg-slate-50")} {...props} />
));

export default Grid;
