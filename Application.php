<?php

namespace MulerTech\Application;

use Psr\Container\ContainerInterface;

/**
 * Class Application
 * @package MulerTech\Application
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
    protected function container(): ContainerInterface
    {
        return self::$container;
    }

    /**
     * @return Object|null User object
     */
    protected function getUser(): ?Object
    {
        return self::$user ?? null;
    }

    /**
     * @return bool
     */
    protected function userSet(): bool
    {
        return isset(self::$user);
    }
}
