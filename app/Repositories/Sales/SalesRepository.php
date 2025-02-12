<?php

namespace App\Repositories\Sales;

use App\Http\Helper\Utils;
use App\Models\Sales;
use App\Models\SalesItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class SalesRepository implements SalesRepositoryInterface {

    public function all(): Collection{
        return Sales::query()
            ->orderByDesc('created_at')
            ->get();
    }

    public function findById($id): ?Sales{
        return Sales::query()
            ->where('id', $id)
            ->firstOrFail();
    }

    public function create(array $data): ?Sales{
        try {
            DB::beginTransaction();

            $data = new Sales();
            $data->date                 = now();
            $data->code                 = Utils::generateCode();
            $data->customer_name        = $data['customer_name'];
            $data->payment_method_id    = $data['payment_method_id'];
            $data->subtotal             = $data['subtotal'];
            $data->disc_percent         = $data['disc_percent'];
            $data->disc_amount          = $data['disc_amount'];
            $data->total                = $data['total'];
            $data->save();

            foreach ($data['items'] as $item) {
                $detail = new SalesItem();
                $detail->sales_id       = $data->id;
                $detail->product_id     = $item['product_id'];
                $detail->qty            = $item['qty'];
                $detail->price          = $item['price'];
                $detail->subtotal       = $item['subtotal'];
                $detail->save();
            }

            DB::commit();
            return $data->fresh();
        }catch (\Exception $exception){
            DB::rollBack();

            throw $exception;
        }
    }

    public function update(array $data, $id): ?Sales{
        try {
            DB::beginTransaction();

            $data = Sales::query()->findOrFail($id);
            $data->date                 = now();
            $data->code                 = Utils::generateCode();
            $data->customer_name        = $data['customer_name'];
            $data->payment_method_id    = $data['payment_method_id'];
            $data->subtotal             = $data['subtotal'];
            $data->disc_percent         = $data['disc_percent'];
            $data->disc_amount          = $data['disc_amount'];
            $data->total                = $data['total'];
            $data->save();

            foreach ($data['items'] as $item) {
                if ($item['id']){
                    $detail = SalesItem::query()->findOrFail($item['id']);

                    $detail->product_id     = $item['product_id'];
                    $detail->qty            = $item['qty'];
                    $detail->price          = $item['price'];
                    $detail->subtotal       = $item['subtotal'];
                    $detail->save();
                }else{
                    $detail = new SalesItem();
                    $detail->sales_id       = $data->id;
                    $detail->product_id     = $item['product_id'];
                    $detail->qty            = $item['qty'];
                    $detail->price          = $item['price'];
                    $detail->subtotal       = $item['subtotal'];
                    $detail->save();
                }
            }

            DB::commit();
            return $data->fresh();
        }catch (\Exception $exception){
            DB::rollBack();

            throw $exception;
        }
    }

    public function delete($id): void{
        try {
            DB::beginTransaction();

            SalesItem::query()->where('sales_id', $id)->delete();
            Sales::query()->where('id', $id)->delete();

            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();

            throw $exception;
        }
    }
}
