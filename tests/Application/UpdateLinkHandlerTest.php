<?php


namespace Tests\LinkService\Application;


use LinkService\Application\Command\UpdateLinkCommand;
use LinkService\Application\UpdateLinkHandler;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;
use Mockery;

class UpdateLinkHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UpdateLinkHandler
     */
    private $handler;

    /**
     * @var TrackableLinkRepository|\Mockery\Mock
     */
    private $repository;

    public function setUp()
    {
        $this->repository = Mockery::spy(TrackableLinkRepository::class);
        $this->handler = new UpdateLinkHandler($this->repository);
    }

    /**
     * @test
     */
    public function shouldUpdateLink()
    {
        $command = new UpdateLinkCommand();

        $command->trackableLink = 'some/awesome/path';
        $command->link = 'http://www.fulllink.com';

        $this->handler->update($command);

        $this->repository->shouldHaveReceived('save')->with(Mockery::type(TrackableLink::class));
    }
}
