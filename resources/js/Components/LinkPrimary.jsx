import {Link} from "@inertiajs/react";

export default function LinkPrimary({
                                          className = '',
                                          children,
                                          ...props
                                      }) {
    return (
        <Link
            {...props}
            className={
                `inline-flex items-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-semibold uppercase text-white transition duration-150 ease-in-out hover:bg-primary/80 focus:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 active:bg-primary/80 ` + className
            }
        >
            {children}
        </Link>
    );
}
