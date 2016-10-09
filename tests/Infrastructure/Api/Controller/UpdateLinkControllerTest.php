<?php


namespace Tests\LinkService\Infrastructure\Api;


use LinkService\Application\Command\UpdateLinkCommand;
use LinkService\Application\UpdateLinkHandler;
use LinkService\Domain\Model\TrackableLinkNotFound;
use LinkService\Infrastructure\Api\Controller\UpdateLinkController;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateLinkControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Mockery\Mock
     */
    private $updateLinkHandler;

    /**
     * @var UpdateLinkController
     */
    private $controller;

    public function setUp()
    {
        $this->updateLinkHandler = Mockery::spy(UpdateLinkHandler::class);
        $this->controller = new UpdateLinkController($this->updateLinkHandler);
    }

    /**
     * @test
     */
    public function shouldUpdateLink()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->andReturn('{"referrer": "abc123/helloworld/somepath", "link" : "https://www.url.com/document/some/very/long/path"}');
        $response = $this->controller->updateAction($request);

        $this->updateLinkHandler->shouldHaveReceived('update')->with(
            Mockery::on(function(UpdateLinkCommand $command) {
                $this->assertSame('abc123/helloworld/somepath', $command->referrer);
                $this->assertSame('https://www.url.com/document/some/very/long/path', $command->link);
                return true;
            }
            ));

        $this->assertSame(204, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenTrackableLinkCouldNotBeFound()
    {
        $this->setExpectedException(NotFoundHttpException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->andReturn('{"referrer": "abc123/helloworld/notexistent", "link" : "https://www.url.com/document/some/very/long/path"}');
        $this->updateLinkHandler->shouldReceive('update')->andThrow(TrackableLinkNotFound::class);

        $this->controller->updateAction($request);
    }

    /**
     * @test
     * @dataProvider invalidRequestContent
     */
    public function shouldThrowExceptionWhenInvalidPayloadIsSupplied($requestContent)
    {

        $this->setExpectedException(BadRequestHttpException::class);
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->andReturn($requestContent);
        $this->controller->updateAction($request);
    }

    /**
     * @return array
     */
    public function invalidRequestContent()
    {
        return [
            ['{}'],
            ['{"link" : "https://www.url.com/document/some/very/long/path"}'],
            ['{"referrer": "abc123/helloworld/somepath"}'],
            ['{"referrer": "abc123/helloworld/somepath", "link" : "https://url/document/some/very/long/path"}']
        ];
    }
}