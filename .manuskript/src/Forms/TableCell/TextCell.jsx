import {IconLineDashed} from "@tabler/icons-react";

export default function TextCell({value}) {
    return !!value ? (
        <div>{value.length > 32 ? `${value.substring(0, 32)}…` : value}</div>
    ) : (
        <IconLineDashed className="text-slate-300" />
    );
}
