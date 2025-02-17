<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PaymentMethodResource",
 *     title="Payment Method Resource",
 *     description="Payment Method Resource",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="The unique identifier of the unit"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the payment method"
 *     ),
 *     @OA\Property(
 *          property="is_default",
 *          type="boolean",
 *          description="The is_default of the payment method"
 *      ),
 * )
 */
class PaymentMethodResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'is_default'    => $this->is_default,
        ];
    }
}
