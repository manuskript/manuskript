import {Dialog} from "@headlessui/react";
import {IconFolder, IconX} from "@tabler/icons-react";
import axios from "axios";
import classNames from "classnames";
import React, {useEffect, useRef, useState} from "react";
import Button from "../Components/Button";

export default function ImageField({
    className,
    decorators,
    value,
    disk,
    readOnly,
    name,
    onChange,
    ...props
}) {
    const previewImage = useRef();

    const {thumbnail, url, upload} = decorators ?? {};

    const [preview, setPreview] = useState(false);

    const [focalPoint, setFocalPoint] = useState([50, 50]);

    const [progress, setProgress] = useState(null);

    const [state, setState] = useState({
        url: null,
        thumb: null,
        filename: null,
        file: null,
    });

    useEffect(() => {
        if (!value) {
            return;
        }

        if (state.file) {
            return;
        }

        function setStateFromFile() {
            createUrl(value).then(url =>
                setState({
                    url: url,
                    thumb: url,
                    filename: value.name,
                    file: value,
                })
            );
        }

        function setStateFromUrl() {
            if (!url) return;

            createFile(url, value).then(file =>
                setState({
                    url,
                    thumb: thumbnail ?? url,
                    filename: value,
                    file,
                })
            );
        }

        value instanceof File ? setStateFromFile() : setStateFromUrl();
    }, [value]);

    function updatePreview(file) {
        createUrl(file).then(url =>
            setState({
                url: url,
                thumb: url,
                filename: file.name,
                file: file,
            })
        );
    }

    async function createFile(url, name) {
        const response = await fetch(url);
        const blobfile = await response.blob();

        return new File([blobfile], name, {type: blobfile.type});
    }

    async function createUrl(file) {
        function readFile(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                reader.onloadend = () => resolve(reader.result);
                reader.onerror = reject;

                reader.readAsDataURL(file);
            });
        }

        return await readFile(file);
    }

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

        updatePreview(file);
    }

    function openPreview() {
        setPreview(!!state.url);
    }

    function closePreview() {
        setPreview(false);
    }

    function focalPointCSS() {
        const [left, top] = focalPoint;
        return {
            left: left + "%",
            top: top + "%",
        };
    }

    function updateFocalPoint(e) {
        // EXPERIMENTAL
        setFocalPoint([
            Math.round((e.nativeEvent.layerX * 100) / e.target.width),
            Math.round((e.nativeEvent.layerY * 100) / e.target.height),
        ]);
    }

    function handleSaveFocalpoint(e) {
        e.preventDefault();

        fetch("/api/focal-point", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                path: value,
                focalPoint,
            }),
        }).then(response => console.log(response));
    }

    function reset() {
        setPreview(false);

        setFocalPoint([50, 50]);

        setState({
            url: null,
            thumb: null,
            filename: null,
            file: null,
        });

        onChange(name, null);
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
                <button
                    className="block h-10 w-10 flex-shrink-0 overflow-hidden rounded bg-slate-200"
                    onClick={openPreview}
                >
                    <img
                        src={
                            state.thumb ??
                            "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs="
                        }
                        className="h-full w-full object-contain object-left"
                    />
                </button>
                <span className="block w-32 flex-1 whitespace-nowrap">
                    <button
                        className="max-w-full overflow-hidden text-ellipsis"
                        onClick={openPreview}
                    >
                        {state.filename}
                    </button>
                </span>
                {!!value && (
                    <button
                        className="flex h-5 w-5 items-center justify-center rounded-full border border-slate-300 text-slate-500"
                        onClick={reset}
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

            <Dialog open={preview} onClose={closePreview}>
                <div className="fixed inset-0 flex justify-end bg-slate-300/40 pl-20">
                    <Dialog.Panel className="w-full max-w-6xl overflow-y-scroll bg-white shadow-lg">
                        <div className="px-6 py-10">
                            <div className="mb-2 flex justify-between space-x-5">
                                <div>{state.file?.name}</div>
                                <div></div>
                            </div>
                            <div className="flex w-full justify-center border border-slate-200 p-3">
                                <div className="relative inline-flex">
                                    <img
                                        ref={previewImage}
                                        src={state.url}
                                        className="max-h-[70vh] max-w-full"
                                        onClick={updateFocalPoint}
                                    />
                                    <div
                                        className="pointer-events-none absolute h-10 w-10 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/80 shadow"
                                        style={focalPointCSS()}
                                    ></div>
                                </div>
                            </div>
                            <Button onClick={handleSaveFocalpoint}>Save Focalpoint</Button>
                            {!!state.file && (
                                <ul className="flex space-x-3 text-sm text-slate-600">
                                    <li>{state.file.size} bytes</li>
                                    <li>{state.file.type}</li>
                                </ul>
                            )}
                        </div>
                    </Dialog.Panel>
                </div>
            </Dialog>
        </React.Fragment>
    );
}
