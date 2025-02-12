<?php

namespace App\Repositories\Sales;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Collection;

interface SalesRepositoryInterface{
    public function all() : Collection;
    public function findById($id): ?Sales;
    public function create(array $data): ?Sales;
    public function update(array $data, $id): ?Sales;
    public function delete($id): void;
}
