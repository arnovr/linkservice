<?php
declare(strict_types=1);

namespace LinkService\Application;

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

    /**
     * @param string $url
     * @return string
     */
    public function execute(string $url): string
    {
        $trackableLink = $this->trackableLinkRepository->getBy($url);
        return (string) $trackableLink->requestLink();
    }
}
