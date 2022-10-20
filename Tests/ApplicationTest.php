<?php

namespace mtphp\Application\Tests;

use GuzzleHttp\Psr7\ServerRequest;
use mtphp\Application\Hub;
use mtphp\Application\RequestHandler;
use mtphp\Application\Tests\FakeClass\FakeUser;
use mtphp\Application\Tests\Middleware\ControllerMiddleware;
use mtphp\Application\Tests\Middleware\NotInterceptRequestMiddleware;
use mtphp\Application\Tests\Middleware\SwitchToOtherMiddleware;
use mtphp\Application\Tests\Middleware\UserMiddleware;
use mtphp\Container\Container;
use mtphp\Container\Definition;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

class ApplicationTest extends TestCase
{

    public function testApplication(): void
    {
        $app = new Hub([ControllerMiddleware::class]);
        $app->setContainer(new Container([new Definition(RequestHandlerInterface::class, RequestHandler::class)]));
        $return = $app->run(ServerRequest::fromGlobals());
        self::assertEquals('Cette page n\'existe pas...', $return->getBody()->getContents());
    }

    public function testApplicationWithoutMiddlewareList(): void
    {
        $app = new Hub();
        $app->setContainer(new Container([new Definition(RequestHandlerInterface::class, RequestHandler::class)]));
        $this->expectExceptionMessage('The middleware list was not given into the Hub construct, it\'s necessary.');
        $app->run(ServerRequest::fromGlobals());
    }

    public function testApplicationWithMiddlewareNotInterceptRequest(): void
    {
        $app = new Hub([NotInterceptRequestMiddleware::class]);
        $app->setContainer(new Container([new Definition(RequestHandlerInterface::class, RequestHandler::class)]));
        $this->expectExceptionMessage('No middleware was intercept this request...');
        $app->run(ServerRequest::fromGlobals());
    }

    public function testApplicationSwitchMiddlewareToMiddlewareNotInterceptRequest(): void
    {
        $app = new Hub([SwitchToOtherMiddleware::class, NotInterceptRequestMiddleware::class]);
        $app->setContainer(new Container([new Definition(RequestHandlerInterface::class, RequestHandler::class)]));
        $this->expectExceptionMessage('No middleware was intercept this request...');
        $app->run(ServerRequest::fromGlobals());
    }

    public function testApplicationUsers(): void
    {
        $app = new Hub([UserMiddleware::class]);
        $app->setContainer(new Container([new Definition(RequestHandlerInterface::class, RequestHandler::class)]));
        $app->run(ServerRequest::fromGlobals());
        self::assertTrue($app->userSet());
        self::assertInstanceOf(FakeUser::class, $app->user());
    }

    public function testLoadEnv()
    {
        Hub::loadEnv(__DIR__ . DIRECTORY_SEPARATOR . 'FakeClass' . DIRECTORY_SEPARATOR . 'test.env');
        self::assertEquals('mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7', getenv('key1'));
    }

    public function testLoadConfig()
    {
        $container = new Container();
        Hub::loadConfig($container, __DIR__ . DIRECTORY_SEPARATOR . 'FakeClass');
        self::assertEquals('valueone', $container->getParameter('config2.anotherone'));
    }
}