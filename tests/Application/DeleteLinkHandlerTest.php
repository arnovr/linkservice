<?php


namespace Tests\LinkService\Application;


use LinkService\Application\DeleteLinkHandler;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;
use Mockery;

class DeleteLinkHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeleteLinkHandler
     */
    private $handler;

    /**
     * @var TrackableLinkRepository|\Mockery\Mock
     */
    private $repository;

    public function setUp()
    {
        $this->repository = Mockery::spy(TrackableLinkRepository::class);
        $this->handler = new DeleteLinkHandler($this->repository);
    }

    /**
     * @test
     */
    public function shouldDeleteLink()
    {
        $referrer = 'some/awesome/path';
        $this->repository->shouldReceive('getBy')->with($referrer)->andReturn(
            TrackableLink::from(
                new Referrer('some/awesome/path'),
                new Link('http://www.fulllink.com')
            )
        );

        $this->handler->delete($referrer);

        $this->repository->shouldHaveReceived('delete')->with(Mockery::type(TrackableLink::class));
    }
}
