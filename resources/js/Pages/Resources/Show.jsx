import {Fragment} from "react";
import App from "~/App";
import Card from "~/Components/Card";
import ResourceFields from "~/Shared/ResourceFields";
import {useFormFields} from "~/useFormFields";

const Show = ({data: resource, updateUrl, errors, ...props}) => {
    const {fields} = useFormFields(resource.fields ?? []);

    return (
        <Fragment>
            <Card>
                <ResourceFields readOnly fields={fields} errors={errors} />
            </Card>
        </Fragment>
    );
};

Show.layout = page => <App children={page} />;

export default Show;
