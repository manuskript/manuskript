import {Dialog} from "@headlessui/react";
import {IconCirclePlus} from "@tabler/icons-react";
import React, {useEffect, useState} from "react";
import Form from "../Forms/Resource";
import Button from "./Button";
import Card from "./Card";

export default function CreateResource({
    init,
    fields,
    resource,
    values,
    onChange,
    handleChange,
    handleSave,
    response,
    errors,
    ...props
}) {
    const [booted, setBooted] = useState(false);

    const [open, setOpen] = useState(false);

    function handleOpen() {
        if (!booted) {
            boot();
        }
        setOpen(true);
    }

    function boot() {
        init();
        setBooted(true);
    }

    useEffect(() => {
        if (response) {
            onChange(response.data);

            setOpen(false);
        }
    }, [response]);

    return (
        <React.Fragment>
            <button onClick={handleOpen} className="flex items-center text-sm text-blue-500">
                <IconCirclePlus className="mr-1" size={16} /> Create entry
            </button>

            <Dialog open={open} onClose={() => setOpen(false)}>
                <div className="fixed inset-0 z-20 flex justify-end bg-slate-300/40 pl-20">
                    <Dialog.Panel className="w-full max-w-5xl overflow-y-scroll bg-white p-6 shadow-lg">
                        <Button onClick={handleSave} primary>
                            Save
                        </Button>
                        <Card className="mt-6 overflow-hidden">
                            <Form
                                fields={fields}
                                errors={errors}
                                context="create"
                                resource={resource}
                                values={values}
                                onChange={handleChange}
                            />
                        </Card>
                    </Dialog.Panel>
                </div>
            </Dialog>
        </React.Fragment>
    );
}
