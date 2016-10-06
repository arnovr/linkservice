<?php

namespace HappyCar\Infrastructure\Api\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectController
{
    /**
     */
    public function __construct()
    {
    }

    public function redirectAction(string $url)
    {
        return new RedirectResponse('https://www.happycar.de/info/versicherung/document/some/very/long/path');
    }
}
