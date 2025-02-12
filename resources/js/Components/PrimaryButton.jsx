export default function PrimaryButton({
    className = '',
    disabled,
    children,
    ...props
}) {
    return (
        <button
            {...props}
            className={
                `inline-flex items-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-semibold uppercase text-white transition duration-150 ease-in-out hover:bg-primary/80 focus:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-primary/80 focus:ring-offset-2 active:bg-primary/80 ${
                    disabled && 'opacity-25'
                } ` + className
            }
            disabled={disabled}
        >
            {children}
        </button>
    );
}
