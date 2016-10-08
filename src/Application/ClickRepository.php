<?php
declare(strict_types=1);

namespace LinkService\Application;

use LinkService\Domain\Model\TrackableLink;

interface ClickRepository
{
    /**
     * @param TrackableLink $trackableLink
     */
    public function add(TrackableLink $trackableLink);
}
