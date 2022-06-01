<?php
declare(strict_types=1);

namespace Dybee\Base;

class AuthCode
{
    /** @var string session键值 */
    const SESSION_USER_NAME = 'user_session';
    /** @var int 系统异常代码 */
    const SERVER_ERROR = 5000;
    /** @var int 登陆异常代码 */
    const LOGIN_FAILED = 4000;
    /** @var int 业务异常代码 */
    const BUSINESS_ERROR = 3000;
    /** @var int 无权限错误 */
    const AUTH_ERROR = 4003;
}
