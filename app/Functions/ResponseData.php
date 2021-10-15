<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 10/15/21 at 3:50 PM
 *
 * Email redmadfinger@gmail.com
 */

namespace App\Functions;

use stdClass;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class ResponseData
 *
 * @package App\Functions
 */
class ResponseData
{
    /**
     * 返回正常响应(HTTP_CODE:200)
     *
     * @param array|object $data  数据主体
     * @param array     $headers    自定义头信息
     * @return \Illuminate\Http\JsonResponse;
     */
    public static function success($data = null, array $headers = [])
    {
        if (null === $data) {
            $data = new StdClass();
        }

        // 为统一响应格式，这里强制约束为 JSON 对象
        return static::json((object)$data, 200, $headers);
    }

    /**
     * 返回未授权响应(HTTP_CODE:401)
     *
     * @param array     $errorData  预置错误
     * @param string    $message    自定义消息
     * @param array     $headers    自定义头信息
     * @return \Illuminate\Http\JsonResponse;
     * @throws Exception
     */
    public static function unauthorized(array $errorData, string $message = '', array $headers = [])
    {
        $data = static::errorBuilder($errorData, $message);

        return static::json($data, 401, $headers);
    }

    /**
     * 返回异常响应(HTTP_CODE:500)
     *
     * @param array     $errorData  预置错误
     * @param string    $message    自定义消息
     * @param array     $headers    自定义头信息
     * @return \Illuminate\Http\JsonResponse;
     * @throws Exception
     */
    public static function error(array $errorData, string $message = '', array $headers = [])
    {
        $data = static::errorBuilder($errorData, $message);

        return static::json($data, 500, $headers);
    }

    /**
     * 定制响应数据
     *
     * @param  object|array $data       数据主体
     * @param  int          $status     Http code
     * @param  array        $headers    自定义头信息
     * @return \Illuminate\Http\JsonResponse;
     */
    public static function json($data = null, $status = 200, array $headers = [])
    {
        // 由于响应为 UTF-8，这里直接输出中文字符而不进行 Unicode 编码
        return new JsonResponse($data, $status, $headers, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 组装错误消息
     *
     * @param array     $error      预置错误
     * @param string    $message    自定义消息
     * @return array
     * @throws Exception
     */
    private static function errorBuilder(array $error, string $message = '')
    {
        // 防止 ErrorData 定义不规范，此处做下校验
        if (!isset($error['code'], $error['message'])) {
            throw new Exception('Invalid RPC error code');
        }
        $data = [
            'code' => $error['code'],
            'message' => $error['message']
        ];
        // 如果有自定义消息，则覆盖预置消息
        if ('' !== $message) {
            $data['message'] = $message;
        }

        return $data;
    }
}
