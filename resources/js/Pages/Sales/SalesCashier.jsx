import {Head, useForm} from "@inertiajs/react";
import {useState} from "react";
import {NumericFormat} from "react-number-format";
import {formatThousands} from "@/Helper/Utils.js";
import {RiAddBoxFill, RiDeleteBinFill, RiIndeterminateCircleFill} from "react-icons/ri";
import SecondaryButton from "@/Components/SecondaryButton.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import Modal from "@/Components/Modal.jsx";

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
        code: '',
        payment_method: null,
        subtotal: 0,
        disc_percent: 0,
        disc_amount: 0,
        total: 0,
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
        setModalPayment(true)
    }

    return (
        <div className="min-h-screen bg-white">
            <Head title="Cashier"/>

            <div className="flex flex-row w-full h-screen">
                <div className="flex-grow flex flex-col h-full overflow-y-auto">
                    <div className="select-none overflow-x-auto">
                        <div className="flex items-center gap-2 px-4 py-2">
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

                    <div className="p-2 flex-1 h-full w-full flex flex-col items-start justify-start overflow-auto">
                        {
                            data.items.map((item, index) => (
                                <div key={index} className="w-full flex items-center justify-between gap-2 mb-4">
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

                    <div className="select-none px-2 py-2">
                        <div className="w-full">
                            <PrimaryButton type="button" onClick={() => onProcessPayment()} disabled={data.items.length === 0} className="w-full justify-center">Process Payment</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>

            <Modal show={modalPayment} onClose={() => setModalPayment(!modalPayment)}>
                <div className="bg-white sm:p-8">

                </div>
            </Modal>
        </div>
    )
}
