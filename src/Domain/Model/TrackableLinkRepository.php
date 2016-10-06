<?php

namespace LinkService\Domain\Model;

interface TrackableLinkRepository
{
    public function getBy(string $link): TrackableLink;
}
