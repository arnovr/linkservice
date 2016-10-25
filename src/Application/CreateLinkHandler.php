<?php
declare(strict_types=1);

namespace LinkService\Application;

use LinkService\Application\Command\CreateLinkCommand;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Domain\Model\TrackableLinkNotFound;
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
     * @throws ReferrerExists
     */
    public function create(CreateLinkCommand $createLinkCommand)
    {
        try {
            $this->repository->getBy($createLinkCommand->referrer);
            throw ReferrerExists::fromReferrer($createLinkCommand->referrer);
        } catch (TrackableLinkNotFound $e) {
        }

        $trackableLink = TrackableLink::from(
            new Referrer($createLinkCommand->referrer),
            new Link($createLinkCommand->link)
        );

        $this->repository->save($trackableLink);
    }
}
