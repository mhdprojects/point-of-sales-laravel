<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UnitRequest",
 *     title="Unit Request",
 *     description="Request structure for unit",
 *     required={"code", "name"},
 *     @OA\Property(
 *         property="code",
 *         type="string",
 *         description="code"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="name"
 *     )
 * )
 */
class UnitRequest extends FormRequest{

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'min:2', 'max:4'],
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ];
    }
}
