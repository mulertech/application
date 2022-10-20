<?php


namespace mtphp\Application\Tests\Middleware;


use mtphp\Application\Hub;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ControllerMiddleware
 * @package mtphp\Application\Tests\Middleware
 * @author Sébastien Muler
 */
class NotInterceptRequestMiddleware extends Hub implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //Not intercept this request
        return $handler->handle($request);
    }
}