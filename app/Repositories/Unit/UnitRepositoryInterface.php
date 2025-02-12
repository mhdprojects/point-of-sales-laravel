<?php

namespace App\Repositories\Unit;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;

interface UnitRepositoryInterface{
    public function all() : Collection;
    public function select() : array;
    public function findById($id): ?Unit;
    public function create(array $data): ?Unit;
    public function update(array $data, $id): ?Unit;
    public function delete($id): void;
}
