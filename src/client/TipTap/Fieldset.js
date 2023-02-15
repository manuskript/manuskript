import {mergeAttributes, Node} from "@tiptap/core";
import {ReactNodeViewRenderer} from "@tiptap/react";
import {TextSelection} from "prosemirror-state";
import Component from "./Components/Fieldset";

export default Node.create({
    name: "fieldset",

    group: "block",

    draggable: true,

    addNodeView() {
        return ReactNodeViewRenderer(Component);
    },

    addAttributes() {
        return {
            value: {
                parseHTML: element => element.getAttribute("value"),
            },
            name: {
                parseHTML: element => element.getAttribute("name"),
            },
        };
    },

    parseHTML() {
        return [
            {
                tag: "fieldset",
            },
        ];
    },

    renderHTML({HTMLAttributes}) {
        return ["fieldset", mergeAttributes(HTMLAttributes)];
    },

    addCommands() {
        return {
            setBlock: field => ({chain}) => {
                return chain()
                    .insertContent({
                        type: this.name,
                        attrs: {...field},
                    })

                    .command(({tr, dispatch}) => {
                        if (dispatch) {
                            const {$to} = tr.selection;

                            tr.setSelection(TextSelection.create(tr.doc, $to.pos));

                            tr.scrollIntoView();
                        }

                        return true;
                    })
                    .run();
            },
        };
    },
});
