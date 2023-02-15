import {IconChevronDown} from "@tabler/icons-react";
import classNames from "classnames";
import React from "react";

export default React.forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "relative")} {...props} />
));

export const DropDownButton = React.forwardRef(
    ({as: Element = "button", className, children, ...props}, ref) => (
        <Element
            ref={ref}
            className={classNames(className, "flex items-center space-x-1 rounded-lg border")}
            {...props}
        >
            <span>{children}</span>
            <IconChevronDown size={16} />
        </Element>
    )
);

export const DropDownList = React.forwardRef(
    ({as: Element = "div", className, children, ...props}, ref) => (
        <Element
            ref={ref}
            className={classNames(className, "absolute right-0 z-10 origin-top-right pt-2")}
            {...props}
        >
            <div className="relative rounded border border-slate-200 bg-white shadow-lg shadow-slate-200">
                <span
                    aria-hidden="true"
                    className="absolute right-0 mr-2.5 h-3 w-3 -translate-y-1/2 rotate-45 border-l border-t border-slate-200 bg-white"
                ></span>
                <div className="relative divide-y divide-slate-200 overflow-hidden rounded">
                    {children}
                </div>
            </div>
        </Element>
    )
);

export const DropDownItem = React.forwardRef(
    ({as: Element = "button", className, ...props}, ref) => (
        <Element
            ref={ref}
            className={classNames(
                className,
                "block w-full px-3 py-2 text-sm font-normal hover:bg-slate-50"
            )}
            {...props}
        />
    )
);
