<?php
namespace LinkService\Infrastructure\Persistence\InMemory;

use Assert\Assertion;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;

class InMemoryTrackableLinkRepository implements TrackableLinkRepository
{
    /**
     * @var array
     */
    private $trackableLinks;

    /**
     */
    public function __construct(array $trackableLinks)
    {
        Assertion::allIsInstanceOf($trackableLinks, TrackableLink::class);

        $this->trackableLinks = $trackableLinks;
    }

    public function getBy(Link $link): TrackableLink
    {
        return array_filter(
            $this->trackableLinks,
            function (TrackableLink $trackableLink) use ($link){
                if ( $trackableLink->link() == $link) {
                    return $link;
                }
            }
        );
    }
}