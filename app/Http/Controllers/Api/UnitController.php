<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Requests\Api\UnitRequest;
use App\Http\Resources\UnitResource;
use App\Service\UnitService;

/**
 * @OA\Tag(
 *     name="Unit",
 *     description="Data units endpoints"
 * )
 */
class UnitController extends ApiController {

    public function __construct(
        protected UnitService $service
    ){}

    /**
     * @OA\Get(
     *     path="/api/unit",
     *     summary="Get a list of units",
     *     description="Returns a list of units",
     *     tags={"Units"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: List of units",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UnitResource"),
     *             ),
     *         ),
     *     ),
     *     security={
     *          {"bearerAuth": {}}
     *     },
     * )
     */
    public function index(): \Illuminate\Http\JsonResponse{
        $data = $this->service->all();

        return ApiResponse::sendResponse(UnitResource::collection($data), 'Data Units');
    }

    /**
     * @OA\Get(
     *     path="/api/unit/{id}",
     *     summary="Get a single of units",
     *     description="Returns a single of units by ID",
     *     tags={"Units"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the unit to retrieve",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: List of units",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/UnitResource",
     *             ),
     *         ),
     *     ),
     *     security={
     *          {"bearerAuth": {}}
     *     },
     * )
     */
    public function show($id): \Illuminate\Http\JsonResponse{
        $data = $this->service->findById($id);

        return ApiResponse::sendResponse(new UnitResource($data), 'Data Unit');
    }

    /**
     * @OA\Post(
     *     path="/api/unit",
     *     summary="Store a new unit",
     *     description="Store a new unit in database",
     *     tags={"Units"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UnitRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: List of units",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/UnitResource",
     *             ),
     *         ),
     *     ),
     *     security={
     *          {"bearerAuth": {}}
     *     },
     * )
     */
    public function store(UnitRequest $request): \Illuminate\Http\JsonResponse{
        $body = $request->validated();

        $data = $this->service->create($body);

        return ApiResponse::sendResponse(new UnitResource($data), 'Inserted Data Unit');
    }

    /**
     * @OA\Put(
     *     path="/api/unit/{id}",
     *     summary="Update a new unit",
     *     description="Update a new unit in database",
     *     tags={"Units"},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID of the unit to retrieve",
     *           @OA\Schema(
     *               type="string"
     *           ),
     *       ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UnitRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: List of units",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/UnitResource",
     *             ),
     *         ),
     *     ),
     *     security={
     *          {"bearerAuth": {}}
     *     },
     * )
     */
    public function update(UnitRequest $request, $id): \Illuminate\Http\JsonResponse{
        $body = $request->validated();

        $data = $this->service->update($body, $id);

        return ApiResponse::sendResponse(new UnitResource($data), 'Updated Data Unit');
    }

    /**
     * @OA\Delete(
     *     path="/api/unit/{id}",
     *     summary="Delete a new unit",
     *     description="Delete a new unit in database",
     *     tags={"Units"},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID of the unit to retrieve",
     *           @OA\Schema(
     *               type="string"
     *           ),
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             ),
     *         ),
     *     ),
     *     security={
     *          {"bearerAuth": {}}
     *     },
     * )
     */
    public function delete($id): \Illuminate\Http\JsonResponse{
        $this->service->delete($id);

        return ApiResponse::sendResponse(null, 'Deleted Data Unit');
    }
}
