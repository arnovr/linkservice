<?php
declare(strict_types=1);

namespace LinkService\Application;

use LinkService\Application\EventBus\EventBus;
use LinkService\Domain\Model\TrackableLinkRepository;

class ReferrerHandler
{
    /**
     * @var TrackableLinkRepository
     */
    private $trackableLinkRepository;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @param TrackableLinkRepository $trackableLinkRepository
     * @param EventBus                $eventBus
     */
    public function __construct(
        TrackableLinkRepository $trackableLinkRepository,
        EventBus $eventBus
    ) {
        $this->trackableLinkRepository = $trackableLinkRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param string $referrer
     * @return string
     */
    public function execute(string $referrer): string
    {
        $trackableLink = $this->trackableLinkRepository->getBy($referrer);
        $link = (string) $trackableLink->requestLink();

        foreach ($trackableLink->getEvents() as $event) {
            $this->eventBus->handle($event);
        }

        return $link;
    }
}
