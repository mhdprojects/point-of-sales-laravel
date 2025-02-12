<?php

namespace App\Service;

use App\Models\Sales;
use App\Repositories\Sales\SalesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SalesService {

    public function __construct(
        protected SalesRepositoryInterface $repository
    ){}

    public function all(): Collection{
        return $this->repository->all();
    }

    public function findById($id): ?Sales{
        return $this->repository->findById($id);
    }

    public function create(array $data): ?Sales{
        return $this->repository->create($data);
    }

    public function update(array $data, $id): ?Sales{
        return $this->repository->update($data, $id);
    }

    public function delete($id): void{
        $this->repository->delete($id);
    }
}
