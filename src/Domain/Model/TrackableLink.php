<?php
declare(strict_types=1);

namespace LinkService\Domain\Model;

use LinkService\Domain\RecordsEvents;

final class TrackableLink
{
    use RecordsEvents;

    /**
     * @var Referrer
     */
    private $referrer;

    /**
     * @var Link
     */
    private $link;

    /**
     * @param Referrer $referrer
     * @param Link $link
     */
    public function __construct(Referrer $referrer, Link $link)
    {
        $this->referrer = $referrer;
        $this->link = $link;
    }

    /**
     * @param Referrer $referrer
     * @param Link $link
     * @return TrackableLink
     */
    public static function from(Referrer $referrer, Link $link): self
    {
        return new self($referrer, $link);
    }

    /**
     * @return Link
     */
    public function requestLink(): Link
    {
        $this->record(
            new ClickEvent(
                (string) $this->referrer,
                (string) $this->link
            )
        );

        return $this->link;
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
