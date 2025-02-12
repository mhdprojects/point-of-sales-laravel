import {Head, Link, useForm} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {Transition} from "@headlessui/react";
import Checkbox from "@/Components/Checkbox.jsx";
import {RiArrowLeftLine} from "react-icons/ri";
import Select from "react-select";
import {NumericFormat} from "react-number-format";

export default function ProductForm(props){

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
        code: props.form.code,
        name: props.form.name,
        category: props.form.category,
        unit: props.form.unit,
        stock: props.form.stock,
        price: props.form.price,
        description: props.form.description,
        image: null,
        is_active: props.form.is_active,
    });

    const submit = (e) => {
        e.preventDefault();

        if (props.form.id){
            post(route('product.update', props.form.id));
        }else{
            post(route('product.store'));
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 flex items-center gap-4">
                    <Link href={route('product.index')} className="p-1.5 border border-slate-100 rounded-full hover:border-accent hover:text-accent"><RiArrowLeftLine/></Link>
                    <p>Form Product</p>
                </h2>
            }
        >
            <Head title="Form Product" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <header>
                            <h2 className="text-lg font-medium text-gray-900">
                                Form
                            </h2>
                        </header>

                        <form onSubmit={submit} className="mt-6 space-y-6">
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel
                                        value="Product Code"
                                    />

                                    <TextInput
                                        name="code"
                                        value={data.code}
                                        onChange={(e) =>
                                            setData('code', e.target.value)
                                        }
                                        type="text"
                                        className="mt-1 block w-full"
                                        autoComplete="current-password"
                                    />

                                    <InputError
                                        message={errors.code}
                                        className="mt-2"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        value="Product Name"
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
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel
                                        value="Category"
                                    />

                                    <Select
                                        name="category"
                                        onChange={(event) => setData('category', event)}
                                        defaultValue={data.category}
                                        options={props.categories}/>

                                    <InputError
                                        message={errors.category}
                                        className="mt-2"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        value="Unit"
                                    />

                                    <Select
                                        name="unit"
                                        onChange={(event) => setData('unit', event)}
                                        defaultValue={data.unit}
                                        options={props.units}/>

                                    <InputError
                                        message={errors.unit}
                                        className="mt-2"
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel
                                        value="Stock"
                                    />

                                    <NumericFormat
                                        name="stock"
                                        value={data.stock}
                                        onValueChange={(values, sourceInfo) => setData('stock', values.floatValue)}
                                        thousandSeparator=","
                                        className="w-full border border-gray-300 rounded-lg sm:text-right"/>

                                    <InputError
                                        message={errors.stock}
                                        className="mt-2"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        value="Price"
                                    />

                                    <NumericFormat
                                        name="price"
                                        value={data.price}
                                        onValueChange={(values, sourceInfo) => setData('price', values.floatValue)}
                                        thousandSeparator=","
                                        className="w-full border border-gray-300 rounded-lg sm:text-right"/>

                                    <InputError
                                        message={errors.price}
                                        className="mt-2"
                                    />
                                </div>
                            </div>

                            <div className="max-w-xl">
                                <InputLabel
                                    value="Image"
                                />

                                <div className="flex items-center justify-between">
                                    <input name="image"
                                           onChange={(e) =>
                                               setData("image", e.target.files[0])
                                           }
                                           accept="image/png, image/jpeg"
                                           className="mt-4 text-sm text-grey-500 file:mr-5 file:py-3 file:px-10 file:rounded-full file:border-0 file:text-md file:font-semibold  file:text-white file:bg-gradient-to-r file:from-indigo-600 file:to-amber-600 hover:file:cursor-pointer hover:file:opacity-80"
                                           type="file"/>

                                    {
                                        props.form.image && <img
                                            alt={props.form.name}
                                            className="h-20"
                                            src={props.form.image}/>
                                    }
                                </div>

                                <InputError
                                    message={errors.image}
                                    className="mt-2"
                                />
                            </div>

                            <div className="max-w-xl">
                                <InputLabel
                                    value="Description"
                                />

                                <textarea
                                    name="description"
                                    rows={3}
                                    value={data.description}
                                    onChange={(event) => setData('description', event.target.value)}
                                    className="w-full border border-gray-300 rounded-lg sm:text-right"/>

                                <InputError
                                    message={errors.description}
                                    className="mt-2"
                                />
                            </div>

                            <div className="">
                                <label className="flex items-center">
                                    <Checkbox
                                        name="is_active"
                                        checked={data.is_active}
                                        onChange={(e) =>
                                            setData('is_active', e.target.checked)
                                        }
                                    />
                                    <span className="ms-2 text-sm text-gray-600">{data.is_active ? 'Active' : 'Not Active'}</span>
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
        </AuthenticatedLayout>
    )
}
