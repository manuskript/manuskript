import classNames from "classnames";

export function getEditorProps(readOnly) {
    const className = classNames(
        "p-3 min-h-[120px] outline-none outline-none appearance-none w-full rounded-b border border-slate-200 prose prose-slate max-w-none",
        "prose-table:border-collapse prose-th:border prose-td:border",
        readOnly ? "bg-slate-100 rounded-t" : "bg-white focus:shadow-md shadow-slate-200"
    );

    return {
        attributes: {
            class: className,
        },
    };
}

export {default as Extensions} from "./Extensions";
