<?php


namespace Tests\LinkService\Infrastructure\Api;


use LinkService\Application\DeleteLinkHandler;
use LinkService\Infrastructure\Api\Controller\DeleteLinkController;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteLinkControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mockery\Mock|DeleteLinkHandler
     */
    private $deleteLinkHandler;

    /**
     * @var DeleteLinkController
     */
    private $controller;

    public function setUp()
    {
        $this->deleteLinkHandler = Mockery::spy(DeleteLinkHandler::class);
        $this->controller = new DeleteLinkController($this->deleteLinkHandler);
    }

    /**
     * @test
     */
    public function shouldDeleteLink()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->andReturn('{"trackableLink": "abc123/helloworld/somepath"}');
        $response = $this->controller->deleteAction($request);

        $this->deleteLinkHandler->shouldHaveReceived('delete')->with('abc123/helloworld/somepath');

        $this->assertSame(204, $response->getStatusCode());
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
        $this->controller->deleteAction($request);
    }

    /**
     * @return array
     */
    public function invalidRequestContent()
    {
        return [
            ['{}'],
            ['{"link" : "https://www.url.com/document/some/very/long/path"}'],
        ];
    }
}