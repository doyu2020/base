<?php
declare(strict_types=1);

namespace Dybee\Base\Common;

use Dybee\Base\PageInterface;
use Hyperf\Context\Context;

class PageService implements PageInterface
{
    private const PAGE_LIMIT_KEY = 'paginationKey';
    private const Default = [
        'page' => 1,
        'limit' => 20,
    ];

    public function __get(string $name): int
    {
        return Context::get(self::PAGE_LIMIT_KEY, self::Default)[$name];
    }

    /**
     * @param mixed $limit 单页条数
     * @param mixed $page 当前页数
     */
    public function setPagination($limit, $page): void
    {
        Context::set(self::PAGE_LIMIT_KEY, [
            'page' => (int) $page,
            'limit' => (int) $limit,
        ]);
    }
}
