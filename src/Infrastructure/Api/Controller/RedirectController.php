<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Api\Controller;

use LinkService\Application\ReferrerHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectController
{
    /**
     * @var ReferrerHandler
     */
    private $referrerHandler;

    /**
     * @param ReferrerHandler $referrerHandler
     */
    public function __construct(ReferrerHandler $referrerHandler)
    {
        $this->referrerHandler = $referrerHandler;
    }

    /**
     * @param string $url
     * @return RedirectResponse
     */
    public function redirectAction(string $url): RedirectResponse
    {
        return new RedirectResponse(
            $this->referrerHandler->execute($url)
        );
    }
}
