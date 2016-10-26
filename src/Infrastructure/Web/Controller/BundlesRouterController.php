<?php

namespace LinkService\Infrastructure\Web\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BundlesRouterController
{
    private $rootDir;

    /**
     * @param $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @param $url
     * @return Response|NotFoundHttpException
     */
    public function route($url)
    {
        $bundleFile = $this->rootDir . '/../web/bundles/' . $url;
        if (file_exists($bundleFile)) {
            $parts = explode('.', basename($bundleFile));
            $ext = strtolower(array_pop($parts));
            switch ($ext) {
                case "css":
                    return new Response(
                        file_get_contents($bundleFile),
                        200,
                        ['Content-Type' => 'text/css']
                    );
                    break;
                case "js":
                    return new Response(
                        file_get_contents($bundleFile),
                        200,
                        ['Content-Type' => 'text/javascript']
                    );
                    break;
            }

            return new Response(
                file_get_contents($bundleFile)
            );
        }
        return new NotFoundHttpException($url);
    }
}
