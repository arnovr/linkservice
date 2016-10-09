<?php
declare(strict_types=1);

namespace LinkService\Application;

use LinkService\Application\Command\UpdateLinkCommand;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;

class UpdateLinkHandler
{
    /**
     * @var TrackableLinkRepository
     */
    private $repository;

    /**
     * @param TrackableLinkRepository $repository
     */
    public function __construct(TrackableLinkRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UpdateLinkCommand $command
     */
    public function update(UpdateLinkCommand $command)
    {
        $trackableLink = $this->repository->getBy($command->trackableLink);

        $this->repository->save(
            TrackableLink::from(
                $trackableLink->referrer(),
                new Link($command->link),
                $trackableLink->clicks()
            )
        );
    }
}
