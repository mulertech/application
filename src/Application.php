<?php

namespace MulerTech\Application;

use Psr\Container\ContainerInterface;

/**
 * Class Application.
 *
 * @author Sébastien Muler
 */
abstract class Application
{
    protected static ContainerInterface $container;

    /**
     * @var object User
     */
    protected static object $user;

    public function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    protected function setUser(object $user): void
    {
        self::$user = $user;
    }

    protected function container(): ContainerInterface
    {
        return self::$container;
    }

    /**
     * @return object|null User object
     */
    public function getUser(): ?object
    {
        return self::$user ?? null;
    }

    public function userSet(): bool
    {
        return isset(self::$user);
    }
}
