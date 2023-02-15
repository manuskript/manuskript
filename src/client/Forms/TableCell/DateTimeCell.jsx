import {IconLineDashed} from "@tabler/icons-react";
import {useI18n} from "../../Localization/useI18n";

export default function DateTimeCell({value}) {
    const {__, locale} = useI18n();

    if (!value) {
        return <IconLineDashed className="text-slate-300" />;
    }

    const date = new Date(value);

    return <div>{date.toLocaleString(locale)}</div>;
}
