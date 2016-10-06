<?php

namespace LinkService\Domain\Model;

final class Link
{
    /**
     * @var string
     */
    private $url;

    /**
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->url;
    }
}
