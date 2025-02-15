import {Head, Link, useForm} from "@inertiajs/react";
import { useState} from "react";
import {NumericFormat} from "react-number-format";
import {formatThousands} from "@/Helper/Utils.js";
import {RiAddBoxFill, RiArrowGoBackFill, RiDeleteBinFill, RiIndeterminateCircleFill} from "react-icons/ri";
import SecondaryButton from "@/Components/SecondaryButton.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import Modal from "@/Components/Modal.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import InputError from "@/Components/InputError.jsx";
import Swal from "sweetalert2";

export default function SalesCashier(props){
    const [categoryIndexSelected, setCategoryIndexSelected] = useState(props.category_selected)
    const [listProducts, setListProducts] = useState(props.products)
    const [modalPayment, setModalPayment] = useState(false)

    const {
        data,
        setData,
        errors,
        post,
        reset,
        processing,
        recentlySuccessful,
    } = useForm({
        payment_method: null,
        subtotal: 0,
        disc_percent: 0,
        disc_amount: 0,
        total: 0,
        cash: 0,
        items: [],
    });

    const onClickCategory = (index) => {
        setCategoryIndexSelected(index)

        return fetch(route('sales.products', props.categories[index].id))
            .then(response => response.json())
            .then((result) => {
                setListProducts(result)
            })
    }

    const onAddItems = (index) => {
        const model = data.items

        let updateIndex = -1
        model.map((item, pos) => {
            if (item.product.id === listProducts[index].id){
                updateIndex = pos
            }
        })

        if (updateIndex === -1){
            model.push({
                id: "",
                product: listProducts[index],
                qty: 1,
                price: parseFloat(listProducts[index].price),
                subtotal: parseFloat(listProducts[index].price)
            })
        }else{
            const qty = model[updateIndex].qty + 1
            model[updateIndex].qty = qty
            model[updateIndex].subtotal = qty * model[updateIndex].price
        }

        recalculate(model)
    }

    const onClearItems = () => {
        recalculate([])
    }

    const recalculate = (items) => {
        let subtotal = 0
        items.map((item) => {
            subtotal += item.subtotal
        })

        const newData = {
            items: items,
            subtotal: subtotal
        }

        setData({...data, ...newData})
    }

    const onItemPlusClick = (index) => {
        const model = data.items

        const qty = model[index].qty + 1
        model[index].qty = qty
        model[index].subtotal = qty * model[index].price

        recalculate(model)
    }

    const onItemMinusClick = (index) => {
        const model = data.items

        if (model[index].qty === 1){
            model.splice(index, 1)
        }else{
            const qty = model[index].qty -1
            model[index].qty = qty
            model[index].subtotal = qty * model[index].price
        }

        recalculate(model)
    }

    const onProcessPayment = () => {
        const newData = {
            total: data.subtotal,
            cash: data.subtotal,
        }
        setData({...data, ...newData})

        setModalPayment(true)
    }

    const onClickPaymentMethod = (index) => {
        const newData = {
            payment_method: props.payments[index],
        }

        setData({...data, ...newData})
    }

    const onSubmit = (e) => {
        e.preventDefault()

        post(route('sales.store'), {
            onSuccess: () => {
                const newData = {
                    payment_method: null,
                    subtotal: 0,
                    disc_percent: 0,
                    disc_amount: 0,
                    total: 0,
                    cash: 0,
                    items: [],
                }

                setData({...data, ...newData})
                setModalPayment(false)

                Swal.fire({
                    title: "Successfully!",
                    text: "Sales Saved!",
                    icon: "success"
                });
            }
        })
    }

    return (
        <div className="min-h-screen bg-white">
            <Head title="Cashier"/>

            <div className="flex flex-row w-full h-screen">
                <div className="flex-grow flex flex-col h-full overflow-y-auto">
                    <div className="select-none overflow-x-auto">
                        <div className="flex items-center gap-2 px-4 py-2">
                            <Link href={route('sales.index')} className="border border-gray-200 rounded-lg px-4 py-2 text-accent hover:bg-accent/10">
                                <RiArrowGoBackFill/>
                            </Link>
                            {
                                props.categories.map((item, index) => (
                                    <button key={index} onClick={() => onClickCategory(index)}
                                            className={`border border-accent ${categoryIndexSelected === index ? 'bg-accent text-white hover:bg-accent/80' : 'bg-transparent text-black hover:bg-accent/10 hover:text-accent'}  px-2 py-2 rounded-lg text-sm font-semibold transition duration-150 ease-in-out`}
                                            type="button">
                                        {item.name}
                                    </button>
                                ))
                            }
                        </div>
                    </div>

                    <div className="flex-1 grid grid-cols-5 gap-4 p-4 overflow-auto">
                        {
                            listProducts.map((item, index) => (
                                <button type="button" key={index}
                                        onClick={() => onAddItems(index)}
                                        className="rounded-lg shadow-lg hover:scale-110 transition duration-150 ease-in-out mb-2">
                                    <img alt={item.code} src={item.image} className="rounded-t-lg"/>
                                    <div className="py-2 px-1">
                                        <p className="text-sm font-semibold">{item.name}</p>
                                        <NumericFormat
                                            className="text-sm font-semibold text-black"
                                            displayType="text"
                                            value={parseFloat(item.price)}
                                            thousandSeparator=","/>
                                    </div>
                                </button>
                            ))
                        }
                    </div>
                </div>

                <div className="w-3/5 bg-gray-50 h-full flex flex-col">
                    <div className="select-none">
                        <div className="flex items-center gap-4 justify-between bg-primary px-2 py-4 text-white">
                            <h4 className="text-2xl font-semibold transition duration-150 ease-in-out mb-2">{formatThousands(data.subtotal)}</h4>
                        </div>
                    </div>

                    <div className="p-2 flex-1 h-full w-full ">
                        {
                            data.items.length === 0 ? <div className="w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-16 inline-block" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p>
                                    CART EMPTY
                                </p>
                            </div> : <div className="w-full flex flex-col items-start justify-start overflow-auto">
                                {
                                    data.items.map((item, index) => (
                                        <div key={index}
                                             className="w-full flex items-center justify-between gap-2 mb-4">
                                            <div className="flex items-center gap-2">
                                            <img alt={item.product.code} src={item.product.image} className="h-12 w-12 rounded-lg"/>
                                                <div>
                                                    <p className="text-sm font-semibold">#{item.product.code} {item.product.name}</p>
                                                    <p className="text-sm">{item.qty} x {formatThousands(item.price)} = {formatThousands(item.subtotal)}</p>
                                                </div>
                                            </div>
                                            <div className="flex items-center gap-2">
                                                <button type="button" onClick={() => onItemMinusClick(index)}
                                                        className="border px-1 py-1 rounded-lg hover:bg-gray-100">{
                                                    item.qty === 1 ? <RiDeleteBinFill className="text-lg text-red-600"/> : <RiIndeterminateCircleFill className="text-lg text-red-600"/>
                                                }</button>
                                                <p className="text-lg font-semibold">{item.qty}</p>
                                                <button type="button" onClick={() => onItemPlusClick(index)}
                                                        className="border px-1 py-1 rounded-lg hover:bg-gray-100"><RiAddBoxFill className="text-lg text-green-600"/></button>
                                            </div>
                                        </div>
                                    ))
                                }
                                {
                                    data.items.length > 0 && <div className="w-full">
                                        <SecondaryButton onClick={() => onClearItems()} className="w-full justify-center">Clear</SecondaryButton>
                                    </div>
                                }
                            </div>
                        }
                    </div>

                    <div className="select-none px-2 py-2">
                        <div className="w-full">
                            <PrimaryButton type="button" onClick={() => onProcessPayment()} disabled={data.items.length === 0} className="w-full justify-center">Process Payment</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>

            <Modal show={modalPayment} onClose={() => setModalPayment(!modalPayment)}>
                <div className="bg-white sm:p-8">
                    <form onSubmit={onSubmit}>
                        <div>
                            <InputLabel
                                value="Payment Method"/>

                            <div className="mt-4 grid grid-cols-3 gap-2">
                                {
                                    props.payments.map((item, index) => (
                                        <button key={index} onClick={() => onClickPaymentMethod(index)} type="button"
                                            className={`border ${item.id === data.payment_method?.id ? 'bg-accent text-white hover:bg-accent/80' : 'bg-transparent hover:bg-accent/10'} border-accent py-2 rounded-lg text-sm font-semibold`}>{item.name}</button>
                                    ))
                                }
                            </div>

                            <InputError
                                message={errors.payment_method}
                                className="mt-2"
                            />
                        </div>

                        <div className="mt-6">
                            <InputLabel
                                value="Cash"
                            />

                            <NumericFormat
                                name="stock"
                                value={data.cash}
                                onValueChange={(values, sourceInfo) => setData('cash', values.floatValue)}
                                thousandSeparator=","
                                className="w-full border border-gray-300 rounded-lg sm:text-right"/>

                            <InputError
                                message={errors.cash}
                                className="mt-2"
                            />
                        </div>

                        <div className="mt-12">
                            <PrimaryButton className="w-full justify-center py-4" disabled={processing}>Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>
    )
}
