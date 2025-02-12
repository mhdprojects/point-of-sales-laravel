<?php

namespace App\Http\Controllers;

use App\Service\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller {

    public function __construct(
        protected CategoryService $service
    ){}

    public function index(): \Inertia\Response{
        $data['data']   = $this->service->all();

        return Inertia::render('Category/CategoryView', $data);
    }

    public function form($id = null): \Inertia\Response{
        $form['id']         = '';
        $form['name']       = '';
        $form['is_active']  = true;

        if ($id){
            $search = $this->service->findById($id);

            $form['id']         = $id;
            $form['name']       = $search->name;
            $form['is_active']  = $search->is_active;
        }

        $data['form']       = $form;

        return Inertia::render('Category/CategoryForm', $data);
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
