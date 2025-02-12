import {Head, Link, useForm} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {Transition} from "@headlessui/react";
import Checkbox from "@/Components/Checkbox.jsx";
import {RiArrowLeftLine} from "react-icons/ri";

export default function PaymentForm(props){

    const {
        data,
        setData,
        errors,
        put,
        post,
        reset,
        processing,
        recentlySuccessful,
    } = useForm({
        name: props.form.name,
        is_default: props.form.is_default,
    });

    const submit = (e) => {
        e.preventDefault();

        if (props.form.id){
            put(route('paymentmethod.update', props.form.id));
        }else{
            post(route('paymentmethod.store'));
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 flex items-center gap-4">
                    <Link href={route('paymentmethod.index')} className="p-1.5 border border-slate-100 rounded-full hover:border-accent hover:text-accent"><RiArrowLeftLine/></Link>
                    <p>Form Payment Method</p>
                </h2>
            }
        >
            <Head title="Form Payment Method" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <header>
                            <h2 className="text-lg font-medium text-gray-900">
                                Form
                            </h2>
                        </header>

                        <div className="max-w-xl">
                            <form onSubmit={submit} className="mt-6 space-y-6">
                                <div>
                                    <InputLabel
                                        value="Category Name"
                                    />

                                    <TextInput
                                        name="name"
                                        value={data.name}
                                        onChange={(e) =>
                                            setData('name', e.target.value)
                                        }
                                        type="text"
                                        className="mt-1 block w-full"
                                        autoComplete="current-password"
                                    />

                                    <InputError
                                        message={errors.name}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="mt-4 block">
                                    <label className="flex items-center">
                                        <Checkbox
                                            name="is_default"
                                            checked={data.is_default}
                                            onChange={(e) =>
                                                setData('is_default', e.target.checked)
                                            }
                                        />
                                        <span className="ms-2 text-sm text-gray-600">Make Default Payment Method</span>
                                    </label>
                                </div>

                                <div className="mt-4 flex items-center gap-4">
                                    <PrimaryButton disabled={processing}>Save</PrimaryButton>

                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <p className="text-sm text-gray-600">
                                            Saved.
                                        </p>
                                    </Transition>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
