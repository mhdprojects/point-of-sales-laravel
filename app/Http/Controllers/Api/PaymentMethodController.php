<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Requests\Api\PaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Service\PaymentMethodService;

/**
 * @OA\Tag(
 *     name="Paymentmethod",
 *     description="Data payment methods endpoints"
 * )
 */
class PaymentMethodController extends ApiController {

    public function __construct(
        protected PaymentMethodService $service
    ){}

    /**
     * @OA\Get(
     *     path="/api/payment-method",
     *     summary="Get a list of Payment Method",
     *     description="Returns a list of Payment Method",
     *     tags={"Paymentmethod"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: List of Payment Method",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PaymentMethodResource"),
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

        return ApiResponse::sendResponse(PaymentMethodResource::collection($data), 'Data Payment Method');
    }

    /**
     * @OA\Get(
     *     path="/api/payment-method/{id}",
     *     summary="Get a single of Payment Method",
     *     description="Returns a single of Payment Method by ID",
     *     tags={"Paymentmethod"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the Payment Method to retrieve",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: object of payment method",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PaymentMethodResource",
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

        return ApiResponse::sendResponse(new PaymentMethodResource($data), 'Data Unit');
    }

    /**
     * @OA\Post(
     *     path="/api/payment-method",
     *     summary="Store a new Payment Method",
     *     description="Store a new Payment Method in database",
     *     tags={"Paymentmethod"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PaymentMethodRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: object of Payment Method",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PaymentMethodResource",
     *             ),
     *         ),
     *     ),
     *     security={
     *          {"bearerAuth": {}}
     *     },
     * )
     */
    public function store(PaymentMethodRequest $request): \Illuminate\Http\JsonResponse{
        $body = $request->validated();

        $data = $this->service->create($body);

        return ApiResponse::sendResponse(new PaymentMethodResource($data), 'Inserted Data Category');
    }

    /**
     * @OA\Put(
     *     path="/api/payment-method/{id}",
     *     summary="Update a new Payment Method",
     *     description="Update a new Payment Method in database",
     *     tags={"Paymentmethod"},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID of the Payment Method to retrieve",
     *           @OA\Schema(
     *               type="string"
     *           ),
     *       ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PaymentMethodRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response: object of payment method",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Data Units"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PaymentMethodResource",
     *             ),
     *         ),
     *     ),
     *     security={
     *          {"bearerAuth": {}}
     *     },
     * )
     */
    public function update(PaymentMethodRequest $request, $id): \Illuminate\Http\JsonResponse{
        $body = $request->validated();

        $data = $this->service->update($body, $id);

        return ApiResponse::sendResponse(new PaymentMethodResource($data), 'Updated Data Unit');
    }

    /**
     * @OA\Delete(
     *     path="/api/payment-method/{id}",
     *     summary="Delete a new Payment Method",
     *     description="Delete a new Payment Method in database",
     *     tags={"Paymentmethod"},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID of the Payment Method to retrieve",
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
