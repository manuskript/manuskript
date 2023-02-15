import {router} from "@inertiajs/react";
import React, {useEffect, useState} from "react";
import Button from "../Components/Button";
import Card from "../Components/Card";
import Form from "../Forms/Resource";
import Layout from "../Layout";

const Edit = ({data, ...props}) => {
    const [values, setValues] = useState({});

    const {fields} = data;

    console.log("render", values);

    useEffect(() => {
        const initial = fields.reduce((data, {name, value, type}) => {
            data[name] = value;
            return data;
        }, {});

        setValues(initial);
    }, []);

    function handleChange(key, value) {
        setValues({...values, [key]: value});
    }

    function handleSave(e) {
        e.preventDefault();

        router.patch(router.page.url, values);
    }

    return (
        <React.Fragment>
            <Button primary onClick={handleSave}>
                Save
            </Button>
            <Card className="my-10 overflow-y-scroll">
                <Form fields={fields} values={values} onChange={handleChange} />
            </Card>
        </React.Fragment>
    );
};

Edit.layout = page => <Layout children={page} />;

export default Edit;
