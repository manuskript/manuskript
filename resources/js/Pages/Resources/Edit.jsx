import {router} from "@inertiajs/react";
import {Fragment} from "react";
import App from "~/App";
import Card from "~/Components/Card";
import ResourceFields from "~/Shared/ResourceFields";
import {useFormFields} from "~/useFormFields";

const Edit = ({data: resource, updateUrl, ...props}) => {
    const {data, setData, fields} = useFormFields(resource.fields ?? []);

    function handleSave() {
        router.patch(updateUrl, data);
    }

    return (
        <Fragment>
            <button onClick={handleSave}>Save</button>
            <Card>
                <ResourceFields fields={fields} onChange={setData} />
            </Card>
        </Fragment>
    );
};

Edit.layout = page => <App children={page} />;

export default Edit;
