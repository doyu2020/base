<?php
declare(strict_types=1);

namespace Dybee\Base\Annotation;

use Dybee\Base\Common\Session;
use Dybee\Base\Exception\AuthException;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;

#[Aspect]
class UserValidateAspect extends AbstractAspect
{
    public $annotations = [
        UserValidate::class
    ];

    public function __construct(private Session $session)
    {

    }

    /**
     * @return mixed return the value from process method of ProceedingJoinPoint, or the value that you handled
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {

        $className = $proceedingJoinPoint->className;
        $methodName = $proceedingJoinPoint->methodName;
        $result = $proceedingJoinPoint->getAnnotationMetadata();
        foreach ($result->class as $class) {
            $auth = $this->validate($class);
            if (!$auth) $this->error($className,$methodName);
        }
        foreach ($result->method as $method) {
            $auth = $this->validate($method);
            if (!$auth) $this->error($className,$methodName);
        }
        return $proceedingJoinPoint->process();
    }

    private function error($className,$methodName)
    {
        throw new AuthException(sprintf(
            '用户[%s]权限组[%s] 无权访问[%s:%s]',
            $this->session->user_name, $this->session->user_name, $className, $methodName
        ));
    }

    private function validate(UserValidate $class)
    {
        if ($class->canAdmin && !$this->session->canAdmin) return false;
        if ($class->canOperation && !$this->session->canOperation) return false;
        if ($class->canUser && !$this->session->canUser) return false;
        if ($class->canDefault && !$this->session->canDefault) return false;
        return true;
    }
}
