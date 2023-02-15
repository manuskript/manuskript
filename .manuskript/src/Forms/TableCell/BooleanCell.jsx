import classNames from "classnames";

export default function BooleanCell({value}) {
    return (
        <span
            className={classNames(
                "block h-3 w-3 rounded-full border",
                value ? "border-blue-400 bg-blue-400" : "border-slate-400"
            )}
        />
    );
}
