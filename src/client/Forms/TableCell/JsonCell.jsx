import {IconCodeDots, IconLineDashed} from "@tabler/icons-react";

export default function JsonCell({value}) {
    return !!value ? (
        <IconCodeDots className="text-slate-400" size={20} />
    ) : (
        <IconLineDashed className="text-slate-300" />
    );
}
