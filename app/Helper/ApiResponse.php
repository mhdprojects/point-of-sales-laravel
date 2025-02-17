<?php

namespace App\Helper;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponse{

    public static function rollback($e, $message ="Something went wrong! Process not completed"): void{
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message ="Something went wrong! Process not completed"){
        Log::info($e);
        throw new HttpResponseException(response()->json(["message"=> $message], 500));
    }

    public static function sendResponse($result , $message = '', $status = true ,$code=200): \Illuminate\Http\JsonResponse{
        $response=[
            'status'  => $status,
            'data'    => $result
        ];

        if(!empty($message)){
            $response['msg'] =$message;
        }

        return response()->json($response, $code);
    }

    public static function sendError($message = '', $result = null, $status = false ,$code=200): \Illuminate\Http\JsonResponse{
        $response=[
            'success' => $status,
            'data'    => $result
        ];

        if(!empty($message)){
            $response['msg'] =$message;
        }

        return response()->json($response, $code);
    }
}
