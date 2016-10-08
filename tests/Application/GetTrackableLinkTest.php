<?php

namespace Tests\LinkService\Application;

use LinkService\Application\ClickRepository;
use LinkService\Application\GetTrackableLinkHandler;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;
use Mockery;

class GetTrackableLinkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClickRepository|\Mockery\Mock
     */
    private $clickRepository;

    /**
     * @var GetTrackableLinkHandler
     */
    private $getTrackableLinkHandler;

    /**
     * @var InMemoryTrackableLinkRepository
     */
    private $inMemoryTrackableLinkRepository;

    public function setUp()
    {
        $this->inMemoryTrackableLinkRepository = new InMemoryTrackableLinkRepository(
            [
                TrackableLink::from(
                    new Link('some/awesome/path'),
                    new Link('http://www.fulllink.com'),
                    0
                )
            ]
        );

        $this->clickRepository = Mockery::spy(ClickRepository::class);

        $this->getTrackableLinkHandler = new GetTrackableLinkHandler(
            $this->inMemoryTrackableLinkRepository,
            $this->clickRepository
        );
    }
    /**
     * @test
     */
    public function shouldReturnUrl()
    {
        $this->assertSame(
            'http://www.fulllink.com',
            $this->getTrackableLinkHandler->execute('some/awesome/path')
        );
    }


    /**
     * @test
     */
    public function shouldIncrementNumberOfClicks()
    {
        $path = "some/awesome/path";

        $this->getTrackableLinkHandler->execute($path);

        $this->clickRepository->shouldHaveReceived('add')->with(Mockery::type(TrackableLink::class));
    }
}
