<?php

namespace MulerTech\Application;

use mtphp\Container\Loader;
use mtphp\Database\NonRelational\DocumentStore\FileType\Env;
use mtphp\Database\NonRelational\DocumentStore\PathManipulation;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

/**
 * Class Hub
 * @package MulerTech\Application
 * @author Sébastien Muler
 */
class Hub extends Application
{

    private const FILE_INTO_PROJECT_PATH = 'composer.json';
    private const PROJECT_PATH_PARAMETER = 'hub.project_path';

    /**
     * @var array
     */
    private $middlewares;

    /**
     * Hub constructor.
     * @param array $middlewares
     */
    public function __construct(array $middlewares = [])
    {
        $this->middlewares = $middlewares;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container): void
    {
        parent::setContainer($container);
    }

    /**
     * Load the first middleware.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $requestHandler = $this->container()->get(RequestHandlerInterface::class);
        if (empty($this->middlewares)) {
            throw new RuntimeException('The middleware list was not given into the Hub construct, it\'s necessary.');
        }
        foreach ($this->middlewares as $middleware) {
            $requestHandler->pipe($middleware);
        }
        return $requestHandler->handle($request);
    }

    /**
     * @param string $filename
     */
    public static function loadEnv(string $filename): void
    {
        Env::loadEnv($filename);
    }

    /**
     * Load the config parameters of the $configPath path (recursively).
     * @param ContainerInterface $container
     * @param string $configPath
     */
    public static function loadConfig(ContainerInterface $container, string $configPath): void
    {
        //Set the project path into the container
        $container->setParameter(self::PROJECT_PATH_PARAMETER, self::projectPath());
        $loader = new Loader();
        $loader
            ->setFileList(PathManipulation::fileList($configPath))
            ->setLoader(Loader\YamlLoader::class)
            ->loadParameters($container);
    }

    /**
     * @return string
     */
    public static function projectPath(): string
    {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $noLoop = 0;
        while (!file_exists($path . DIRECTORY_SEPARATOR . self::FILE_INTO_PROJECT_PATH)) {
            $path = dirname($path);
            $noLoop++;
            if ($noLoop === 10) {
                throw new RuntimeException(
                    sprintf(
                        'Class : Hub, function : projectPath. Unable to find the project path, verify that the file "%s" exits into the project path...',
                        self::FILE_INTO_PROJECT_PATH
                    )
                );
            }
        }
        return $path;
    }

}