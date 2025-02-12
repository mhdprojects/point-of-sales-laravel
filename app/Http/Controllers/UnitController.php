<?php

namespace App\Http\Controllers;

use App\Service\UnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UnitController extends Controller {

    public function __construct(
        protected UnitService $service
    ){}

    public function index(): \Inertia\Response{
        $data['data']   = $this->service->all();

        return Inertia::render('Unit/UnitView', $data);
    }

    public function form($id = null): \Inertia\Response{
        $form['id']         = '';
        $form['code']       = '';
        $form['name']       = '';

        if ($id){
            $search = $this->service->findById($id);

            $form['id']         = $id;
            $form['code']       = $search->code;
            $form['name']       = $search->name;
        }

        $data['form']       = $form;

        return Inertia::render('Unit/UnitForm', $data);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse{
        $body = $request->validate([
            'code' => ['required', 'string', 'min:2', 'max:4'],
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $this->service->create($body);

        return Redirect::route('unit.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Unit Successfully!',
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse{
        $body = $request->validate([
            'code' => ['required', 'string', 'min:2', 'max:4'],
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $this->service->update($body, $id);

        return Redirect::route('unit.index')->with([
            'type'      => 'success',
            'message'   => 'Saved Unit Successfully!',
        ]);
    }

    public function delete($id): \Illuminate\Http\RedirectResponse{
        $this->service->delete($id);

        return Redirect::route('unit.index')->with([
            'type'      => 'success',
            'message'   => 'Deleted Unit Successfully!',
        ]);
    }
}
