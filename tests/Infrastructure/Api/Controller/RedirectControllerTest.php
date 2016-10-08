<?php


namespace Tests\LinkService\Infrastructure\Api;


use LinkService\Application\GetTrackableLinkHandler;
use LinkService\Infrastructure\Api\Controller\RedirectController;
use Mockery;

class RedirectControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mockery\Mock|GetTrackableLinkHandler
     */
    private $getTrackableLinkHandler;

    /**
     * @var RedirectController
     */
    private $controller;

    public function setUp()
    {
        $this->getTrackableLinkHandler = Mockery::spy(GetTrackableLinkHandler::class);
        $this->controller = new RedirectController($this->getTrackableLinkHandler);
    }

    /**
     * @test
     */
    public function shouldRedirect()
    {
        $path = "abc123/helloworld/somepath";

        $this->getTrackableLinkHandler->shouldReceive('execute')->with($path)->andReturn('someurl')->once();

        $response = $this->controller->redirectAction($path);

        $this->assertSame(302, $response->getStatusCode());
    }
}