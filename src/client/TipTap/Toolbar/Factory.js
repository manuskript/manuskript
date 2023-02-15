import {
    IconBlockquote,
    IconBold,
    IconH1,
    IconH2,
    IconH3,
    IconH4,
    IconH5,
    IconH6,
    IconItalic,
    IconLink,
    IconList,
    IconListNumbers,
    IconSeparatorHorizontal,
    IconTable,
    IconUnderline,
} from "@tabler/icons-react";

const ToolFactory = editor => {
    const tools = {
        available: {
            h1: {
                icon: IconH1,
                isActive: editor.isActive("heading", {level: 1}),
                handle: () => editor.chain().focus().toggleHeading({level: 1}).run(),
            },
            h2: {
                icon: IconH2,
                isActive: editor.isActive("heading", {level: 2}),
                handle: () => editor.chain().focus().toggleHeading({level: 2}).run(),
            },
            h3: {
                icon: IconH3,
                isActive: editor.isActive("heading", {level: 3}),
                handle: () => editor.chain().focus().toggleHeading({level: 3}).run(),
            },
            h4: {
                icon: IconH4,
                isActive: editor.isActive("heading", {level: 4}),
                handle: () => editor.chain().focus().toggleHeading({level: 4}).run(),
            },
            h5: {
                icon: IconH5,
                isActive: editor.isActive("heading", {level: 5}),
                handle: () => editor.chain().focus().toggleHeading({level: 5}).run(),
            },
            h6: {
                icon: IconH6,
                isActive: editor.isActive("heading", {level: 6}),
                handle: () => editor.chain().focus().toggleHeading({level: 6}).run(),
            },
            bold: {
                icon: IconBold,
                isActive: editor.isActive("bold"),
                handle: () => editor.chain().focus().toggleBold().run(),
            },
            underline: {
                icon: IconUnderline,
                isActive: editor.isActive("underline"),
                handle: () => editor.chain().focus().toggleUnderline().run(),
            },
            italic: {
                icon: IconItalic,
                isActive: editor.isActive("italic"),
                handle: () => editor.chain().focus().toggleItalic().run(),
            },
            link: {
                icon: IconLink,
                isActive: editor.isActive("link"),
                handle: () =>
                    editor.chain().focus().extendMarkRange("link").setLink({href: null}).run(),
            },
            blockquote: {
                icon: IconBlockquote,
                isActive: editor.isActive("blockquote"),
                handle: () => editor.chain().focus().toggleBlockquote().run(),
            },
            bullet_list: {
                icon: IconList,
                isActive: editor.isActive("bulletList"),
                handle: () => editor.chain().focus().toggleBulletList().run(),
            },
            ordered_list: {
                icon: IconListNumbers,
                isActive: editor.isActive("orderedList"),
                handle: () => editor.chain().focus().toggleOrderedList().run(),
            },
            horizontal_rule: {
                icon: IconSeparatorHorizontal,
                isActive: false,
                handle: () => editor.chain().focus().setHorizontalRule().run(),
            },
            table: {
                icon: IconTable,
                isActive: editor.isActive("table"),
                handle: () =>
                    editor
                        .chain()
                        .focus()
                        .insertTable({rows: 3, cols: 3, withHeaderRow: false})
                        .run(),
            },
        },

        resolve(key) {
            return this.available[key];
        },
    };

    function make(type) {
        return tools.resolve(type);
    }

    return {make};
};

export default ToolFactory;
