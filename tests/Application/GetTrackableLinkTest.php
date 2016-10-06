<?php

namespace Tests\LinkService\Application;

use LinkService\Application\GetTrackableLinkHandler;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;

class GetTrackableLinkTest extends \PHPUnit_Framework_TestCase
{
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
                    new Link('http://www.google.com/something'),
                    new Link('http://www.fulllink.com'),
                    0
                )
            ]
        );

        $this->getTrackableLinkHandler = new GetTrackableLinkHandler(
            $this->inMemoryTrackableLinkRepository
        );
    }
    /**
     * @test
     */
    public function shouldReturnUrl()
    {
        $this->assertSame(
            'http://www.fulllink.com',
            $this->getTrackableLinkHandler->execute('http://www.google.com/something')
        );
    }
}
