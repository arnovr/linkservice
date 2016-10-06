<?php

use Behat\Behat\Context\Context;
use HappyCar\Domain\Model\Link;
use HappyCar\Domain\Model\TrackableLink;

/**
 * Defines application features from the specific context.
 */
class LinkContext extends PHPUnit_Framework_TestCase implements Context
{
    /**
     * @var TrackableLink
     */
    private $link;

    /**
     * @var Link
     */
    private $result;

    /**
     * @Given /^a trackable link "([^"]*)" which refers to link "([^"]*)" with "([^"]*)" clicks$/
     */
    public function aTrackableLinkWhichRefersToLinkWithClicks($trackableLink, $link, $clicks) {
        $this->link = TrackableLink::from(
            new Link($trackableLink),
            new Link($link),
            $clicks
        );
    }

    /**
     * @When /^requesting the link$/
     */
    public function requestingTheLink()
    {
        $this->result = $this->link->requestLink();
    }

    /**
     * @Then /^the link should be "([^"]*)"$/
     */
    public function theLinkShouldBe($link)
    {
        $this->assertSame((string) $this->result, $link);
    }

    /**
     * @Given /^the clicks should be incremented$/
     */
    public function theClicksShouldBeIncremented()
    {
        $this->assertSame($this->link->clicks(), 1);
    }
}