<?php
declare(strict_types=1);

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
    public function __toString(): string
    {
        return $this->url;
    }
}
