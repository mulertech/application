<?php

namespace MulerTech\Application;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

/**
 * Class RequestHandler
 * @package MulerTech\Application
 * @author Sébastien Muler
 */
class RequestHandler extends Application implements RequestHandlerInterface
{
    /**
     * @var string[]
     */
    private array $middlewares;

    /**
     * @var int
     */
    private int $index = 0;

    /**
     * Add middleware
     * @param string $middleware
     * @return RequestHandler
     */
    public function pipe(string $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * @inheritDoc
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getNextMiddleware();
        if (is_null($middleware)) {
            throw new RuntimeException('No middleware was intercept this request...');
        }
        return $middleware->process($request, $this);
    }

    /**
     * @param string $middleware
     * @return RequestHandlerInterface|null
     */
    public function getMiddleware(string $middleware): ?RequestHandlerInterface
    {
        $key = array_search($middleware, $this->middlewares, true);

        if (is_int($key)) {
            $this->index = $key;
            return $this;
        }

        return null;
    }

    /**
     * @return MiddlewareInterface|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getNextMiddleware(): ?MiddlewareInterface
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            $middleware = $this->middlewares[$this->index];
            $this->index++;
            return $this->container()->get($middleware);
        }
        return null;
    }
}
