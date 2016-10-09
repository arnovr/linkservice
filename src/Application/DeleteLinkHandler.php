<?php
declare(strict_types=1);

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
     * @param string $referrer
     */
    public function delete(string $referrer)
    {
        $this->repository->delete(
            $this->repository->getBy($referrer)
        );
    }
}
