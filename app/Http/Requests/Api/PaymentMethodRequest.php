<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PaymentMethodRequest",
 *     title="Payment Method Request",
 *     description="Request structure for payment methods",
 *     required={"name", "is_default"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="name"
 *     ),
 *     @OA\Property(
 *          property="is_default",
 *          type="boolean",
 *          description="is_default"
 *      ),
 * )
 */
class PaymentMethodRequest extends FormRequest{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'is_default' => ['required', 'boolean'],
        ];
    }
}
