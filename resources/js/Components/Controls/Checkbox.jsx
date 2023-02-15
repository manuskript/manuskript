import classNames from "classnames";
import {forwardRef} from "react";

const Checkbox = forwardRef(({className, ...props}, ref) => (
    <input
        {...props}
        type="checkbox"
        ref={ref}
        className={classNames(
            className,
            "h-4 w-4 rounded border border-slate-300 bg-slate-100 text-blue-500 focus:ring-0"
        )}
    />
));

export default Checkbox;
