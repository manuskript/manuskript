import {useEffect, useState} from "react";
import Card from "../Components/Card";
import Form from "../Forms/Resource";
import Layout from "../Layout";

const Show = ({data, ...props}) => {
    const [values, setValues] = useState({});

    const {fields} = data;

    useEffect(() => {
        const initial = fields.reduce((data, {name, value, type}) => {
            data[name] = value;
            return data;
        }, {});

        setValues(initial);
    }, []);

    return (
        <Card className="my-10 overflow-y-scroll">
            <Form fields={fields} values={values} readOnly />
        </Card>
    );
};

Show.layout = page => <Layout children={page} />;

export default Show;
