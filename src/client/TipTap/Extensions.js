import {Blockquote} from "@tiptap/extension-blockquote";
import {Bold} from "@tiptap/extension-bold";
import BulletList from "@tiptap/extension-bullet-list";
import {Document} from "@tiptap/extension-document";
import Heading from "@tiptap/extension-heading";
import {History} from "@tiptap/extension-history";
import HorizontalRule from "@tiptap/extension-horizontal-rule";
import {Italic} from "@tiptap/extension-italic";
import Link from "@tiptap/extension-link";
import ListItem from "@tiptap/extension-list-item";
import OrderedList from "@tiptap/extension-ordered-list";
import {Paragraph} from "@tiptap/extension-paragraph";
import {Strike} from "@tiptap/extension-strike";
import Table from "@tiptap/extension-table";
import TableCell from "@tiptap/extension-table-cell";
import TableHeader from "@tiptap/extension-table-header";
import TableRow from "@tiptap/extension-table-row";
import {Text} from "@tiptap/extension-text";
import {Underline} from "@tiptap/extension-underline";
import Fieldset from "./Fieldset";

const Extensions = (() => {
    function fromTools(tools) {
        const additional = [];

        const hasHeading = tools.some(t => ["h1", "h2", "h3", "h4", "h5", "h6"].includes(t));

        const hasList = tools.some(t => ["bullet_list", "ordered_list"].includes(t));

        if (hasHeading) {
            additional.push(Heading);
        }

        if (hasList) {
            additional.push(ListItem);
        }

        tools.forEach(t => {
            switch (t) {
                case "bold":
                    additional.push(Bold);
                    break;
                case "italic":
                    additional.push(Italic);
                    break;
                case "link":
                    additional.push(Link);
                    break;
                case "strike":
                    additional.push(Strike);
                    break;
                case "blockquote":
                    additional.push(Blockquote);
                    break;
                case "ordered_list":
                    additional.push(OrderedList);
                    break;
                case "bullet_list":
                    additional.push(BulletList);
                    break;
                case "underline":
                    additional.push(Underline);
                    break;
                case "horizontal_rule":
                    additional.push(HorizontalRule);
                    break;
                case "table":
                    additional.push(Table);
                    additional.push(TableCell);
                    additional.push(TableHeader);
                    additional.push(TableRow);
                    break;
            }
        });

        return additional;
    }

    function resolve(tools) {
        return [Document, History, Paragraph, Text, Fieldset, ...fromTools(tools)];
    }

    return {resolve};
})();

export default Extensions;
