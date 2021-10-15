<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 10/14/21 at 1:10 PM
 *
 * Email redmadfinger@gmail.com
 */

use App\Functions\ResponseData;

/**
 * 处理接口返回值 操作成功
 *
 * @param array|object $payload 返回数据
 * @param array $headers        自定义头信息
 *
 * @return \Illuminate\Http\JsonResponse
 */
function success($payload = null, array $headers = [])
{
    return ResponseData::success($payload, $headers);
}

/**
 * 处理接口返回值 操作失败
 *
 * @param array         $errorCode 错误码
 * @param string        $message   自定义错误消息
 * @param array         $headers   自定义头信息
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @throws Exception
 */
function error(array $errorCode, string $message = '', $headers = [])
{
    return ResponseData::error($errorCode, $message, $headers);
}
