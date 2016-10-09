<?php


namespace Tests\LinkService\Application;


use LinkService\Application\Command\CreateLinkCommand;
use LinkService\Application\CreateLinkHandler;
use LinkService\Application\ReferrerExists;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkNotFound;
use LinkService\Domain\Model\TrackableLinkRepository;
use Mockery;

class CreateLinkHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateLinkHandler
     */
    private $handler;

    /**
     * @var TrackableLinkRepository|\Mockery\Mock
     */
    private $repository;

    public function setUp()
    {
        $this->repository = Mockery::spy(TrackableLinkRepository::class);
        $this->handler = new CreateLinkHandler($this->repository);
    }

    /**
     * @test
     */
    public function shouldCreateLink()
    {
        $this->repository->shouldReceive('getBy')->andThrow(TrackableLinkNotFound::class);

        $command = new CreateLinkCommand();

        $command->referrer = 'some/awesome/path';
        $command->link = 'http://www.fulllink.com';

        $this->handler->create($command);

        $this->repository->shouldHaveReceived('save')->with(Mockery::type(TrackableLink::class));
    }

    /**
     * @test
     */
    public function shouldThrowReferrerExistsWhenTrackableLinkExistsInRepository()
    {
        $this->setExpectedException(ReferrerExists::class);

        $this->repository->shouldReceive('getBy')->andReturn(
            TrackableLink::from(
                new Referrer('some/awesome/path'),
                new Link('http://www.fulllink.com'),
                0
            )
        );

        $command = new CreateLinkCommand();

        $command->referrer = 'some/awesome/path';
        $command->link = 'http://www.fulllink.com';

        $this->handler->create($command);

        $this->repository->shouldHaveReceived('save')->with(Mockery::type(TrackableLink::class));
    }
}
