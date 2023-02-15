import {Menu} from "@headlessui/react";
import {IconCornerUpLeft, IconCornerUpRight, IconSquareRoundedPlus} from "@tabler/icons-react";
import classNames from "classnames";
import React from "react";
import Dropdown, {DropDownItem, DropDownList} from "../../Components/DropDown";
import Factory from "./Factory";
import {Link} from "./Link";
import {Table} from "./Table";

export default function Toolbar({editor, tools, blocks, ...props}) {
    return (
        <div className="sticky top-0 z-10">
            <div className="-mb-px flex justify-between rounded-t border border-b border-slate-200 bg-slate-50">
                <div className="flex flex-1 space-x-2 px-3 py-2">
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
                        <div className="px-2 py-2">
                            <Table editor={editor} />
                        </div>
                    )}
                    {editor.isActive("link") && (
                        <div className="px-2 py-2">
                            <Link editor={editor} />
                        </div>
                    )}
                    {blocks && (
                        <div className="px-2 py-2">
                            <Menu as={Dropdown}>
                                <Menu.Button as={ToolbarItem} active={editor.isActive("fieldset")}>
                                    <IconSquareRoundedPlus size={22} />
                                </Menu.Button>
                                <Menu.Items as={DropDownList} className="min-w-[128px]">
                                    {blocks.map(field => (
                                        <Menu.Item
                                            as={DropDownItem}
                                            key={field.name + "_menu"}
                                            onClick={() =>
                                                editor.chain().focus().setBlock(field).run()
                                            }
                                        >
                                            {field.label}
                                        </Menu.Item>
                                    ))}
                                </Menu.Items>
                            </Menu>
                        </div>
                    )}
                    <div className="flex space-x-2 border-l px-2 py-2">
                        <ToolbarItem onClick={() => editor.chain().focus().undo().run()}>
                            <IconCornerUpLeft size={22} />
                        </ToolbarItem>
                        <ToolbarItem onClick={() => editor.chain().focus().redo().run()}>
                            <IconCornerUpRight size={22} />
                        </ToolbarItem>
                    </div>
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
