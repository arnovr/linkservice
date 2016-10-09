<?php
declare(strict_types=1);

namespace LinkService\Application;

use Exception;
use Throwable;

class ReferrerExists extends Exception implements Throwable
{
    /**
     * @param string $referrer
     * @return ReferrerExists
     */
    public static function fromReferrer(string $referrer): ReferrerExists
    {
        return new self("Referrer already exists with name: " . $referrer);
    }
}
