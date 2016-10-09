<?php

namespace Tests\LinkService\Application;

use LinkService\Application\ClickRepository;
use LinkService\Application\ReferrerHandler;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;
use Mockery;

class ReferrerHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClickRepository|\Mockery\Mock
     */
    private $clickRepository;

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
                    new Link('http://www.fulllink.com'),
                    0
                )
            ]
        );

        $this->clickRepository = Mockery::spy(ClickRepository::class);

        $this->referrerHandler = new ReferrerHandler(
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
            $this->referrerHandler->execute('some/awesome/path')
        );
    }


    /**
     * @test
     */
    public function shouldIncrementNumberOfClicks()
    {
        $referrer = "some/awesome/path";

        $this->referrerHandler->execute($referrer);

        $this->clickRepository->shouldHaveReceived('add')->with(Mockery::type(TrackableLink::class));
    }
}
