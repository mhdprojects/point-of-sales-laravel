<?php

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface {
    public function all(): Collection{
        return PaymentMethod::query()->orderBy('name')
            ->get();
    }

    public function findById($id): ?PaymentMethod{
        return PaymentMethod::query()->findOrFail($id);
    }

    public function create(array $data): ?PaymentMethod{
        if ($data['is_default']){
            $cari = PaymentMethod::query()
                ->where('is_default', true)
                ->get();
            foreach ($cari as $item) {
                $item->is_default = false;
                $item->save();
            }
        }

        return PaymentMethod::query()->create($data);
    }

    public function update(array $data, $id): ?PaymentMethod{
        if ($data['is_default']){
            $cari = PaymentMethod::query()
                ->where('is_default', true)
                ->where('id', '!=', $id)
                ->get();
            foreach ($cari as $item) {
                $item->is_default = false;
                $item->save();
            }
        }

        $query = PaymentMethod::query()->findOrFail($id);
        $query->update($data);

        return $query;
    }

    public function delete($id): void{
        $query = PaymentMethod::query()->findOrFail($id);
        $query->delete();
    }

    public function select(): array{
        return PaymentMethod::query()
            ->select([
                'id as value',
                'name as label',
            ])
            ->orderBy('name')
            ->get()
            ->toArray();
    }
}
