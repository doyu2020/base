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

namespace Dybee\Base\Common;

use Dybee\Base\AuthCode;
use Dybee\Base\Exception\AuthException;
use Hyperf\Context\Context;
use Hyperf\Contract\SessionInterface;

/**
 * @property int    $id 用户ID
 * @property string $user_name 用户名
 * @property int    $user_access 用户权限 1-基础权限 2-客户权限 3-运营权限 4-超级权限
 * @property bool   $canAdmin 是否有超级管理员权限
 * @property bool   $canOperation 是否有运营权限
 * @property bool   $canUser 是否有客户权限
 * @property bool   $canDefault 是否有普通权限
 */
class Session
{
    public function __construct(private SessionInterface $session)
    {
    }

    public function __get($name)
    {
        $user = Context::get(AuthCode::SESSION_USER_NAME);
        if (!$user) {
            throw new AuthException('请先登陆', AuthCode::LOGIN_FAILED);
        }
        return $user[$name] ?? throw new AuthException(sprintf('USER_SESSION_NAME[%s]不存在', $name));
    }

    /**
     * 中间件调用初始化用户session.
     * @return void
     */
    public function initHandle(): void
    {
        if ($user = $this->session->get(AuthCode::SESSION_USER_NAME)) {
            $user['canAdmin'] = $user['user_access'] >= 4;
            $user['canOperation'] = $user['user_access'] >= 3;
            $user['canUser'] = $user['user_access'] >= 2;
            $user['canDefault'] = $user['user_access'] >= 1;
            Context::set(AuthCode::SESSION_USER_NAME, $user);
        }
    }

    public function getUser(): array
    {
        return Context::get(AuthCode::SESSION_USER_NAME, []);
    }

    public function setUser(array $data)
    {
        $this->session->set(AuthCode::SESSION_USER_NAME, $data);
    }
}
