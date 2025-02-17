<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Requests\Api\UnitRequest;
use App\Http\Resources\CategoryResource;
use App\Service\CategoryService;

/**
 * @OA\Tag(
 *     name="Category",
 *     description="Data category endpoints"
 * )
 */
class CategoryController extends ApiController {

    public function __construct(
        protected CategoryService $service
    ){}

    /**
     * @OA\Get(
     *     path="/api/category",
     *     summary="Get a list of Category",
     *     description="Returns a list of Category",
     *     tags={"Category"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: List of Category",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/CategoryResource"),
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

        return ApiResponse::sendResponse(CategoryResource::collection($data), 'Data Category');
    }

    /**
     * @OA\Get(
     *     path="/api/category/{id}",
     *     summary="Get a single of Category",
     *     description="Returns a single of Category by ID",
     *     tags={"Category"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the Category to retrieve",
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
     *                 ref="#/components/schemas/CategoryResource",
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

        return ApiResponse::sendResponse(new CategoryResource($data), 'Data Unit');
    }

    /**
     * @OA\Post(
     *     path="/api/category",
     *     summary="Store a new category",
     *     description="Store a new unit in database",
     *     tags={"Category"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: List of Category",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/CategoryResource",
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

        return ApiResponse::sendResponse(new CategoryResource($data), 'Inserted Data Category');
    }

    /**
     * @OA\Put(
     *     path="/api/category/{id}",
     *     summary="Update a new Category",
     *     description="Update a new unit in database",
     *     tags={"Category"},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID of the Category to retrieve",
     *           @OA\Schema(
     *               type="string"
     *           ),
     *       ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
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
     *                 ref="#/components/schemas/CategoryResource",
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

        return ApiResponse::sendResponse(new CategoryResource($data), 'Updated Data Unit');
    }

    /**
     * @OA\Delete(
     *     path="/api/category/{id}",
     *     summary="Delete a new Category",
     *     description="Delete a new unit in database",
     *     tags={"Category"},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID of the Category to retrieve",
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
