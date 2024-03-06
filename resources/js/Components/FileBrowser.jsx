import {router} from "@inertiajs/react";
import classNames from "classnames";
import {forwardRef, useCallback, useEffect, useState} from "react";
import {useDropzone} from "react-dropzone";

const FileBrowser = forwardRef(({as: Element = "div", ...props}, ref) => <Element ref={ref} {...props} />);

FileBrowser.Toolbar = forwardRef(({ as: Element = "div", className, ...props }, ref) => (
    <Element ref={ref} className={classNames(className, 'flex justify-between')} {...props} />
));

FileBrowser.Toolbar.Item = forwardRef(({ as: Element = "div", className, ...props }, ref) => (
    <Element ref={ref} className={classNames(className, 'p-2')} {...props} />
));

FileBrowser.Window = ({ as: Element = "div", className, children, fileUploadUrl, selectFilesEvent, ...props }) => {
    const [loading, setLoading] = useState(false);
    const onDrop = useCallback(acceptedFiles => {
        setLoading(true);
        router.post(
            fileUploadUrl,
            { files: acceptedFiles },
            {
                forceFormData: true,
                onFinish: () => setLoading(false)
            }
        )
    },[router]);

    const { getRootProps, getInputProps, isDragActive } = useDropzone({onDrop});
    const { onClick, ...rootProps } = getRootProps();

    useEffect(() => {
        if (selectFilesEvent) {
            onClick(selectFilesEvent);
        }
    }, [selectFilesEvent])

    return (
        <Element className={classNames(className, 'min-h-[384px]', {
            'opacity-40 bg-slate-50': isDragActive,
            'animate-pulse': loading,
        })} {...props} {...rootProps}>
            <input {...getInputProps()} />
            {children}
        </Element>
    );
};

export default FileBrowser;
