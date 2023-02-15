import classNames from "classnames";
import React from "react";

export default React.forwardRef(({as: Element = "input", className, readOnly, ...props}, ref) => (
    <Element
        ref={ref}
        readOnly={readOnly}
        className={classNames(
            className,
            "w-full rounded border py-2 px-3 outline-none",
            readOnly ? "bg-slate-100" : "bg-white shadow-slate-200 focus:shadow"
        )}
        {...props}
    />
));
