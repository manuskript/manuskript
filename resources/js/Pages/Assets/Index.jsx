import {router} from "@inertiajs/react";
import {Fragment} from "react";
import App from "~/App";
import Card from "~/Components/Card";
import AssetsGrid from "~/Shared/AssetsGrid";

const Index = props => {
    function navigate({url}) {
        router.visit(url);
    }

    return (
        <Fragment>
            <Card className="overflow-hidden">
                <AssetsGrid onClick={navigate} {...props} />
            </Card>
        </Fragment>
    );
};

Index.layout = page => <App children={page} />;

export default Index;
