<?php
declare(strict_types=1);

namespace Dybee\Base\Common;

use Hyperf\HttpServer\Contract\ResponseInterface;

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
        return $response->json($this->json());
    }

    /**
     * 输出业务数据
     * @param     $data
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
     * @param int    $code
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function error(string $msg, int $code = 1, bool $success = true)
    {
        $response = $this->container->get(ResponseInterface::class);
        $data = $this->json($code, null, $msg);
        return $response->json($data);
    }

    /**
     * @return ResponseInterface
     */
    public function athers()
    {
        return $this->container->get(ResponseInterface::class);
    }

    /**
     * @param int         $code
     * @param             $data
     * @param string|null $msg
     * @param int         $total
     * @return array
     */
    protected function json(int $errorCode = 0, $data = null, string $errorMessage = null, int $total = 0)
    {
        $showType = $errorCode != 0 ? 2 : 0;
        $success = $errorCode != 0 ? false : true;
        return compact('success', 'errorCode', 'data', 'errorMessage', 'total', 'showType');
    }
}
