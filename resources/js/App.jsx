import {Disclosure} from "@headlessui/react";
import {Link, usePage} from "@inertiajs/react";
import {Fragment} from "react";
import Layout from "~/Components/Layout";
import Menu from "~/Components/Menu";
import Message from "~/Components/Message";

export default function App({children}) {
    const {menus, message} = usePage().props;

    return (
        <Fragment>
            {!!message && <Message.Success>{message}</Message.Success>}
            <Layout>
                <Layout.Sidebar>
                    <Menu>
                        {menus.map(({label, items}, key) => (
                            <Disclosure key={key} defaultOpen as={Menu.Group}>
                                {({open}) => (
                                    <Fragment>
                                        <Disclosure.Button as={Menu.Label} open={open}>
                                            {label}
                                        </Disclosure.Button>
                                        <Disclosure.Panel as={Menu.Panel}>
                                            <Menu.Items as="ul">
                                                {items.map(({label, active, url}) => (
                                                    <li key={url}>
                                                        <Menu.Link active={active} as={Link} href={url}>
                                                            {label}
                                                        </Menu.Link>
                                                    </li>
                                                ))}
                                            </Menu.Items>
                                        </Disclosure.Panel>
                                    </Fragment>
                                )}
                            </Disclosure>
                        ))}
                    </Menu>
                </Layout.Sidebar>
                <Layout.Main className="w-3/4">{children}</Layout.Main>
            </Layout>
        </Fragment>
    );
}
