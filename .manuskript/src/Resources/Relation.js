import {usePage} from "@inertiajs/react";
import {useState} from "react";
import {fetchResources} from "./Resource";

export function useRelation(resource) {
    const baseUrl = usePage().url.split(/[?#]/)[0].substring(0, usePage().url.lastIndexOf("/"));

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
        fetchResources(url).then(data => setData(data));
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

    function init() {
        updateData(`${baseUrl}/relations/${resource}`);
    }

    return {...data, init, next, prev};
}
