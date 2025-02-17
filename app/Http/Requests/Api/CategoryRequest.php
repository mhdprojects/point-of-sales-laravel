<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CategoryRequest",
 *     title="Category Request",
 *     description="Request structure for Category",
 *     required={"name", "is_active"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="name"
 *     ),
 *     @OA\Property(
 *          property="is_active",
 *          type="boolean",
 *          description="is_active"
 *      ),
 * )
 */
class CategoryRequest extends FormRequest{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
