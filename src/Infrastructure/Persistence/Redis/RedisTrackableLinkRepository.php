<?php
declare(strict_types=1);

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
        $link = $this->client->get($trackableLink);

        if (empty($link)) {
            throw TrackableLinkNotFound::fromTrackableLink($trackableLink);
        }

        return TrackableLink::from(
            new Link($trackableLink),
            new Link($link),
            0
        );
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function save(TrackableLink $trackableLink)
    {
        $this->client->set(
            (string) $trackableLink->trackableLink(),
            (string) $trackableLink->link()
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
