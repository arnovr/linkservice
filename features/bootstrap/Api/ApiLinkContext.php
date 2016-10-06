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
     * @Given /^a trackable link "([^"]*)" which refers to link "([^"]*)" with "([^"]*)" clicks$/
     */
    public function aTrackableLinkWhichRefersToLinkWithClicks($trackableLink, $link, $clicks) {
        $this->shouldAddTrackableLinkToRepository($trackableLink, $link, $clicks);

        $this->client->request(
            "GET",
            $trackableLink,
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
     * @Given /^the clicks should be incremented for trackable link "([^"]*)"$/
     */
    public function theClicksShouldBeIncrementedForTrackableLink($trackableLink)
    {
        $this->assertSame(
            1,
            $this->trackableLinkRepository->getBy($trackableLink)->clicks()
        );
    }
}
