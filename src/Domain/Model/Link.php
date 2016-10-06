<?php

namespace HappyCar\Domain\Model;

use Assert\Assertion;

class Link
{
    /**
     * @var string
     */
    private $url;

    /**
     */
    public function __construct(string $url)
    {
        Assertion::url($url);

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
