<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Dybee\Base\Exception;

use Dybee\Base\ErrorCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class BusinessException extends ServerException
{
    public function __construct(string $message, int $code = ErrorCode::BUSINESS_ERROR, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
