import RepeatBlocks from "~/Shared/RepeatBlocks";
import Input from "~/Components/Controls/Input";

export default class Field {
    static typeMap = {
        repeat: RepeatBlocks
    }

    static defaultField = Input

    static resolve(type) {
        if (Object.keys(Field.typeMap).includes(type)) {
            return Field.typeMap[type];
        }

        return Field.defaultField;
    }
}
