<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface{
    public function all() : Collection;
    public function select() : array;
    public function findById($id): ?Category;
    public function create(array $data): ?Category;
    public function update(array $data, $id): ?Category;
    public function delete($id): void;
}
