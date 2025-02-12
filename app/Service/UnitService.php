<?php

namespace App\Service;

use App\Models\Unit;
use App\Repositories\Unit\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UnitService {

    public function __construct(
        protected UnitRepositoryInterface $repository
    ){}

    public function all(): Collection{
        return $this->repository->all();
    }

    public function select(): array{
        return $this->repository->select();
    }

    public function findById($id): ?Unit{
        return $this->repository->findById($id);
    }

    public function create(array $data): ?Unit{
        return $this->repository->create($data);
    }

    public function update(array $data, $id): ?Unit{
        return $this->repository->update($data, $id);
    }

    public function delete($id): void{
        $this->repository->delete($id);
    }
}
