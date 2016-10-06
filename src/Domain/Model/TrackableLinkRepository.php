<?php

namespace LinkService\Domain\Model;

interface TrackableLinkRepository
{
    public function getBy(Link $link): TrackableLink;
}
