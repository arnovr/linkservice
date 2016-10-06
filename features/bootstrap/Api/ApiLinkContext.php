<?php

namespace BehatTests\Api;

use Behat\Behat\Context\Context;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\TrackableLink;
use LinkService\Infrastructure\Persistence\InMemory\InMemoryTrackableLinkRepository;
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

    /**
     * @var InMemoryTrackableLinkRepository
     */
    private $service;

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
     * @param $trackableLink
     * @param $link
     * @param $clicks
     */
    private function shouldAddTrackableLinkToRepository($trackableLink, $link, $clicks)
    {
        $this->service = new InMemoryTrackableLinkRepository(
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
            $this->service
        );
    }

    /**
     * @Given /^the clicks should be incremented for trackable link "([^"]*)"$/
     */
    public function theClicksShouldBeIncrementedForTrackableLink($trackableLink)
    {
        $this->assertSame(
            1,
            $this->service->getBy($trackableLink)->clicks()
        );
    }
}
