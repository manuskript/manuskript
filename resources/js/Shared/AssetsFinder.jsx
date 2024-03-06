import {usePage} from "@inertiajs/react";
import Breadcrumb from "../Components/Breadcrumb";
import Button from "~/Components/Button";
import {Directory, File} from "../Components/Controls";
import FileBrowser from "../Components/FileBrowser";
import Grid from "../Components/Grid";
import { useState } from "react";
import { IconCloudUpload } from "@tabler/icons-react";

export default function AssetsGrid({name, folder, breadcrumbs, directories, files, onClick, ...props}) {
    const currentUrl = usePage().url;

    const [selectFilesEvent, setSelectFilesEvent] = useState();

    const isEmpty = !directories.length && !files.length;

    return (
        <FileBrowser>
            <FileBrowser.Toolbar className="bg-slate-100 items-end">
                <Breadcrumb className="pt-2">
                    {breadcrumbs.map(({label, url}) => (
                        <Breadcrumb.Item key={label} href={url} active={url === currentUrl}>
                            {label}
                        </Breadcrumb.Item>
                    ))}
                </Breadcrumb>
                <FileBrowser.Toolbar.Item>
                    <Button aria-label="Upload" className="space-x-2 text-sm" onClick={setSelectFilesEvent}>
                        <IconCloudUpload size={20} />
                    </Button>
                </FileBrowser.Toolbar.Item>
            </FileBrowser.Toolbar>
            <FileBrowser.Window fileUploadUrl={currentUrl} selectFilesEvent={selectFilesEvent} >
                <Grid className="grid-cols-2 md:grid-cols-4 lg:grid-cols-5">
                    {directories.map(({name, ...props}) => (
                        <Directory key={name} name={name} as={Grid.Item} onClick={() => onClick({name, ...props})} />
                    ))}
                    {files.map(({name, ...props}) => (
                        <File key={name} name={name} as={Grid.Item} onClick={() => onClick({name, ...props})} />
                    ))}
                </Grid>
            </FileBrowser.Window>
        </FileBrowser>
    );
}
