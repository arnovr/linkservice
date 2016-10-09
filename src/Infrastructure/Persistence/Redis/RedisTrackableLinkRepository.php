<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Persistence\Redis;

use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
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
     * @param string $referrer
     * @throws TrackableLinkNotFound
     * @return TrackableLink
     */
    public function getBy(string $referrer): TrackableLink
    {
        $link = $this->client->get($referrer);

        if (empty($link)) {
            throw TrackableLinkNotFound::fromTrackableLink($referrer);
        }

        return TrackableLink::from(
            new Referrer($referrer),
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
            (string) $trackableLink->referrer(),
            (string) $trackableLink->link()
        );
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function delete(TrackableLink $trackableLink)
    {
        $this->client->del(
            (string) $trackableLink->referrer()
        );
    }
}
