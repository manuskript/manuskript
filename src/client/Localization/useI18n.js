import {usePage} from "@inertiajs/react";

export function useI18n() {
    const locale = usePage().props.app.locale;

    function __(key, overrides) {
        return key;
    }

    return {__, locale};
}
