import {router} from "@inertiajs/react";
import {Fragment, useState} from "react";
import App from "~/App";
import Card from "~/Components/Card";
import ResourcesTable from "~/Shared/ResourcesTable";

const Index = ({columns, data, ...props}) => {
    const [selected, setSelected] = useState([]);

    function navigate({url}) {
        router.visit(url);
    }

    return (
        <Fragment>
            <Card className="overflow-hidden">
                <ResourcesTable
                    selectable
                    selected={selected}
                    onChange={items => setSelected(items)}
                    onClick={navigate}
                    columns={columns}
                    data={data}
                />
            </Card>
        </Fragment>
    );
};

Index.layout = page => <App children={page} />;

export default Index;
