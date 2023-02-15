import {IconFile, IconFileUpload, IconFolder, IconX} from "@tabler/icons-react";
import axios from "axios";
import classNames from "classnames";
import React, {useState} from "react";
import Button from "../Components/Button";

export default function FileField({
    className,
    decorators,
    value,
    disk,
    readOnly,
    name,
    onChange,
    ...props
}) {
    const {url, upload} = decorators ?? {};

    const [progress, setProgress] = useState(null);

    async function onInputChange(e) {
        if (!onChange) return;

        const file = e.target.files[0];

        const headers = {"Content-Type": "multipart/form-data"};

        function onUploadProgress({loaded, total}) {
            if (loaded == total) {
                setProgress(null);
            } else {
                setProgress((loaded * 100) / total);
            }
        }

        const {data} = await axios.post(
            upload,
            {file, disk},
            {
                headers,
                onUploadProgress,
            }
        );

        onChange(name, data);
    }

    return !!progress ? (
        <div className="flex w-full items-center space-x-3">
            <div className="w-full rounded bg-slate-200">
                <div
                    style={{width: progress + "%"}}
                    className="h-1 rounded bg-blue-500 shadow shadow-blue-300 transition-all"
                ></div>
            </div>
            <div className="whitespace-nowrap text-sm">{Math.round(progress)} %</div>
        </div>
    ) : (
        <React.Fragment>
            <div
                className={classNames(
                    className,
                    "flex items-center space-x-3 overflow-hidden rounded border bg-white p-1"
                )}
            >
                <button className="block h-10 w-10 flex-shrink-0 items-center justify-center overflow-hidden rounded bg-slate-200">
                    {value ? (
                        <IconFile className="mx-auto text-slate-500" />
                    ) : (
                        <IconFileUpload className="mx-auto text-slate-500" />
                    )}
                </button>
                <span className="block w-32 flex-1 whitespace-nowrap">
                    <button
                        className={classNames(
                            "max-w-full overflow-hidden text-ellipsis",
                            value ? "text-slate-500" : "text-slate-400"
                        )}
                    >
                        {value ?? "Choose a file"}
                    </button>
                </span>
                {!!value && (
                    <button
                        className="flex h-5 w-5 items-center justify-center rounded-full border border-slate-300 text-slate-500"
                        onClick={() => onChange(name, null)}
                    >
                        <IconX size={16} />
                    </button>
                )}
                <input
                    id={name}
                    disabled={readOnly}
                    className="hidden"
                    type="file"
                    onChange={onInputChange}
                />
                <Button
                    as="label"
                    htmlFor={name}
                    className="bg-slate-100 text-sm hover:bg-slate-200"
                >
                    Browse… <IconFolder className="ml-2" size={18} />
                </Button>
            </div>
        </React.Fragment>
    );
}
