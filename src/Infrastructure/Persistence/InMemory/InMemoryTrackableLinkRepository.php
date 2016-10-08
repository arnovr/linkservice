<?php

namespace LinkService\Infrastructure\Persistence\InMemory;

use Assert\Assertion;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkNotFound;
use LinkService\Domain\Model\TrackableLinkRepository;

class InMemoryTrackableLinkRepository implements TrackableLinkRepository
{
    /**
     * @var array
     */
    private $trackableLinks;

    /**
     * @param array $trackableLinks
     */
    public function __construct(array $trackableLinks)
    {
        Assertion::allIsInstanceOf($trackableLinks, TrackableLink::class);

        $this->trackableLinks = $trackableLinks;
    }

    /**
     * @param string $trackableLink
     * @throws TrackableLinkNotFound
     * @return TrackableLink
     */
    public function getBy(string $trackableLink): TrackableLink
    {
        $data = array_filter(
            $this->trackableLinks,
            function (TrackableLink $link) use ($trackableLink) {
                return (string) $link->trackableLink() === $trackableLink;
            }
        );

        $returnLink = array_shift($data);
        if (is_null($returnLink)) {
            throw TrackableLinkNotFound::fromTrackableLink($trackableLink);
        }
        return $returnLink;
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function save(TrackableLink $trackableLink)
    {
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function delete(TrackableLink $trackableLink)
    {
    }
}
