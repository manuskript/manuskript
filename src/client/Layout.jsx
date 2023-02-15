import {Disclosure} from "@headlessui/react";
import {Link, usePage} from "@inertiajs/react";
import {IconChevronDown} from "@tabler/icons-react";
import classNames from "classnames";
import React, {useEffect, useState} from "react";

var toastTimeout;

export default function Layout({children}) {
    const {nav, toast, error, base} = usePage().props;

    const [currentUrl, setCurrentUrl] = useState("");
    const [showToast, setShowToast] = useState(true);

    useEffect(() => {
        setCurrentUrl(window.location.toString());

        if (toast) {
            setShowToast(true);

            clearTimeout(toastTimeout);

            if (toast.status === "success") {
                toastTimeout = setTimeout(() => setShowToast(false), 4000);
            }
        }
    }, [toast, usePage().url]);

    return (
        <React.Fragment>
            {showToast && !!toast && (
                <div className="border-b border-green-200 bg-green-100 p-3 text-center text-sm text-green-600">
                    {toast.message}
                </div>
            )}

            {!!error && (
                <div className="border-b border-red-200 bg-red-100 p-3 text-center text-sm text-red-600">
                    {error}
                </div>
            )}

            <div className="flex min-h-screen w-full bg-slate-50 text-slate-600">
                <div className="w-1/4 max-w-xs border-r border-slate-200 bg-slate-100">
                    <div className="sticky top-0">
                        <div className="p-8">
                            <Link className="hover:text-blue-600" href={`/${base}`}>
                                manuskript<span className="text-blue-600">_</span>
                            </Link>
                        </div>

                        <dl className="divide-y divide-slate-200">
                            {Object.entries(nav).map(([group, resources]) => (
                                <Disclosure defaultOpen as="div" key={group} className="py-8">
                                    <Disclosure.Button
                                        as="dt"
                                        className="flex cursor-pointer items-center justify-between px-8 text-xs uppercase tracking-wider text-slate-400"
                                    >
                                        <span>{group}</span>
                                        <IconChevronDown size={16} />
                                    </Disclosure.Button>
                                    <Disclosure.Panel as="dd" className="pt-6">
                                        <ul className="space-y-6 px-8">
                                            {resources.map(({label, url}) => (
                                                <li key={group + label}>
                                                    <Link
                                                        href={url}
                                                        className={classNames({
                                                            "text-blue-600":
                                                                currentUrl.includes(url),
                                                        })}
                                                    >
                                                        {label}
                                                    </Link>
                                                </li>
                                            ))}
                                        </ul>
                                    </Disclosure.Panel>
                                </Disclosure>
                            ))}
                        </dl>
                    </div>
                </div>
                <div className="w-3/4 flex-1 p-8">
                    <div className="mx-auto max-w-7xl">{children}</div>
                </div>
            </div>
        </React.Fragment>
    );
}
