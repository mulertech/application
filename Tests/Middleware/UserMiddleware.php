<?php


namespace mtphp\Application\Tests\Middleware;


use mtphp\Application\Hub;
use mtphp\Application\Tests\FakeClass\AppControllerFake;
use mtphp\Application\Tests\FakeClass\FakeUser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ControllerMiddleware
 * @package mtphp\Application\Tests\Middleware
 * @author Sébastien Muler
 */
class UserMiddleware extends Hub implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setUser(new FakeUser());
        return (new AppControllerFake())->fake();
    }
}