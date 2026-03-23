<?php

namespace MulerTech\Application;

use MulerTech\Container\Container;
use MulerTech\Container\Loader;
use MulerTech\FileManipulation\FileType\Env;
use MulerTech\FileManipulation\PathManipulation;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class Hub.
 *
 * @author Sébastien Muler
 */
class Hub extends Application
{
    private const string FILE_INTO_PROJECT_PATH = 'composer.json';
    private const string PROJECT_PATH_PARAMETER = 'hub.project_path';

    /**
     * Hub constructor.
     *
     * @param array<int, class-string> $middlewares
     */
    public function __construct(private array $middlewares = [])
    {
    }

    /**
     * Load the first middleware.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $requestHandler = $this->container()->get(RequestHandlerInterface::class);

        if (!$requestHandler instanceof RequestHandler) {
            throw new \RuntimeException('The RequestHandlerInterface must be an instance of RequestHandler.');
        }

        if (empty($this->middlewares)) {
            throw new \RuntimeException('The middleware list was not given into the Hub construct, it\'s necessary.');
        }

        foreach ($this->middlewares as $middleware) {
            $requestHandler->pipe($middleware);
        }

        return $requestHandler->handle($request);
    }

    public static function loadEnv(string $filename): void
    {
        $envFile = new Env($filename);
        $envFile->loadEnv();
    }

    /**
     * Load the config parameters of the $configPath path (recursively) into the container.
     */
    public static function loadConfig(Container $container, string $configPath): void
    {
        // Set the project path into the container
        $container->setParameter(self::PROJECT_PATH_PARAMETER, self::projectPath());

        $loader = new Loader();
        $loader
            ->setFileList(PathManipulation::fileList($configPath))
            ->setLoader(Loader\YamlLoader::class)
            ->loadParameters($container);

        parent::$container = $container;
    }

    public static function projectPath(): string
    {
        /** @var string $path */
        $path = $_SERVER['SCRIPT_FILENAME'];
        $noLoop = 0;

        while (!file_exists($path.DIRECTORY_SEPARATOR.self::FILE_INTO_PROJECT_PATH)) {
            $path = dirname($path);
            ++$noLoop;

            if (10 === $noLoop) {
                throw new \RuntimeException(sprintf('Class : Hub, function : projectPath. Unable to find the project path, verify that the file "%s" exits into the project path...', self::FILE_INTO_PROJECT_PATH));
            }
        }

        return $path;
    }
}
