<?php

namespace App\Http\Controllers;

use App\Functions\CommonErrorCode;
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
}
