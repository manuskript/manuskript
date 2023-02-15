import {IconLineDashed} from "@tabler/icons-react";

export default function ImageCell({value, decorators}) {
    const {thumbnail, url} = decorators ?? {};

    const preview = thumbnail ?? url;

    return !!value ? (
        <div className="-my-1 flex items-center space-x-2">
            <div className="h-9 w-9 flex-shrink-0 overflow-hidden rounded border border-slate-300 bg-slate-200">
                {!!preview && <img src={preview} className="block h-full w-full object-cover" />}
            </div>
            <span className="block text-sm">{value}</span>
        </div>
    ) : (
        <IconLineDashed className="text-slate-300" />
    );
}
