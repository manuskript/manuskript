import {router} from "@inertiajs/react";
import React, {useEffect, useState} from "react";
import Button from "../Components/Button";
import Card from "../Components/Card";
import Form from "../Forms/Resource";
import Layout from "../Layout";

const Edit = ({fields, ...props}) => {
    const [values, setValues] = useState({});

    useEffect(() => {
        const initial = fields.reduce((data, {name}) => {
            data[name] = null;
            return data;
        }, {});

        setValues(initial);
    }, []);

    function handleChange(key, value) {
        setValues({...values, [key]: value});
    }

    function handleSave(e) {
        e.preventDefault();

        router.post(router.page.url, values);
    }

    return (
        <React.Fragment>
            <Button primary onClick={handleSave}>
                Save
            </Button>
            <Card className="my-10">
                <Form fields={fields} values={values} onChange={handleChange} />
            </Card>
        </React.Fragment>
    );
};

Edit.layout = page => <Layout children={page} />;

export default Edit;
