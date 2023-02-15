import BooleanCell from "./BooleanCell";
import DateTimeCell from "./DateTimeCell";
import FileCell from "./FileCell";
import ImageCell from "./ImageCell";
import JsonCell from "./JsonCell";
import RelationCell from "./RelationCell";
import TextCell from "./TextCell";

const CellFactory = (() => {
    const fields = {
        available: {
            boolean: BooleanCell,
            datetime: DateTimeCell,
            email: TextCell,
            file: FileCell,
            image: ImageCell,
            json: JsonCell,
            number: TextCell,
            prose: JsonCell,
            relation: RelationCell,
            repeat: JsonCell,
            select: TextCell,
            text: TextCell,
            textarea: TextCell,
        },
        fromType(type) {
            return this.available[type] ?? TextCell;
        },
    };

    function make(type) {
        return fields.fromType(type);
    }

    return {make};
})();

export default CellFactory;
