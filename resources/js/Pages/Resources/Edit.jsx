import {router} from "@inertiajs/react";
import {Fragment} from "react";
import App from "~/App";
import Card from "~/Components/Card";
import ResourceFields from "~/Shared/ResourceFields";
import {useFormFields} from "~/useFormFields";
import Button from "~/Components/Button";
import Layout from "~/Components/Layout";

const Edit = ({data: resource, updateUrl, errors, ...props}) => {
    const {data, setData, fields} = useFormFields(resource.fields ?? []);

    function handleSave() {
        router.patch(updateUrl, data);
    }

    return (
        <Fragment>
            <Layout.Container>
                <Button primary className="ml-auto" onClick={handleSave}>Save</Button>
            </Layout.Container>
            <Card>
                <ResourceFields fields={fields} errors={errors} onChange={setData} />
            </Card>
        </Fragment>
    );
};

Edit.layout = page => <App children={page} />;

export default Edit;
