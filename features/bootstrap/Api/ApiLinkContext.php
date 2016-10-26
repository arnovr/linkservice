<?php

namespace BehatTests\Api;

use Behat\Behat\Context\Context;
use LinkService\Domain\Model\ClickEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Defines application features from the specific context.
 */
class ApiLinkContext extends KernelWebTestCase implements Context
{
    /**
     * @var RedirectResponse
     */
    private $response;

    public function __construct()
    {
        $this->client = self::createClient();
        parent::__construct();
    }

    /**
     * @Given /^a referrer "([^"]*)" which refers to link "([^"]*)"$/
     */
    public function aReferrerWhichRefersToLink($referrer, $link) {
        $this->shouldAddTrackableLinkRepository($referrer, $link);
        $this->shouldAddEventBus();

        $this->client->request(
            "GET",
            $referrer,
            [], [], [],
            '{}'
        );
    }

    /**
     * @When /^requesting the referrer$/
     */
    public function requestingTheReferrer()
    {
        $this->response = $this->client->getResponse();
    }

    /**
     * @Then /^the link should be "([^"]*)"$/
     */
    public function theLinkShouldBe($link)
    {
        $this->assertSame(
            302,
            $this->response->getStatusCode()
        );
        $this->assertSame(
            $link,
            $this->response->getTargetUrl()
        );
    }

    /**
     * @Then /^a click event should have occurred for referrer "([^"]*)"$/
     */
    public function aClickEventShouldHaveOccurredForReferrer($referrer)
    {
        $this->assertContainsOnlyInstancesOf(ClickEvent::class, $this->eventBus->getEvents());
    }
}
