<?php


namespace Tests\LinkService\Application;


use LinkService\Application\Command\UpdateLinkCommand;
use LinkService\Application\UpdateLinkHandler;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
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
        $this->repository->shouldReceive('getBy')->with('some/awesome/path')->andReturn(
            TrackableLink::from(
                new Referrer('some/awesome/path'),
                new Link('http://www.fulllink.com')
            )
        );

        $command = new UpdateLinkCommand();

        $command->referrer = 'some/awesome/path';
        $command->link = 'http://www.thisismynewlink.com';

        $this->handler->update($command);

        $this->repository->shouldHaveReceived('save')->with(Mockery::on(
            function (TrackableLink $trackableLink) {
                $this->assertSame('http://www.thisismynewlink.com', (string) $trackableLink->link());
                return true;
            }
        ));
    }
}
