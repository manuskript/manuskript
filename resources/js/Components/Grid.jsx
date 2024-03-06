import classNames from "classnames";
import {forwardRef} from "react";

const Grid = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "grid w-full")} {...props} />
));

Grid.Item = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "p-5 hover:bg-slate-50")} {...props} />
));

export default Grid;
