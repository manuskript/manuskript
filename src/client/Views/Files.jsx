import {Head, Link} from "@inertiajs/react";
import {IconFile, IconFileZip, IconFolder, IconFolderUp, IconMovie} from "@tabler/icons-react";
import classNames from "classnames";
import React from "react";
import Button from "../Components/Button";
import Card from "../Components/Card";
import Layout from "../Layout";

function Directory({as: Element = "div", className, children, up, ...props}) {
    const Icon = up ? IconFolderUp : IconFolder;

    return (
        <Element
            {...props}
            className={classNames(
                className,
                "flex items-center bg-white p-3 font-semibold hover:bg-slate-100"
            )}
        >
            <Icon className="mr-3 text-slate-500" />
            {children}
        </Element>
    );
}

function File({as: Element = "div", className, path, extension, children, ...props}) {
    const types = {
        zip: IconFileZip,
    };

    const Icon = types[extension] ?? IconFile;

    const isImage = ["jpg", "jpeg", "png", "gif", "webp"].includes(extension);

    const isVideo = ["mp4", "mov"].includes(extension);

    return (
        <Element
            {...props}
            className={classNames(
                className,
                "flex items-center bg-white p-3 text-slate-500 hover:bg-slate-100"
            )}
        >
            <div className="mr-3 h-6 w-6 overflow-hidden rounded text-slate-400">
                {isImage ? (
                    <img src={"/storage/" + path} className="h-full w-full object-cover" />
                ) : isVideo ? (
                    <IconMovie />
                ) : (
                    <Icon />
                )}
            </div>
            {children}
        </Element>
    );
}

const Files = ({current, parent, data, ...props}) => {
    const {directories, files} = data;

    return (
        <React.Fragment>
            <Head title="Files" />

            <div className="flex items-center justify-end space-x-5">
                <Button primary>Upload</Button>
            </div>
            <Card className="my-10 divide-y divide-slate-200 overflow-hidden bg-white">
                {current && (
                    <Directory up as={Link} href={route("manuskript.filesystem", {path: parent})}>
                        <span className="tracking-widest">..</span>
                    </Directory>
                )}
                {directories.map(({path, basename}) => {
                    return (
                        <Directory
                            key={path}
                            as={Link}
                            href={route("manuskript.filesystem", {path})}
                        >
                            {basename}
                        </Directory>
                    );
                })}
                {files.map(({path, basename, extension, ...rest}) => {
                    return (
                        <File key={path} path={path} extension={extension}>
                            {basename}
                        </File>
                    );
                })}
            </Card>
        </React.Fragment>
    );
};

Files.layout = page => <Layout children={page} />;

export default Files;
