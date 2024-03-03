import {usePage} from "@inertiajs/react";
import classNames from "classnames";
import Breadcrumb from "../Components/Breadcrumb";
import {Directory, File} from "../Components/Controls";
import Grid from "../Components/Grid";

export default function AssetsGrid({name, folder, breadcrumbs, directories, files, onClick, ...props}) {
    const currentUrl = usePage().url;

    const isEmpty = !directories.length && !files.length;

    return (
        <Grid>
            <Grid.Head>
                <Breadcrumb>
                    {breadcrumbs.map(({label, url}) => (
                        <Breadcrumb.Item href={url} active={url === currentUrl}>
                            {label}
                        </Breadcrumb.Item>
                    ))}
                </Breadcrumb>
            </Grid.Head>
            <Grid.Body
                className={classNames({
                    "grid-cols-4": !isEmpty,
                })}
            >
                {directories.map(({name, ...props}) => (
                    <Directory name={name} as={Grid.Item} onClick={() => onClick({name, ...props})} />
                ))}
                {files.map(({name, ...props}) => (
                    <File name={name} as={Grid.Item} onClick={() => onClick({name, ...props})} />
                ))}
            </Grid.Body>
        </Grid>
    );
}
