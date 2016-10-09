<?php
declare(strict_types=1);

namespace LinkService\Application;

use LinkService\Domain\Model\TrackableLinkRepository;

class ReferrerHandler
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
     * @param string $referrer
     * @return string
     */
    public function execute(string $referrer): string
    {
        $trackableLink = $this->trackableLinkRepository->getBy($referrer);
        $link = (string) $trackableLink->requestLink();

        $this->clickRepository->add($trackableLink);

        return $link;
    }
}
