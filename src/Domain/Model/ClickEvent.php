<?php
declare(strict_types=1);

namespace LinkService\Domain\Model;

class ClickEvent
{
    /**
     * @var string
     */
    public $referrer;

    /**
     * @var string
     */
    public $link;

    /**
     * @param string $referrer
     * @param string $link
     */
    public function __construct(string $referrer, string $link)
    {
        $this->referrer = $referrer;
        $this->link = $link;
    }
}
