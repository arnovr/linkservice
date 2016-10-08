<?php
declare(strict_types=1);

namespace LinkService\Infrastructure\Api\Controller;

use LinkService\Application\GetTrackableLinkHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectController
{
    /**
     * @var GetTrackableLinkHandler
     */
    private $getTrackableLinkHandler;

    /**
     * @param GetTrackableLinkHandler $getTrackableLinkHandler
     */
    public function __construct(GetTrackableLinkHandler $getTrackableLinkHandler)
    {
        $this->getTrackableLinkHandler = $getTrackableLinkHandler;
    }

    /**
     * @param string $url
     * @return RedirectResponse
     */
    public function redirectAction(string $url): RedirectResponse
    {
        return new RedirectResponse(
            $this->getTrackableLinkHandler->execute($url)
        );
    }
}
