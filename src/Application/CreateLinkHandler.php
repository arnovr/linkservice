<?php
declare(strict_types=1);

namespace LinkService\Application;

use LinkService\Application\Command\CreateLinkCommand;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkRepository;

class CreateLinkHandler
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
     * @param CreateLinkCommand $createLinkCommand
     */
    public function create(CreateLinkCommand $createLinkCommand)
    {
        $trackableLink = TrackableLink::from(
            new Link($createLinkCommand->trackableLink),
            new Link($createLinkCommand->link),
            0
        );

        $this->repository->save($trackableLink);
    }
}
