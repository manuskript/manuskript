import {Menu} from "@headlessui/react";
import {
    IconColumnInsertLeft,
    IconColumnInsertRight,
    IconRowInsertBottom,
    IconRowInsertTop,
    IconSquareToggle,
    IconSquareToggleHorizontal,
    IconTableOptions,
    IconTransitionBottom,
    IconTransitionLeft,
    IconTrash,
} from "@tabler/icons-react";
import DropDown, {DropDownItem, DropDownList} from "../../Components/DropDown";
import {ToolbarItem} from "./Toolbar";

export function Table({editor}) {
    return (
        <Menu as={DropDown}>
            <Menu.Button as={ToolbarItem} active={editor.isActive("table")}>
                <IconTableOptions size={22} />
            </Menu.Button>
            <Menu.Items as={DropDownList} className="min-w-[196px]">
                <div>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.addRowBefore()}
                    >
                        <IconRowInsertTop className="mr-2" size={20} />
                        Add Row Before
                    </Menu.Item>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.addRowAfter()}
                    >
                        <IconRowInsertBottom className="mr-2" size={20} />
                        Add Row After
                    </Menu.Item>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.addColumnBefore()}
                    >
                        <IconColumnInsertLeft className="mr-2" size={20} />
                        Add Column Left
                    </Menu.Item>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.addColumnAfter()}
                    >
                        <IconColumnInsertRight className="mr-2" size={20} />
                        Add Column Right
                    </Menu.Item>
                </div>
                <div>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.toggleHeaderRow()}
                    >
                        <IconSquareToggleHorizontal className="mr-2" size={20} />
                        Header Row
                    </Menu.Item>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.toggleHeaderColumn()}
                    >
                        <IconSquareToggle className="mr-2" size={20} />
                        Header Column
                    </Menu.Item>
                </div>
                <div>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.deleteRow()}
                    >
                        <IconTransitionBottom className="mr-2" size={20} />
                        Delete Row
                    </Menu.Item>
                    <Menu.Item
                        className="flex items-center"
                        as={DropDownItem}
                        onClick={() => editor.commands.deleteColumn()}
                    >
                        <IconTransitionLeft className="mr-2" size={20} />
                        Delete Column
                    </Menu.Item>
                </div>
                <Menu.Item
                    className="flex items-center text-red-500"
                    as={DropDownItem}
                    onClick={() => editor.commands.deleteTable()}
                >
                    <IconTrash className="mr-2" size={20} />
                    Delete Table
                </Menu.Item>
            </Menu.Items>
        </Menu>
    );
}
