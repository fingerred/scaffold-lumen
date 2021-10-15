<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $email = base64_encode('redmadfinger@gmail.com');

    return "
<div style='text-align: center; margin-top: 10px; color: #999'>
<xmp>
 _____   _   __   _   _____   _____   _____         _____    _____   _____
|  ___| | | |  \ | | /  ___| | ____| |  _  \       |  _  \  | ____| |  _  \\
| |__   | | |   \| | | |     | |__   | |_| |       | |_| |  | |__   | | | |
|  __|  | | | |\   | | |  _  |  __|  |  _  /       |  _  /  |  __|  | | | |
| |     | | | | \  | | |_| | | |___  | | \ \       | | \ \  | |___  | |_| |
|_|     |_| |_|  \_| \_____/ |_____| |_|  \_\      |_|  \_\ |_____| |_____/

</xmp>
    <p style='color: gray'><small>Email: {$email}</small></p>
</div>
";
});

$router->get("/health", "Controller@health");

$router->group(['prefix' => 'demo'], function () use ($router) {
    $router->get('returnSuccess', 'DemoController@returnSuccess');
    $router->get('returnError', 'DemoController@returnError');
    $router->get('export', 'DemoController@export');
});
