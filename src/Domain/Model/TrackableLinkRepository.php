<?php
declare(strict_types=1);

namespace LinkService\Domain\Model;

interface TrackableLinkRepository
{
    /**
     * @param string $referrer
     * @throws TrackableLinkNotFound
     * @return TrackableLink
     */
    public function getBy(string $referrer): TrackableLink;

    /**
     * @param TrackableLink $trackableLink
     */
    public function save(TrackableLink $trackableLink);

    /**
     * @param TrackableLink $trackableLink
     */
    public function delete(TrackableLink $trackableLink);
}
