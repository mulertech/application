<?php


namespace MulerTech\Application\Tests\FakeClass;

use MulerTech\HttpRequest\Response;

class AppControllerFake
{

    public function fake()
    {
        return new Response(404, [], 'Page not found...');
    }
}