import classNames from "classnames";

export default function Flag({active = false, className, children, ...props}) {
    return (
        <span className={classNames(className, "relative block")} {...props}>
            {children}
            {active && <span className="absolute right-0 top-0 h-2 w-2 rounded-full bg-blue-500" />}
        </span>
    );
}
