import classNames from "classnames";
import {forwardRef} from "react";

const Input = forwardRef(({className, readOnly, onChange, ...props}, ref) => (
    <input
        ref={ref}
        readOnly={readOnly}
        onChange={e => onChange(e.target.value)}
        className={classNames(
            className,
            "w-full rounded border border-slate-200 px-3 py-2 outline-none focus:ring-0",
            readOnly
                ? "bg-slate-100 focus:border-slate-200"
                : "bg-white shadow-slate-200 focus:border-slate-300 focus:shadow"
        )}
        {...props}
    />
));

export default Input;
