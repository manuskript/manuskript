import classNames from "classnames";

export default function Label({className, ...props}) {
    return (
        <label
            className={classNames(className, "block text-sm font-semibold text-slate-700")}
            {...props}
        />
    );
}
