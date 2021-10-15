<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 8/4/21 at 6:21 PM
 *
 * Email redmadfinger@gmail.com
 */

namespace App\Exceptions;


class ApiException extends \Exception
{

    function __construct($message = '', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
