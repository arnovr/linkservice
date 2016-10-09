<?php
declare(strict_types=1);

namespace LinkService\Domain\Model;

final class TrackableLink
{
    /**
     * @var Referrer
     */
    private $referrer;

    /**
     * @var Link
     */
    private $link;

    /**
     * @var int
     */
    private $clicks;

    /**
     * @param Referrer $referrer
     * @param Link $link
     * @param int  $clicks
     */
    public function __construct(Referrer $referrer, Link $link, int $clicks)
    {
        $this->referrer = $referrer;
        $this->link = $link;
        $this->clicks = $clicks;
    }

    /**
     * @param Referrer $referrer
     * @param Link $link
     * @param int  $clicks
     * @return TrackableLink
     */
    public static function from(Referrer $referrer, Link $link, int $clicks): self
    {
        return new self($referrer, $link, $clicks);
    }

    /**
     * @return Link
     */
    public function requestLink(): Link
    {
        $this->clicks++;
        return $this->link;
    }

    /**
     * @return int
     */
    public function clicks(): int
    {
        return $this->clicks;
    }

    /**
     * @return Referrer
     */
    public function referrer(): Referrer
    {
        return $this->referrer;
    }

    /**
     * @return Link
     */
    public function link(): Link
    {
        return $this->link;
    }
}
