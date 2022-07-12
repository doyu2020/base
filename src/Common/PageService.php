<?php
declare(strict_types=1);

namespace Dybee\Base\Common;

use Dybee\Base\PageInterface;
use Dybee\Base\SiteServiceInterface;
use Hyperf\Context\Context;
use Hyperf\Utils\ApplicationContext;

class PageService implements PageInterface
{
    private const PAGE_LIMIT_KEY = 'paginationKey';
    private const Default = [
        'page' => 1,
        'limit' => 20,
        'site' => null,
        'channel' => null,
    ];

    public function __get(string $name)
    {
        return Context::get(self::PAGE_LIMIT_KEY, self::Default)[$name] ?? null;
    }

    /**
     * @param mixed $limit 单页条数
     * @param mixed $page 当前页数
     */
    public function setPagination($limit, $page): void
    {
        Context::override(self::PAGE_LIMIT_KEY, function ($value) use ($limit, $page) {
            return array_merge($value ?? [], [
                'page' => (int) $page,
                'limit' => (int) $limit,
            ]);
        });
    }

    /**
     * 设置网站ID.
     * @param int $siteId
     * @return void
     */
    public function setSite(int $siteId): void
    {
        $res = ApplicationContext::getContainer()->get(SiteServiceInterface::class)->info($siteId);
        $channel = $res->channel ?? [];
        unset($res->channel);
        $site = $res;
        Context::override(self::PAGE_LIMIT_KEY, function ($value) use ($site, $channel) {
            return array_merge($value ?: [], [
                'site' => $site,
                'channel' => $channel,
            ]);
        });
    }
}
