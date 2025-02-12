import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head, router} from "@inertiajs/react";
import LinkPrimary from "@/Components/LinkPrimary.jsx";
import {RiCheckboxBlankCircleFill, RiEdit2Line} from "react-icons/ri";
import LinkSecondary from "@/Components/LinkSecondary.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {BiTrash} from "react-icons/bi";
import Swal from "sweetalert2";
import toast from "react-hot-toast";
import {useEffect} from "react";

export default function CategoryView(props){

    useEffect(() => {
        notify()
    }, [props.flash])

    const notify = () => {
        if (props.flash.message){
            if(props.flash.type === 'success'){
                toast.success(props.flash.message)
            }else {
                toast.error(props.flash.message)
            }
        }
    }

    const handleDelete = (id) => {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "bg-green-600 text-white px-4 py-2 rounded-xl font-semibold",
                cancelButton: "bg-red-600 text-white px-4 py-2 rounded-xl font-semibold",
                actions: "flex items-center gap-2",
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Warning!",
            text: "Are you sure delete this data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete!",
            cancelButtonText: "No, Cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route('category.delete', id));
            }
        });
    }

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Category
                </h2>
            }>
            <Head title="Category" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="border-b border-slate-100">
                            <div className="p-6 text-gray-900 flex items-center justify-between">
                                <h4 className="text-lg font-semibold">Data Category</h4>
                                <LinkPrimary href={route('category.add')}>Add New</LinkPrimary>
                            </div>
                        </div>
                        <div className="p-6 text-gray-900 w-full">
                            <div className="relative overflow-x-auto">
                                <table
                                    className="w-full text-sm text-left">
                                    <thead
                                        className="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" className="px-6 py-3">
                                            Category name
                                        </th>
                                        <th scope="col" className="px-6 py-3">
                                            Status
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-right">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {
                                        props.data.length === 0 ? <tr className="bg-white border-b border-gray-200">
                                            <th colSpan={3}
                                                className="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                No Items
                                            </th>
                                        </tr> : <>
                                        {
                                            props.data.map((item, index) => (
                                                <tr key={index} className="bg-white border-b border-gray-200">
                                                    <th
                                                        className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        {item.name}
                                                    </th>
                                                    <th
                                                        className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        {
                                                            item.is_active ? <div className="flex items-center gap-1"><RiCheckboxBlankCircleFill className="text-green-700"/> <p className="text-green-800">Active</p></div> :
                                                                <div className="flex items-center gap-1"><RiCheckboxBlankCircleFill className="text-red-700"/><p className="text-red-800"> Not Active</p></div>
                                                        }
                                                    </th>
                                                    <td className="px-6 py-4 text-right">
                                                        <div className="flex items-center gap-1 justify-end">
                                                            <LinkSecondary href={route('category.edit', item.id)} data-tooltip-id="my-tooltip" data-tooltip-content="Edit Data"><RiEdit2Line/></LinkSecondary>
                                                            <PrimaryButton onClick={() => handleDelete(item.id)} type="button" data-tooltip-id="my-tooltip" data-tooltip-content="Delete Data"><BiTrash/></PrimaryButton>
                                                        </div>
                                                    </td>
                                                </tr>
                                            ))
                                        }
                                        </>
                                    }
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
