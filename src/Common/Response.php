<?php
declare(strict_types=1);

namespace Dybee\Base\Common;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
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
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function success()
    {
        $response = $this->container->get(ResponseInterface::class);
        return $response->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($this->json()));
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
        return $response->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($data));
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
        return $response->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($data));
    }

    /**
     * @param int $code
     * @param $data
     * @param string|null $msg
     * @param int $total
     * @return string
     */
    private function json(int $code = 0, $data = null, string $msg = null, int $total = 0)
    {
        return Json::encode(compact('code', 'data', 'msg', 'total'));
    }
}
