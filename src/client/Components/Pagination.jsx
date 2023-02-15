import {Link} from "@inertiajs/react";
import {IconChevronLeft, IconChevronRight} from "@tabler/icons-react";
import classNames from "classnames";

export function PerPage({items, current, onChange, ...props}) {
    return (
        <div className="flex space-x-4">
            <span>Per Page:</span>
            {items.map(item => (
                <button
                    className={current === item ? "text-slate-500 underline" : "text-slate-400"}
                    key={item}
                    onClick={() => onChange(item)}
                >
                    {item}
                </button>
            ))}
        </div>
    );
}

export function Links({current, last, next, prev}) {
    return (
        <div className="flex items-center space-x-5">
            <span>
                {current} of {last}
            </span>
            <Link
                className={classNames("flex items-center", {
                    "cursor-not-allowed text-slate-300": !prev,
                })}
                href={prev}
                preserveState
            >
                <IconChevronLeft size={16} className="mr-1" /> Prev
            </Link>
            <Link
                className={classNames("flex items-center", {
                    "cursor-not-allowed text-slate-300": !next,
                })}
                href={next}
                preserveState
            >
                Next <IconChevronRight size={16} className="ml-1" />
            </Link>
        </div>
    );
}
