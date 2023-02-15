import classNames from "classnames";
import React from "react";

export default React.forwardRef(({as: Element = "input", className, readOnly, ...props}, ref) => (
    <Element
        ref={ref}
        readOnly={readOnly}
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
