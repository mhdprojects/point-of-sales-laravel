<?php

namespace App\Http\Controllers;

use App\Service\CategoryService;
use App\Service\PaymentMethodService;
use App\Service\ProductService;
use App\Service\SalesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SalesController extends Controller {

    public function __construct(
        protected SalesService $service,
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected PaymentMethodService $paymentMethodService
    ){}

    public function index(): \Inertia\Response{
        $data['data']   = $this->service->all();

        return Inertia::render('Sales/SalesView', $data);
    }

    public function form($id = null): \Inertia\Response{
        $categories                 = $this->categoryService->all();
        $data['categories']         = $categories;

        $data['products']           = [];
        $data['category_selected']  = -1;
        if (count($categories) > 0){
            $data['products']           = $this->productService->byCategory($categories[0]->id);
            $data['category_selected']  = 0;
        }

        $data['payments']           = $this->paymentMethodService->all();

        return Inertia::render('Sales/SalesCashier', $data);
    }

    public function products($id): \Illuminate\Http\JsonResponse{
        $data = $this->productService->byCategory($id);

        return response()->json($data);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse{
        $body = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'is_active' => ['required', 'boolean'],
        ]);

        $this->service->create($body);

        return Redirect::route('category.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Category Successfully!',
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse{
        $body = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'is_active' => ['required', 'boolean'],
        ]);

        $this->service->update($body, $id);

        return Redirect::route('category.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Category Successfully!',
        ]);
    }

    public function delete($id): \Illuminate\Http\RedirectResponse{
        $this->service->delete($id);

        return Redirect::route('category.index')->with([
            'type'      => 'success',
            'message'   => 'Deleted Category Successfully!',
        ]);
    }
}
