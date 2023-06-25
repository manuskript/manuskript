import classNames from "classnames";
import {forwardRef} from "react";

const Message = forwardRef(({as: Element = "div", className, ...props}, ref) => (
    <Element ref={ref} className={classNames(className, "w-full border-b px-6 py-2 text-center text-sm")} {...props} />
));

Message.Error = forwardRef(({className, ...props}, ref) => (
    <Message ref={ref} className={classNames(className, "border-red-200 bg-red-100 text-red-600")} {...props} />
));

Message.Success = forwardRef(({className, ...props}, ref) => (
    <Message ref={ref} className={classNames(className, "border-green-200 bg-green-100 text-green-600")} {...props} />
));

export default Message;
