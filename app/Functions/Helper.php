<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 10/14/21 at 1:10 PM
 *
 * Email redmadfinger@gmail.com
 */

use App\Functions\ResponseData;
use App\Functions\ErrorCode\CommonErrorCode;

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
 * @param array|null $data
 * @param string $message
 *
 * @return \Illuminate\Http\JsonResponse
 */
function successWithData(array $data = null, string $message = '')
{
    $responseData = CommonErrorCode::$successCode;

    // 若存在自定义信息则替换预置信息
    if ($message) {
        $responseData['message'] = $message;
    }

    // 统一返回data内容为对象
    $data = $data ? $data : new stdClass();
    // 若返回是列表时，需要转化为对象
    $data = is_array($data) && (isset($data[0])) ? ['list' => $data] : $data;

    $responseData['data'] = $data;

    return ResponseData::success($responseData);
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

/**
 * @param array $errorCode
 * @param string $message
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @throws Exception
 */
function errorWithData(array $errorCode, string $message = '')
{
    $errorCode['data'] = new stdClass();

    return ResponseData::error($errorCode, $message);
}
