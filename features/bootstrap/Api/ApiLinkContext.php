<?php

namespace BehatTests\Api;

use Behat\Behat\Context\Context;
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
     * @Given /^a referrer "([^"]*)" which refers to link "([^"]*)" with "([^"]*)" clicks$/
     */
    public function aReferrerWhichRefersToLinkWithClicks($referrer, $link, $clicks) {
        $this->shouldAddTrackableLinkRepository($referrer, $link, $clicks);
        $this->shouldAddClickableRepositoryMock();

        $this->client->request(
            "GET",
            $referrer,
            [], [], [],
            '{}'
        );
    }

    /**
     * @When /^requesting the link$/
     */
    public function requestingTheLink()
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
     * @Given /^the clicks should be incremented for referrer "([^"]*)"$/
     */
    public function theClicksShouldBeIncrementedForReferrer($referrer)
    {
        $this->clickRepository->shouldHaveReceived('add');
    }
}
