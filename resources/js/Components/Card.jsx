import classNames from "classnames";
import {forwardRef} from "react";

const Card = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element
        ref={ref}
        className={classNames(className, "mx-auto w-full max-w-7xl rounded-lg bg-white shadow")}
        {...props}
    />
));

Card.Header = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "overflow-hidden rounded-t-lg px-6 py-1")} {...props} />
));

Card.Footer = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "overflow-hidden rounded-b-lg px-6 py-1")} {...props} />
));

Card.Panel = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "px-6 py-3")} {...props} />
));

export default Card;
