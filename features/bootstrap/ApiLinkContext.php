<?php

use Behat\Behat\Context\Context;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;
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
        $service = new InMemoryTrackableLinkRepository(
            [
                TrackableLink::from(
                    new Link($trackableLink),
                    new Link($link),
                    $clicks
                )
            ]
        );

        $this->client->getContainer()->set(
            'link_service.infrastructure.persistence.trackable_link_repository',
            $service
        );


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
