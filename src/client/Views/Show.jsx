import {Menu} from "@headlessui/react";
import {router} from "@inertiajs/react";
import {IconDots, IconTrash} from "@tabler/icons-react";
import React, {useEffect, useState} from "react";
import Card from "../Components/Card";
import DropDown, {DropDownItem, DropDownList} from "../Components/DropDown";
import Head from "../Components/Head";
import Form from "../Forms/Resource";
import Layout from "../Layout";

const Show = ({data, label, can, resource, model, trashed = false, ...props}) => {
    const [values, setValues] = useState({});

    const {fields} = data;

    useEffect(() => {
        const initial = fields.reduce((data, {name, value, type}) => {
            data[name] = value;
            return data;
        }, {});

        setValues(initial);
    }, []);

    function handleDelete() {
        if (trashed) {
            router.post(route("manuskript.entries.trash.destroy", {resource}), {models: [model]});
        } else {
            router.delete(route("manuskript.entries.destroy", {resource, model}));
        }
    }

    return (
        <React.Fragment>
            <Head title={label} />

            <div className="flex justify-end">
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
            </div>
            <Card className="my-10 overflow-y-scroll">
                <Form fields={fields} context="show" values={values} resource={resource} readOnly />
            </Card>
        </React.Fragment>
    );
};

Show.layout = page => <Layout children={page} />;

export default Show;
