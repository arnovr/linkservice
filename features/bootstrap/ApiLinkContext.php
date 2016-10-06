<?php

use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

$_SERVER['KERNEL_DIR'] = __DIR__ . '/../../app/';

/**
 * Defines application features from the specific context.
 */
class ApiLinkContext extends WebTestCase implements Context
{
    /**
     * @var Client
     */
    private $client;

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
        //@todo set up in memory here
        // $links, $clicks
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
     * @Given /^the clicks should be incremented$/
     */
    public function theClicksShouldBeIncremented()
    {
        //@todo
    }
}
