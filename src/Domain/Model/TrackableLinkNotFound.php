<?php
declare(strict_types=1);

namespace LinkService\Domain\Model;

use Exception;
use Throwable;

class TrackableLinkNotFound extends Exception implements Throwable
{
    /**
     * @param string $trackableLink
     * @return TrackableLinkNotFound
     */
    public static function fromTrackableLink(string $trackableLink): TrackableLinkNotFound
    {
        return new self('Could not find trackable link ' . $trackableLink);
    }
}
