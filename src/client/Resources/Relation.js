import axios from "axios";
import {useEffect, useState} from "react";
import {fetchFields, fetchResources} from "./Resource";

export function useRelation(resource, method) {
    const [fields, setFields] = useState({
        fields: [],
        resource: "",
    });

    function updateFields(url) {
        fetchFields(url).then(data => setFields(data));
    }

    const [values, setValues] = useState({});

    const [processing, setProcessing] = useState(false);

    useEffect(() => {
        const initial = fields.fields.reduce((data, {name}) => {
            data[name] = null;
            return data;
        }, {});

        setValues(initial);
    }, [fields]);

    function handleChange(key, value) {
        setValues({...values, [key]: value});
    }

    const [response, setResponse] = useState();
    const [errors, setErrors] = useState({});

    function handleSave(e) {
        e.preventDefault();
        axios
            .post(route("manuskript.relations.store", {resource, method}), values)
            .then(({data}) => setResponse(data))
            // TODO: Handle errors.
            .catch(errors => console.log(errors));
    }

    const [linkable, setLinkable] = useState({
        rows: [],
        columns: [],
        pagination: {
            current_page: null,
            last_page: null,
            next: null,
            prev: null,
        },
    });

    function updateLinkable(url) {
        fetchResources(url).then(data => setLinkable(data));
    }

    function next() {
        if (!linkable.pagination.next) {
            return;
        }
        updateLinkable(linkable.pagination.next);
    }

    function prev() {
        if (!linkable.pagination.prev) {
            return;
        }
        updateLinkable(linkable.pagination.prev);
    }

    function initLinkable() {
        updateLinkable(route("manuskript.relations.index", {resource, method}));
    }

    function initCreate() {
        updateFields(route("manuskript.relations.create", {resource, method}));
    }

    return {
        assign: {
            ...linkable,
            next,
            prev,
            init: initLinkable,
        },
        create: {
            ...fields,
            processing,
            values,
            response,
            errors,
            handleChange,
            handleSave,
            init: initCreate,
        },
    };
}
