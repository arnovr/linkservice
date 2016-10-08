<?php


namespace Tests\LinkService\Infrastructure\Persistence\Redis;


use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkNotFound;
use LinkService\Infrastructure\Persistence\Redis\RedisTrackableLinkRepository;
use LinkService\Infrastructure\Persistence\Redis\TrackableLinkDto;
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
        $this->client = Mockery::mock(ClientInterface::class);
        $this->repository = new RedisTrackableLinkRepository($this->client);
    }

    /**
     * @test
     */
    public function shouldSaveTrackableLinkToRedis() {

        $trackableLink = TrackableLink::from(
            new Link('some/awesome/path'),
            new Link('http://www.fulllink.com'),
            120
        );

        $this->client->shouldReceive('set')->with(
            'some/awesome/path',
            Mockery::on(
                function(string $trackableLinkDto) {
                    $trackableLinkDto = unserialize($trackableLinkDto);
                    $this->assertInstanceOf(TrackableLinkDto::class, $trackableLinkDto);
                    $this->assertSame('http://www.fulllink.com', $trackableLinkDto->link);
                    $this->assertSame(120, $trackableLinkDto->clicks);
                    return true;
                }
            )
        )->once();

        $this->repository->save(
            $trackableLink
        );
    }

    /**
     * @test
     */
    public function shouldDeleteTrackableLink() {

        $trackableLink = TrackableLink::from(
            new Link('some/awesome/path'),
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
            new Link('some/awesome/path'),
            new Link('http://www.fulllink.com'),
            120
        );

        $trackableLinkDto = new TrackableLinkDto();
        $trackableLinkDto->link = 'http://www.fulllink.com';
        $trackableLinkDto->clicks = 120;
        $this->client->shouldReceive('get')->with('some/awesome/path')->andReturn(serialize($trackableLinkDto))->once();

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