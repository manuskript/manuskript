import classNames from "classnames";
import { Fragment } from "react";
import FieldFactory from "~/Field";


export default function RepeatBlocks({ className, value, readOnly, onChange, blocks, ...props }) {

    const schema = blocks.reduce((data, block) => {
        data[block.name] = block;
        return data;
    }, {});

    console.log(schema);

    function add(key) {
        const { name, value: content } = schema[key];

        onChange([...value, { [name]: content }]);
    }

    return (
        <Fragment>
            <button onClick={() => add('example')}>add</button>
            <div className={classNames(className)}>
                {value.map(resource => {
                    const [name, value] = Object.entries(resource);

                    console.log(name, value);
                })}
            </div>
        </Fragment>
    );
}
