import classNames from "classnames";
import React from "react";

export default React.forwardRef(
    ({as: Element = "button", primary = false, className, disabled, ...props}, ref) => (
        <Element
            ref={ref}
            className={classNames(
                className,
                {
                    "ml-auto border-blue-400 bg-slate-50 text-blue-600 hover:bg-blue-100": primary,
                    "opacity-10": disabled,
                },
                "flex cursor-pointer items-center justify-center space-x-1 rounded-lg border px-4 py-2"
            )}
            disabled={disabled}
            {...props}
        />
    )
);
