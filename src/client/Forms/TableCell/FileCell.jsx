import {IconFile, IconLineDashed} from "@tabler/icons-react";

export default function FileCell({value}) {
    return !!value ? (
        <div className="-my-1 flex items-center space-x-2">
            <IconFile size={20} className="text-slate-400" />
            <span className="block text-sm">{value}</span>
        </div>
    ) : (
        <IconLineDashed className="text-slate-300" />
    );
}
