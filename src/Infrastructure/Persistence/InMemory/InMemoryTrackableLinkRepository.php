<?php
namespace LinkService\Infrastructure\Persistence\InMemory;

use Assert\Assertion;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;

class InMemoryTrackableLinkRepository implements TrackableLinkRepository
{
    /**
     * @var array
     */
    private $trackableLinks;

    public function __construct(array $trackableLinks)
    {
        Assertion::allIsInstanceOf($trackableLinks, TrackableLink::class);

        $this->trackableLinks = $trackableLinks;
    }

    public function getBy(string $trackableLink): TrackableLink
    {
        $data = array_filter(
            $this->trackableLinks,
            function (TrackableLink $link) use ($trackableLink) {
                return (string) $link->trackableLink() === $trackableLink;
            }
        );

        return array_shift($data);
    }

    /**
     * @param TrackableLink $trackableLink
     */
    public function save(TrackableLink $trackableLink)
    {
        // TODO: Implement save() method.
    }
}
