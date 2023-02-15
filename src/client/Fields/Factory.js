import BooleanField from "./BooleanField";
import DateTimeField from "./DateTimeField";
import EmailField from "./EmailField";
import EntryField from "./EntryField";
import FileField from "./FileField";
import IdField from "./IdField";
import ImageField from "./ImageField";
import JsonField from "./JsonField";
import NumberField from "./NumberField";
import ProseField from "./ProseField";
import Relation from "./Relation";
import RepeatField from "./RepeatField";
import SelectField from "./SelectField";
import TextAreaField from "./TextAreaField";
import TextField from "./TextField";

const FieldFactory = (() => {
    const fields = {
        available: {
            boolean: BooleanField,
            datetime: DateTimeField,
            email: EmailField,
            entry: EntryField,
            file: FileField,
            id: IdField,
            image: ImageField,
            json: JsonField,
            number: NumberField,
            prose: ProseField,
            relation: Relation,
            repeat: RepeatField,
            select: SelectField,
            text: TextField,
            textarea: TextAreaField,
        },
        fromType(type) {
            return this.available[type];
        },
    };

    function make(type) {
        return fields.fromType(type);
    }

    return {make};
})();

export default FieldFactory;
