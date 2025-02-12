<?php

namespace App\Repositories\Unit;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;

class UnitRepository implements UnitRepositoryInterface {

    public function all(): Collection{
        return Unit::query()->orderBy('code')
            ->get();
    }

    public function findById($id): ?Unit{
        return Unit::query()->findOrFail($id);
    }

    public function create(array $data): ?Unit{
        return Unit::query()->create($data);
    }

    public function update(array $data, $id): ?Unit{
        $query = Unit::query()->findOrFail($id);
        $query->update($data);

        return $query;
    }

    public function delete($id): void{
        $query = Unit::query()->findOrFail($id);

        $query->delete();
    }

    public function select(): array{
        return Unit::query()
            ->select([
                'id as value',
                'name as label',
            ])
            ->orderBy('code')
            ->get()
            ->toArray();
    }
}
