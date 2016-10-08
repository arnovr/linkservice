<?php

namespace LinkService\Infrastructure\Persistence\Redis;

use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkNotFound;
use LinkService\Domain\Model\TrackableLinkRepository;
use Predis\ClientInterface;

class RedisTrackableLinkRepository implements TrackableLinkRepository
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $trackableLink
     * @throws TrackableLinkNotFound
     * @return TrackableLink
     */
    public function getBy(string $trackableLink): TrackableLink
    {
        $trackableLinkDto = unserialize(
            $this->client->get($trackableLink)
        );

        if (empty($trackableLinkDto) || !$trackableLinkDto instanceof TrackableLinkDto) {
            throw TrackableLinkNotFound::fromTrackableLink($trackableLink);
        }

        return TrackableLink::from(
            new Link($trackableLink),
            new Link($trackableLinkDto->link),
            $trackableLinkDto->clicks
        );
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function save(TrackableLink $trackableLink)
    {
        $trackableLinkDto = new TrackableLinkDto();
        $trackableLinkDto->link = (string) $trackableLink->link();
        $trackableLinkDto->clicks = $trackableLink->clicks();

        $this->client->set(
            (string) $trackableLink->trackableLink(),
            serialize($trackableLinkDto)
        );
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function delete(TrackableLink $trackableLink)
    {
        $this->client->del(
            (string) $trackableLink->trackableLink()
        );
    }
}
