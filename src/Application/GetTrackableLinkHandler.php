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
     * @var ClickRepository
     */
    private $clickRepository;

    /**
     * @param TrackableLinkRepository $trackableLinkRepository
     * @param ClickRepository $clickRepository
     */
    public function __construct(
        TrackableLinkRepository $trackableLinkRepository,
        ClickRepository $clickRepository
    ) {
        $this->trackableLinkRepository = $trackableLinkRepository;
        $this->clickRepository = $clickRepository;
    }

    /**
     * @param string $url
     * @return string
     */
    public function execute(string $url): string
    {
        $trackableLink = $this->trackableLinkRepository->getBy($url);
        $link = (string) $trackableLink->requestLink();

        $this->clickRepository->add($trackableLink);

        return $link;
    }
}
