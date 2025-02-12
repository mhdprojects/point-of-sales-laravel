<?php

namespace App\Http\Controllers;

use App\Service\PaymentMethodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PaymentMethodController extends Controller {

    public function __construct(
        protected PaymentMethodService $service
    ){}

    public function index(): \Inertia\Response{
        $data['data']   = $this->service->all();

        return Inertia::render('Payment/PaymentView', $data);
    }

    public function form($id = null): \Inertia\Response{
        $form['id']         = '';
        $form['name']       = '';
        $form['is_default'] = false;

        if ($id){
            $search = $this->service->findById($id);

            $form['id']         = $id;
            $form['name']       = $search->name;
            $form['is_default'] = $search->is_default;
        }

        $data['form']       = $form;

        return Inertia::render('Payment/PaymentForm', $data);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse{
        $body = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'is_default' => ['required', 'boolean'],
        ]);

        $this->service->create($body);

        return Redirect::route('paymentmethod.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Payment Method Successfully!',
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse{
        $body = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'is_default' => ['required', 'boolean'],
        ]);

        $this->service->update($body, $id);

        return Redirect::route('paymentmethod.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Payment Method Successfully!',
        ]);
    }

    public function delete($id): \Illuminate\Http\RedirectResponse{
        $this->service->delete($id);

        return Redirect::route('paymentmethod.index')->with([
            'type'      => 'success',
            'message'   => 'Deleted Payment Method Successfully!',
        ]);
    }
}
