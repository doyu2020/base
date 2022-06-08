<?php
declare(strict_types=1);

namespace Dybee\Base;
/**
 * @property int $limit 获取单页条数
 * @property int $page 获取当前页数
 */
interface PageInterface
{
    public function __get(string $name): int;

    /**
     * @param mixed $limit 单页条数
     * @param mixed $page 当前页数
     */
    public function setPagination($limit, $page): void;
}
