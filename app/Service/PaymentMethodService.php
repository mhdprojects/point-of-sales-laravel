<?php

namespace App\Service;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodService {

    public function __construct(
        protected PaymentMethodRepositoryInterface $repository
    ){}

    public function all(): Collection{
        return $this->repository->all();
    }

    public function select(): array{
        return $this->repository->select();
    }

    public function findById($id): ?PaymentMethod{
        return $this->repository->findById($id);
    }

    public function create(array $data): ?PaymentMethod{
        return $this->repository->create($data);
    }

    public function update(array $data, $id): ?PaymentMethod{
        return $this->repository->update($data, $id);
    }

    public function delete($id): void{
        $this->repository->delete($id);
    }
}
