<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Persistence\Redis;

class TrackableLinkDto
{
    /**
     * @var string
     */
    public $link;
    /**
     * @var int
     */
    public $clicks;
}
