<?php
declare(strict_types=1);

namespace Dybee\Base\Common;

use Dybee\Base\PageInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

class ResponseByUmi
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function success()
    {
        $response = $this->container->get(ResponseInterface::class);
        return $response->json($this->toJson());
    }

    /**
     * 输出业务List数据
     * @param     $data
     * @param int $total
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function list($data, int $total)
    {
        $response = $this->container->get(ResponseInterface::class);
        return $response->json($this->toJson(0, $data, null, $total));
    }

    /**
     * 输出业务数据
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function data(array $data)
    {
        $response = $this->container->get(ResponseInterface::class);
        return $response->json($this->toJson(0, $data));
    }

    /**
     * 错误
     * @param string $msg
     * @param int    $code
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function error(string $msg, int $code = 1)
    {
        $response = $this->container->get(ResponseInterface::class);
        $data = $this->toJson($code, null, $msg);
        return $response->json($data);
    }

    /**
     * @return ResponseInterface
     */
    public function others()
    {
        return $this->container->get(ResponseInterface::class);
    }

    /**
     * @param int         $errorCode
     * @param             $data
     * @param string|null $errorMessage
     * @param int         $total
     * @return array
     */
    protected function toJson(int $errorCode = 0, $data = null, string $errorMessage = null, int $total = 0)
    {
        $showType = $errorCode != 0 ? 2 : 0;
        $success = $errorCode != 0 ? false : true;
        $page = 0;
        if ($total > 0) {
            $page = $this->container->get(PageInterface::class)->page;
        }
        return compact('success', 'errorCode', 'data', 'errorMessage', 'showType', 'total', 'page');
    }
}
