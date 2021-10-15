<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Functions\ErrorCode\CommonErrorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function health()
    {
        CommonErrorCode::$successCode['data'] = ["a" => "b"];

        return success(CommonErrorCode::$successCode);
    }

    public function validateRequestData(Request $request, array $rules, array $messages = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            CommonErrorCode::$errorCode['message'] = $validator->errors()->first();

            throw new ApiException();
        }
    }
}
