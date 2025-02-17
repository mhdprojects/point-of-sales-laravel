<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CategoryResource",
 *     title="Category Resource",
 *     description="Category Resource",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="The unique identifier of the unit"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the category"
 *     ),
 *     @OA\Property(
 *          property="is_active",
 *          type="boolean",
 *          description="The is_active of the category"
 *      ),
 * )
 */
class CategoryResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'is_active' => $this->is_active,
        ];
    }
}
