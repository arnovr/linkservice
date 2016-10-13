<?php


namespace Tests\LinkService\Infrastructure\Persistence\Redis;


use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkNotFound;
use LinkService\Infrastructure\Persistence\Redis\RedisTrackableLinkRepository;
use Mockery;
use Predis\ClientInterface;

class RedisTrackableLinkRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface|\Mockery\Mock
     */
    private $client;

    /**
     * @var RedisTrackableLinkRepository
     */
    private $repository;

    public function setUp()
    {
        $this->client = Mockery::spy(ClientInterface::class);
        $this->repository = new RedisTrackableLinkRepository($this->client);
    }

    /**
     * @test
     */
    public function shouldSaveTrackableLinkToRedis() {
        $this->client->shouldReceive('expire');
        $trackableLink = TrackableLink::from(
            new Referrer('some/awesome/path'),
            new Link('http://www.fulllink.com'),
            120
        );

        $this->repository->save(
            $trackableLink
        );

        $this->client->shouldHaveReceived('set')->with('some/awesome/path', 'http://www.fulllink.com')->once();
    }

    /**
     * @test
     */
    public function shouldSaveTrackableLinkAndSetExpirationToAWeek()
    {
        $trackableLink = TrackableLink::from(
            new Referrer('some/awesome/path'),
            new Link('http://www.fulllink.com'),
            120
        );

        $this->repository->save(
            $trackableLink
        );


        $this->client->shouldHaveReceived('set')->with('some/awesome/path', 'http://www.fulllink.com')->once();
        $this->client->shouldHaveReceived('expire')->with('some/awesome/path', 604800);
    }

    /**
     * @test
     */
    public function shouldDeleteTrackableLink() {

        $trackableLink = TrackableLink::from(
            new Referrer('some/awesome/path'),
            new Link('http://www.fulllink.com'),
            120
        );

        $this->client->shouldReceive('del')->with('some/awesome/path')->once();

        $this->repository->delete(
            $trackableLink
        );
    }

    /**
     * @test
     */
    public function shouldGetTrackableLink() {

        $trackableLink = TrackableLink::from(
            new Referrer('some/awesome/path'),
            new Link('http://www.fulllink.com'),
            0
        );

        $this->client->shouldReceive('get')->with('some/awesome/path')->andReturn('http://www.fulllink.com')->once();

        $this->assertEquals(
            $trackableLink,
            $this->repository->getBy(
                'some/awesome/path'
            )
        );
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenTrackableLinkIsNotFound() {

        $this->setExpectedException(TrackableLinkNotFound::class);

        $this->client->shouldReceive('get')->with('some/awesome/path')->andReturn("")->once();

        $this->repository->getBy(
            'some/awesome/path'
        );
    }
}
