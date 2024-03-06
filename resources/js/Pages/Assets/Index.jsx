import {router} from "@inertiajs/react";
import {Fragment} from "react";
import App from "~/App";
import Card from "~/Components/Card";
import AssetsFinder from "~/Shared/AssetsFinder";

const Index = props => {
    function navigate({url}) {
        router.visit(url);
    }

    return (
        <Fragment>
            <Card className="overflow-hidden">
                <AssetsFinder onClick={navigate} {...props} />
            </Card>
        </Fragment>
    );
};

Index.layout = page => <App children={page} />;

export default Index;
