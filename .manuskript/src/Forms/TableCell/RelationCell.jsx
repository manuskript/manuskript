import {IconDatabase, IconLineDashed} from "@tabler/icons-react";
import CellFactory from "./Factory";

export default function RelationCell({value}) {
    const isCollection = Array.isArray(value);

    if (!value) {
        return <IconLineDashed className="text-slate-300" />;
    }

    if (isCollection) {
        const count = value ? value.length : 0;

        return !!count ? (
            <div className="flex items-center space-x-2">
                <IconDatabase size={20} />
                <span className="block text-sm">
                    {count} related {count == 1 ? "entry" : "entries"}
                </span>
            </div>
        ) : (
            <IconLineDashed className="text-slate-300" />
        );
    }

    return value.fields.map(({type, name, ...props}) => {
        const Cell = CellFactory.make(type);

        return <Cell key={name} name={name} {...props} />;
    });
}
