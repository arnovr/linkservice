<?php


namespace Tests\LinkService\Infrastructure\Api;


use LinkService\Application\ReferrerHandler;
use LinkService\Infrastructure\Api\Controller\RedirectController;
use Mockery;

class RedirectControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mockery\Mock|ReferrerHandler
     */
    private $referrerHandler;

    /**
     * @var RedirectController
     */
    private $controller;

    public function setUp()
    {
        $this->referrerHandler = Mockery::spy(ReferrerHandler::class);
        $this->controller = new RedirectController($this->referrerHandler);
    }

    /**
     * @test
     */
    public function shouldRedirect()
    {
        $path = "abc123/helloworld/somepath";

        $this->referrerHandler->shouldReceive('execute')->with($path)->andReturn('someurl')->once();

        $response = $this->controller->redirectAction($path);

        $this->assertSame(302, $response->getStatusCode());
    }
}