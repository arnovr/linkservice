<?php


namespace LinkService\Application;


use LinkService\Domain\Model\TrackableLinkRepository;

class DeleteLinkHandler
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
     * @param string $trackableLink
     */
    public function delete(string $trackableLink)
    {
        $this->repository->delete(
            $this->repository->getBy($trackableLink)
        );
    }
}