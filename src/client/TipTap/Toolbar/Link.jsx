import {Popover} from "@headlessui/react";
import {IconSettings} from "@tabler/icons-react";
import React, {useState} from "react";
import Button from "../../Components/Button";
import Checkbox from "../../Components/Checkbox";
import DropDown, {DropDownList} from "../../Components/DropDown";
import InputField from "../../Fields/InputField";
import {ToolbarItem} from "./Toolbar";

export function Link({editor}) {
    const [values, setValues] = useState({
        href: editor.getAttributes("link").href ?? "",
        target: editor.getAttributes("link").target ?? "_self",
    });

    function confirm(e) {
        e.preventDefault();

        if (!values.href) {
            return editor.commands.unsetLink();
        }

        return editor.commands.setLink(values);
    }

    function handleChange(key, value) {
        setValues(values => ({
            ...values,
            [key]: value,
        }));
    }

    function handleNewTab(e) {
        handleChange("target", e.target.checked ? "_blank" : "_self");
    }

    const isEmpty = editor.getAttributes("link").href === null;

    return (
        <Popover as={DropDown}>
            {({open}) => (
                <React.Fragment>
                    <Popover.Button as={ToolbarItem} active={editor.isActive("link")}>
                        <IconSettings size={22} />
                    </Popover.Button>
                    {(open || isEmpty) && (
                        <DropDownList className="min-w-[300px]">
                            <form onSubmit={confirm}>
                                <div className="space-y-2 p-2">
                                    <InputField
                                        placeholder="https://"
                                        value={values.href}
                                        onChange={e => handleChange("href", e.target.value)}
                                    />
                                    <div className="flex items-center justify-between space-x-4">
                                        <label
                                            htmlFor="new-tab"
                                            className="flex items-center space-x-2 text-sm"
                                        >
                                            <Checkbox
                                                id="new-tab"
                                                type="checkbox"
                                                checked={values.target == "_blank"}
                                                onChange={handleNewTab}
                                            />
                                            <span>Open in new tab</span>
                                        </label>
                                        <Button className="text-sm" type="submit">
                                            Confirm
                                        </Button>
                                    </div>
                                </div>
                            </form>
                        </DropDownList>
                    )}
                </React.Fragment>
            )}
        </Popover>
    );
}
