<?php

namespace mtphp\Application;

use Psr\Container\ContainerInterface;

/**
 * Class Application
 * @package mtphp\Application
 * @author Sébastien Muler
 */
abstract class Application
{

    /**
     * @var ContainerInterface
     */
    protected static $container;

    /**
     * @var Object User
     */
    protected static $user;

    /**
     * @param ContainerInterface $container
     */
    protected function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    /**
     * @param Object $user
     */
    protected function setUser(Object $user): void
    {
        self::$user = $user;
    }

    /**
     * @return ContainerInterface
     */
    public function container(): ContainerInterface
    {
        return self::$container;
    }

    /**
     * @return Object|null User object
     */
    public function user(): ?Object
    {
        return self::$user ?? null;
    }

    /**
     * @return bool
     */
    public function userSet(): bool
    {
        return isset(self::$user);
    }
}
