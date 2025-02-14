<?php

namespace App\Http\Controllers;

use App\Http\Helper\ImageUpload;
use App\Http\Helper\Utils;
use App\Service\CategoryService;
use App\Service\ProductService;
use App\Service\UnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class ProductController extends Controller {

    public function __construct(
        protected ProductService $service,
        protected CategoryService $categoryService,
        protected UnitService $unitService
    ){}

    public function index(): \Inertia\Response{
        $data['data']   = $this->service->all();

        return Inertia::render('Product/ProductView', $data);
    }

    public function form($id = null): \Inertia\Response{
        $form['id']         = '';
        $form['code']       = '';
        $form['name']       = '';
        $form['category']   = null;
        $form['unit']       = null;
        $form['stock']      = 0;
        $form['price']      = 0;
        $form['description']= '';
        $form['image']      = '';
        $form['is_active']  = true;

        if ($id){
            $search = $this->service->findById($id);

            $form['id']         = $id;
            $form['code']       = $search->code;
            $form['name']       = $search->name;
            $form['category']   = Utils::toSelect($search->category->id, $search->category->name);
            $form['unit']       = Utils::toSelect($search->unit->id, $search->unit->name);
            $form['stock']      = (float) $search->stock;
            $form['price']      = (float) $search->price;
            $form['description']= $search->description ?? '';
            $form['image']      = $search->image;
            $form['is_active']  = $search->is_active;
        }

        $data['form']       = $form;
        $data['categories'] = $this->categoryService->select();
        $data['units']      = $this->unitService->select();

        return Inertia::render('Product/ProductForm', $data);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse{
        $param = $request->validate([
            'code' => ['required', 'string', 'min:3', 'max:30'],
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'category' => ['required', 'array'],
            'unit' => ['required', 'array'],
            'stock' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $body = [
            'code'          => $param['code'],
            'name'          => $param['name'],
            'category_id'   => $param['category']['value'],
            'unit_id'       => $param['unit']['value'],
            'stock'         => $param['stock'],
            'price'         => $param['price'],
            'description'   => $param['description'],
            'image'         => $param['image'],
            'is_active'     => $param['is_active'],
        ];

        $this->service->create($body);

        return Redirect::route('product.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Product Successfully!',
        ]);
    }

    public function update(Request $request, $id){
        $param = $request->validate([
            'code' => ['required', 'string', 'min:3', 'max:30'],
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'category' => ['required', 'array'],
            'unit' => ['required', 'array'],
            'stock' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string',],
            'is_active' => ['required', 'boolean'],
        ]);

        $body = [
            'code'          => $param['code'],
            'name'          => $param['name'],
            'category_id'   => $param['category']['value'],
            'unit_id'       => $param['unit']['value'],
            'stock'         => $param['stock'],
            'price'         => $param['price'],
            'description'   => $param['description'],
            'is_active'     => $param['is_active'],
            'image'         => $param['image'],
        ];

        $this->service->update($body, $id);

        return Redirect::route('product.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Product Successfully!',
        ]);
    }

    public function delete($id): \Illuminate\Http\RedirectResponse{
        $this->service->delete($id);

        return Redirect::route('product.index')->with([
            'type'      => 'success',
            'message'   => 'Deleted Product Successfully!',
        ]);
    }
}
