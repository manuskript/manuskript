import {router} from "@inertiajs/react";
import React, {useEffect, useState} from "react";
import Button from "../Components/Button";
import Card from "../Components/Card";
import Head from "../Components/Head";
import Form from "../Forms/Resource";
import Layout from "../Layout";

const Create = ({fields, label, errors, resource, ...props}) => {
    const [values, setValues] = useState({});
    const [processing, setProcessing] = useState(false);

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

        router.post(router.page.url, values, {
            onStart(visit) {
                setProcessing(true);
            },
            onError(errors) {
                setProcessing(false);
            },
            onCancel() {
                setProcessing(false);
            },
            onSuccess() {
                setProcessing(false);
            },
            onFinish(page) {
                setProcessing(false);
            },
            onFinish() {
                setProcessing(false);
            },
        });
    }

    return (
        <React.Fragment>
            <Head title={label} />

            <Button disabled={processing} primary onClick={handleSave}>
                Save
            </Button>
            <Card className="my-10">
                <Form
                    fields={fields}
                    errors={errors}
                    context="create"
                    resource={resource}
                    values={values}
                    onChange={handleChange}
                />
            </Card>
        </React.Fragment>
    );
};

Create.layout = page => <Layout children={page} />;

export default Create;
