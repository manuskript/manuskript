import {router} from "@inertiajs/react";
import {Fragment} from "react";
import App from "~/App";
import Card from "~/Components/Card";
import ResourceFields from "~/Shared/ResourceFields";
import {useFormFields} from "~/useFormFields";
import Button from "~/Components/Button";
import Layout from "~/Components/Layout";

const Show = ({data: resource, updateUrl, errors, ...props}) => {
    const {fields} = useFormFields(resource.fields ?? []);

    return (
        <Fragment>
            <Card>
                <ResourceFields readOnly fields={fields} errors={errors}  />
            </Card>
        </Fragment>
    );
};

Show.layout = page => <App children={page} />;

export default Show;
