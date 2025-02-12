<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface {

    public function all(): Collection{
        return Product::query()->orderBy('code')
            ->with('category')
            ->with('unit')
            ->get();
    }

    public function findById($id): ?Product{
        return Product::query()->where('id', $id)
            ->with('category')
            ->with('unit')
            ->firstOrFail();
    }

    public function create(array $data): ?Product{
        return Product::query()->create($data);
    }

    public function update(array $data, $id): ?Product{
        $query = Product::query()->findOrFail($id);
        $query->update($data);

        return $query;
    }

    public function delete($id): void{
        $query = Product::query()->findOrFail($id);
        $query->delete();
    }

    public function byCategory($id): Collection{
        return Product::query()->orderBy('code')
            ->where('category_id', $id)
            ->with('category')
            ->with('unit')
            ->get();
    }
}
