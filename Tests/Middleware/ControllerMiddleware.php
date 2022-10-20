<?php


namespace mtphp\Application\Tests\Middleware;


use mtphp\Application\Hub;
use mtphp\Application\Tests\FakeClass\AppControllerFake;
use mtphp\Router\Mapping\MtRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ControllerMiddleware
 * @package mtphp\Application\Tests\Middleware
 * @author Sébastien Muler
 */
class ControllerMiddleware extends Hub implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
//        $route = $request->getAttribute(MtRoute::class);
        return (new AppControllerFake())->fake();
    }
}