<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 8/12/21 at 3:31 PM
 *
 * Email redmadfinger@gmail.com
 */

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

/**
 * Class ReqAndResLogMiddleware
 *
 * @package App\Http\Middleware
 */
class ReqAndResLogMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $response =  $next($request);

        if ($response instanceof JsonResponse) {
            Log::info("Request-Response: ", [
                'request' => [
                    'url' => $request->url(),
                    'parameter' => $request->all()
                ],
                'response' => json_decode($response->getContent(), true)
            ]);
        }

        return $response;
    }
}
