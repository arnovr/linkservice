<?php

namespace LinkService\Domain\Model;

interface TrackableLinkRepository
{
    /**
     * @param string $trackableLink
     * @return TrackableLink
     */
    public function getBy(string $trackableLink): TrackableLink;

    /**
     * @param TrackableLink $trackableLink
     */
    public function save(TrackableLink $trackableLink);

    /**
     * @param TrackableLink $trackableLink
     */
    public function delete(TrackableLink $trackableLink);
}
