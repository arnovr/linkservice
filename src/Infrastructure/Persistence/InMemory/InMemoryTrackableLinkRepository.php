<?php
declare(strict_types=1);

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
     * @param string $referrer
     * @throws TrackableLinkNotFound
     * @return TrackableLink
     */
    public function getBy(string $referrer): TrackableLink
    {
        $data = array_filter(
            $this->trackableLinks,
            function (TrackableLink $link) use ($referrer) {
                return (string) $link->referrer() === $referrer;
            }
        );

        $returnLink = array_shift($data);
        if (is_null($returnLink)) {
            throw TrackableLinkNotFound::fromTrackableLink($referrer);
        }
        return clone $returnLink;
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function save(TrackableLink $trackableLink)
    {
        $this->trackableLinks = array_filter(
            $this->trackableLinks,
            function (TrackableLink $link) use ($trackableLink) {
                return (string) $link->referrer() !== (string) $trackableLink->referrer();
            }
        );

        array_push($this->trackableLinks, $trackableLink);
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function delete(TrackableLink $trackableLink)
    {
    }
}
