import {Menu} from "@headlessui/react";
import {IconCornerUpLeft, IconCornerUpRight, IconSquareRoundedPlus} from "@tabler/icons-react";
import classNames from "classnames";
import React from "react";
import Dropdown, {DropDownItem, DropDownList} from "../../Components/DropDown";
import Factory from "./Factory";
import {Table} from "./Table";

export default function Toolbar({editor, tools, blocks, ...props}) {
    return (
        <div className="-mb-px flex justify-between rounded-t border border-b border-slate-200 bg-slate-50">
            <div className="flex flex-1 space-x-2 py-2 px-3">
                {tools.map(key => {
                    const {icon: Icon, isActive, handle} = Factory(editor).make(key);

                    return (
                        <ToolbarItem active={isActive} onClick={handle} key={key}>
                            <Icon size={22} />
                        </ToolbarItem>
                    );
                })}
            </div>
            <div className="flex">
                {editor.isActive("table") && (
                    <div className="py-2 px-2">
                        <Table editor={editor} />
                    </div>
                )}
                {blocks && (
                    <div className="py-2 px-2">
                        <Menu as={Dropdown}>
                            <Menu.Button as={ToolbarItem} active={editor.isActive("fieldset")}>
                                <IconSquareRoundedPlus size={22} />
                            </Menu.Button>
                            <Menu.Items as={DropDownList} className="min-w-[128px]">
                                {blocks.map(field => (
                                    <Menu.Item
                                        as={DropDownItem}
                                        key={field.name + "_menu"}
                                        onClick={() => editor.chain().focus().setBlock(field).run()}
                                    >
                                        {field.label}
                                    </Menu.Item>
                                ))}
                            </Menu.Items>
                        </Menu>
                    </div>
                )}
                <div className="flex space-x-2 border-l py-2 px-2">
                    <ToolbarItem onClick={() => editor.chain().focus().undo().run()}>
                        <IconCornerUpLeft size={22} />
                    </ToolbarItem>
                    <ToolbarItem onClick={() => editor.chain().focus().redo().run()}>
                        <IconCornerUpRight size={22} />
                    </ToolbarItem>
                </div>
            </div>
        </div>
    );
}

export const ToolbarItem = React.forwardRef(({className, active, ...props}, ref) => (
    <button
        className={classNames(
            className,
            "rounded-lg border border-transparent p-1 outline-none focus:border-slate-400",
            {
                "bg-slate-200": active,
            }
        )}
        {...props}
    />
));
