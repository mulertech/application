<?php


namespace MulerTech\Application\Tests\Middleware;


use MulerTech\Application\Hub;
use MulerTech\Application\Tests\FakeClass\AppControllerFake;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ControllerMiddleware
 * @package MulerTech\Application\Tests\Middleware
 * @author Sébastien Muler
 */
class ControllerMiddleware extends Hub implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return (new AppControllerFake())->fake();
    }
}