<?php
declare(strict_types=1);

namespace Dybee\Base\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class UserValidate extends AbstractAnnotation
{
    /**
     * @var bool 是否超级管理员
     */
    public $canAdmin = false;
    /**
     * @var bool 是否运营人员
     */
    public $canOperation = false;
    /**
     * @var bool 是否客户
     */
    public $canUser = false;
    /**
     * @var bool 是否普通用户
     */
    public $canDefault = false;

    public function __construct(
        bool $canDefault = true,
        bool $canAdmin = false,
        bool $canOperation = false,
        bool $canUser = false
    )
    {

        parent::__construct(compact('canDefault', 'canAdmin', 'canOperation', 'canUser'));
    }
}
