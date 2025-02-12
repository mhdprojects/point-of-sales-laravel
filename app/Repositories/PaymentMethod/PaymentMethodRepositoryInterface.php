<?php

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

interface PaymentMethodRepositoryInterface{
    public function all() : Collection;
    public function select() : array;
    public function findById($id): ?PaymentMethod;
    public function create(array $data): ?PaymentMethod;
    public function update(array $data, $id): ?PaymentMethod;
    public function delete($id): void;
}
