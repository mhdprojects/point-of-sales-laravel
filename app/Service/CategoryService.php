<?php

namespace App\Service;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryService {

    public function __construct(protected CategoryRepositoryInterface $repository){}

    public function all(): Collection{
        return $this->repository->all();
    }

    public function select(): array{
        return $this->repository->select();
    }

    public function findById($id): ?Category{
        return $this->repository->findById($id);
    }

    public function create(array $data): ?Category{
        return $this->repository->create($data);
    }

    public function update(array $data, $id): ?Category{
        return $this->repository->update($data, $id);
    }

    public function delete($id): void{
        $this->repository->delete($id);
    }
}
