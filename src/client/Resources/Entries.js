import {usePage} from "@inertiajs/react";
import {useState} from "react";
import {fetchResources} from "./Resource";

export function useEntries(resource, fields = []) {
    const root = usePage().props.base;

    const query = fields.reduce((a, b) => {
        return a.length ? a.concat("&", "field[]=", b) : a.concat("?", "field[]=", b);
    }, "");

    const [data, setData] = useState({
        rows: [],
        columns: [],
        pagination: {
            current_page: null,
            last_page: null,
            next: null,
            prev: null,
        },
    });

    function updateData(url) {
        fetchResources(url).then(response => setData(response));
    }

    function next() {
        if (!data.pagination.next) {
            return;
        }
        updateData(data.pagination.next);
    }

    function prev() {
        if (!data.pagination.prev) {
            return;
        }
        updateData(data.pagination.prev);
    }

    function init(ids = []) {
        const params = ids.reduce((a, b) => {
            return a.length ? a.concat("&", "ids[]=", b) : a.concat("?", "ids[]=", b);
        }, query);

        return updateData(`/${root}/api/${resource}${params}`);
    }

    return {...data, init, next, prev};
}
