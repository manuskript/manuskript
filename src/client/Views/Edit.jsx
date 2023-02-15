import {Menu} from "@headlessui/react";
import {router} from "@inertiajs/react";
import {IconDots, IconTrash} from "@tabler/icons-react";
import React, {useEffect, useState} from "react";
import Button from "../Components/Button";
import Card from "../Components/Card";
import DropDown, {DropDownItem, DropDownList} from "../Components/DropDown";
import Head from "../Components/Head";
import Form from "../Forms/Resource";
import Layout from "../Layout";

const Edit = ({data, label, can, errors, resource, model, ...props}) => {
    const [values, setValues] = useState({});
    const [processing, setProcessing] = useState(false);

    const {fields} = data;

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

        router.patch(router.page.url.substring(0, router.page.url.lastIndexOf("/")), values, {
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

    function handleDelete() {
        router.delete(
            route("manuskript.entries.destroy", {
                resource,
                model,
            })
        );
    }

    return (
        <React.Fragment>
            <Head title={label} />

            <div className="flex items-center justify-end space-x-5">
                {can.delete && (
                    <Menu as={DropDown}>
                        <Menu.Button className="p-2">
                            <IconDots size={20} />
                        </Menu.Button>
                        <Menu.Items className="min-w-[196px] text-left" as={DropDownList}>
                            <Menu.Item
                                className="flex text-red-500"
                                as={DropDownItem}
                                onClick={handleDelete}
                            >
                                <IconTrash size={20} className="mr-2" /> Delete
                            </Menu.Item>
                        </Menu.Items>
                    </Menu>
                )}
                <Button primary disabled={processing} onClick={handleSave}>
                    Save
                </Button>
            </div>
            <Card className="my-10 bg-white">
                <Form
                    fields={fields}
                    errors={errors}
                    context="edit"
                    resource={resource}
                    values={values}
                    onChange={handleChange}
                />
            </Card>
        </React.Fragment>
    );
};

Edit.layout = page => <Layout children={page} />;

export default Edit;
