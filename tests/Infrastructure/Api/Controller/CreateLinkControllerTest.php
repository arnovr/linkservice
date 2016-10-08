<?php


namespace Tests\LinkService\Infrastructure\Api;


use LinkService\Infrastructure\Api\Controller\CreateLinkController;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateLinkControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateLinkController
     */
    private $controller;

    public function setUp()
    {
        $this->controller = new CreateLinkController();
    }

    /**
     * @test
     */
    public function shouldCreateLink()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->andReturn('{"trackableLink": "abc123/helloworld/somepath", "link" : "https://www.url.com/document/some/very/long/path"}');
        $response = $this->controller->createAction($request);

        $this->assertSame(201, $response->getStatusCode());
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
        $this->controller->createAction($request);
    }

    /**
     * @return array
     */
    public function invalidRequestContent()
    {
        return [
            ['{}'],
            ['{"link" : "https://www.url.com/document/some/very/long/path"}'],
            ['{"trackableLink": "abc123/helloworld/somepath"}'],
            ['{"trackableLink": "abc123/helloworld/somepath", "link" : "https://www.url/document/some/very/long/path"}']
        ];
    }
}