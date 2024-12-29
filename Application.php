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
    protected static ContainerInterface $container;

    /**
     * @var Object User
     */
    protected static object $user;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container): void
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
    public function getUser(): ?Object
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
