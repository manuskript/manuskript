import {createInertiaApp} from "@inertiajs/react";
import {createRoot} from "react-dom/client";

createInertiaApp({
    resolve: name => require(`./Views/${name}`),
    setup({el, App, props}) {
        createRoot(el).render(<App {...props} />);
    },
});
