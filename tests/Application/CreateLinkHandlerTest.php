<?php


namespace Tests\LinkService\Application;


use LinkService\Application\Command\CreateLinkCommand;
use LinkService\Application\CreateLinkHandler;
use LinkService\Domain\Model\TrackableLink;
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
        $command = new CreateLinkCommand();

        $command->trackableLink = 'some/awesome/path';
        $command->link = 'http://www.fulllink.com';

        $this->handler->create($command);

        $this->repository->shouldHaveReceived('save')->with(Mockery::type(TrackableLink::class));
    }
}
