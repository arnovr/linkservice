<?php
declare(strict_types=1);

namespace LinkService\Domain\Model;

final class Referrer
{
    /**
     * @var string
     */
    private $referrer;

    /**
     * @param string $referrer
     */
    public function __construct(string $referrer)
    {
        $this->referrer = $referrer;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->referrer;
    }
}
