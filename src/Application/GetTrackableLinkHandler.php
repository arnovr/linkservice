<?php

namespace LinkService\Application;

use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLinkRepository;

class GetTrackableLinkHandler
{
    /**
     * @var TrackableLinkRepository
     */
    private $trackableLinkRepository;

    /**
     * @param TrackableLinkRepository $trackableLinkRepository
     */
    public function __construct(TrackableLinkRepository $trackableLinkRepository)
    {
        $this->trackableLinkRepository = $trackableLinkRepository;
    }

    public function execute(string $url)
    {
        $trackableLink = $this->trackableLinkRepository->getBy($url);
        return (string) $trackableLink->requestLink();
    }
}
