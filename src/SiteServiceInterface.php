<?php
declare(strict_types=1);

namespace Dybee\Base;

interface SiteServiceInterface
{
    /**
     * 网站信息.
     * @param int $id 网站id
     * @return object
     */
    public function info($id): object;
}
