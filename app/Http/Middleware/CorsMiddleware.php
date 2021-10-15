<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Create by Red.jiang in 10/15/21 at 3:18 PM
 *
 * Email redmadfinger@gmail.com
 */
class CorsMiddleware
{
    private $headers;
    private $allowOrigin;

    /**
     * @param Request $request
     * @param \Closure $next
     *
     * @return Response|mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $this->headers = [
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE',
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
            // 允许客户端发送cookie
            'Access-Control-Allow-Credentials' => 'true',
            // 该字段可选，用来指定本次预检请求的有效期，在此期间，不用发出另一条预检请求。
            'Access-Control-Max-Age' => 1728000
        ];

        $this->allowOrigin = ['*'];
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

        // 如果origin不在允许列表内，直接返回403
        if (!in_array('*', $this->allowOrigin) ||
            (!in_array('*', $this->allowOrigin) && !in_array($origin, $this->allowOrigin) && !empty($origin))) {

            return new Response('Forbidden', 403);
        }

        // 如果是复杂请求，先返回一个200，并allow该origin
        if ($request->isMethod('options')) {
            return $this->setCorsHeaders(new Response('OK', 200), $origin);
        }

        // 如果是简单请求或者非跨域请求，则照常设置header
        $response = $next($request);
        $methodVariable = array($response, 'header');

        // 这个判断是因为在开启session全局中间件之后，频繁的报header方法不存在，所以加上这个判断，存在header方法时才进行header的设置
        if (is_callable($methodVariable, false, $callable_name)) {
            return $this->setCorsHeaders($response, $origin);
        }

        return $response;
    }

    /**
     * @param $response
     * @param $origin
     *
     * @return mixed
     */
    public function setCorsHeaders($response, $origin)
    {
        foreach ($this->headers as $key => $value) {
            $response->header($key, $value);
        }

        if (in_array($origin, $this->allowOrigin)) {
            $response->header('Access-Control-Allow-Origin', $origin);
        } else {
            $response->header('Access-Control-Allow-Origin', '*');
        }

        return $response;
    }
}