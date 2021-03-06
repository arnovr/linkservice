<?php


namespace Tests\LinkService\Infrastructure\Api;


use LinkService\Application\Command\CreateLinkCommand;
use LinkService\Application\CreateLinkHandler;
use LinkService\Application\ReferrerExists;
use LinkService\Infrastructure\Api\Controller\CreateLinkController;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CreateLinkControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mockery\Mock
     */
    private $createLinkHandler;

    /**
     * @var CreateLinkController
     */
    private $controller;

    public function setUp()
    {
        $this->createLinkHandler = Mockery::spy(CreateLinkHandler::class);
        $this->controller = new CreateLinkController($this->createLinkHandler);
    }

    /**
     * @test
     */
    public function shouldCreateLink()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->andReturn('{"referrer": "abc123/helloworld/somepath", "link" : "https://www.url.com/document/some/very/long/path"}');

        $response = $this->controller->createAction($request);

        $this->createLinkHandler->shouldHaveReceived('create')->with(
            Mockery::on(function(CreateLinkCommand $command) {
                $this->assertSame('abc123/helloworld/somepath', $command->referrer);
                $this->assertSame('https://www.url.com/document/some/very/long/path', $command->link);
                return true;
            }
            ));

        $this->assertSame(201, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldThrowConflictExceptionWhenKeyExists()
    {
        $this->setExpectedException(ConflictHttpException::class);
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->andReturn('{"referrer": "abc123/helloworld/somepath", "link" : "https://www.url.com/document/some/very/long/path"}');

        $this->createLinkHandler->shouldReceive('create')->andThrow(ReferrerExists::class);

        $this->controller->createAction($request);
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
            ['{"trackableLink": "abc123/helloworld/somepath", "link" : "https://url/document/some/very/long/path"}']
        ];
    }
}