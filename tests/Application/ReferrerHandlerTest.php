<?php

namespace Tests\LinkService\Application;

use LinkService\Application\EventBus\EventBus;
use LinkService\Application\ReferrerHandler;
use LinkService\Domain\Model\ClickEvent;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;
use Mockery;

class ReferrerHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**\
     * @var EventBus|\Mockery\Mock
     */
    private $eventBus;

    /**
     * @var ReferrerHandler
     */
    private $referrerHandler;

    /**
     * @var InMemoryTrackableLinkRepository
     */
    private $inMemoryTrackableLinkRepository;

    public function setUp()
    {
        $this->inMemoryTrackableLinkRepository = new InMemoryTrackableLinkRepository(
            [
                TrackableLink::from(
                    new Referrer('some/awesome/path'),
                    new Link('http://www.fulllink.com')
                )
            ]
        );

        $this->eventBus = Mockery::spy(EventBus::class);

        $this->referrerHandler = new ReferrerHandler(
            $this->inMemoryTrackableLinkRepository,
            $this->eventBus
        );
    }
    /**
     * @test
     */
    public function shouldReturnUrl()
    {
        $this->assertSame(
            'http://www.fulllink.com',
            $this->referrerHandler->execute('some/awesome/path')
        );
    }

    /**
     * @test
     */
    public function shouldAddClickEventToEventBus()
    {
        $referrer = "some/awesome/path";

        $this->referrerHandler->execute($referrer);

        $this->eventBus->shouldHaveReceived('handle')->with(Mockery::type(ClickEvent::class));
    }
}
