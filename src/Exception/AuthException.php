<?php
declare(strict_types=1);

namespace Dybee\Base\Exception;

use Dybee\Base\AuthCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;
class AuthException extends ServerException
{
    public function __construct(string $message, int $code = AuthCode::AUTH_ERROR, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
