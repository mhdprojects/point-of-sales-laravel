<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface {

    public function all(): Collection{
        return Category::query()
            ->orderBy('name')
            ->get();
    }

    public function findById($id): ?Category{
        return Category::query()->findOrFail($id);
    }

    public function create(array $data): ?Category{
        return Category::query()->create($data);
    }

    public function update(array $data, $id): ?Category{
        $query = Category::query()->findOrFail($id);
        $query->update($data);

        return $query;
    }

    public function delete($id): void{
        $query = Category::query()->findOrFail($id);
        $query->delete();
    }

    public function select(): array{
        return Category::query()
            ->select([
                'id as value',
                'name as label',
            ])
            ->orderBy('name')
            ->get()
            ->toArray();
    }
}
