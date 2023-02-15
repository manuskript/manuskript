import classNames from "classnames";

export default function Card({as: Element = "div", className, ...props}) {
    return (
        <Element
            className={classNames(className, "rounded-lg border border-slate-200")}
            {...props}
        />
    );
}
