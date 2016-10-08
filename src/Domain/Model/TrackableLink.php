<?php

namespace LinkService\Domain\Model;

final class TrackableLink
{
    /**
     * @var Link
     */
    private $trackableLink;

    /**
     * @var Link
     */
    private $link;

    /**
     * @var int
     */
    private $clicks;

    /**
     * @param Link $trackableLink
     * @param Link $link
     * @param int  $clicks
     */
    public function __construct(Link $trackableLink, Link $link, int $clicks)
    {
        $this->trackableLink = $trackableLink;
        $this->link = $link;
        $this->clicks = $clicks;
    }

    /**
     * @param Link $trackableLink
     * @param Link $link
     * @param int  $clicks
     * @return TrackableLink
     */
    public static function from(Link $trackableLink, Link $link, int $clicks): self
    {
        return new self($trackableLink, $link, $clicks);
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
     * @return Link
     */
    public function trackableLink(): Link
    {
        return $this->trackableLink;
    }

    /**
     * @return Link
     */
    public function link(): Link
    {
        return $this->link;
    }
}
