import {Head as InertiaHead, usePage} from "@inertiajs/react";

export default function Head({title, ...props}) {
    const {name} = usePage().props.app;

    return <InertiaHead title={title ? `${title} – ${name}` : name} {...props} />;
}
