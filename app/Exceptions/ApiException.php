<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 8/4/21 at 6:21 PM
 *
 * Email redmadfinger@gmail.com
 */

namespace App\Exceptions;

use App\Functions\ErrorCode\CommonErrorCode;

class ApiException extends \Exception
{
    function __construct(array $errorCode = [])
    {
        $code = isset($errorCode['code']) ? $errorCode['code'] : CommonErrorCode::$errorCode['code'];
        $message = isset($errorCode['message']) ? $errorCode['message'] : CommonErrorCode::$errorCode['message'];

        parent::__construct($message, $code);
    }
}
