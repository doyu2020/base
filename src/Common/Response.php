<?php
declare(strict_types=1);

namespace Dybee\Base\Common;

use Psr\Container\ContainerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class Response
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
        return $response->json($this->json());
    }

    /**
     * 输出业务数据
     * @param $data
     * @param int $total
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function data($data, int $total = 0)
    {
        $response = $this->container->get(ResponseInterface::class);
        $data = $this->json(0, $data, null, $total);
        return $response->json($data);
    }

    /**
     * 错误
     * @param string $msg
     * @param int $code
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function error(string $msg, int $code = 1)
    {
        $response = $this->container->get(ResponseInterface::class);
        $data = $this->json($code, null, $msg);
        return $response->json($data);
    }

    /**
     * @param int $code
     * @param $data
     * @param string|null $msg
     * @param int $total
     * @return array
     */
    private function json(int $code = 0, $data = null, string $msg = null, int $total = 0)
    {
        return compact('code', 'data', 'msg', 'total');
    }
}
