<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UnitResource",
 *     title="Unit Resource",
 *     description="Unit Resource",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="The unique identifier of the unit"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="string",
 *         description="The code of the post"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the post"
 *     ),
 * )
 */
class UnitResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'id'    => $this->id,
            'code'  => $this->code,
            'name'  => $this->name,
        ];
    }
}
