<?php
namespace BehatTests\Domain;

use Behat\Behat\Context\Context;
use LinkService\Domain\Model\ClickEvent;
use LinkService\Domain\Model\Link;
use LinkService\Domain\Model\Referrer;
use LinkService\Domain\Model\TrackableLink;
use PHPUnit_Framework_TestCase;

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
     * @Given /^a referrer "([^"]*)" which refers to link "([^"]*)"$/
     */
    public function aReferrerWhichRefersToLink($referrer, $link) {
        $this->link = TrackableLink::from(
            new Referrer($referrer),
            new Link($link)
        );
    }

    /**
     * @When /^requesting the referrer$/
     */
    public function requestingTheReferrer()
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
     * @Then /^a click event should have occurred for referrer "([^"]*)"$/
     */
    public function aClickEventShouldHaveOccurredForReferrer($referrer)
    {
        $this->assertCount(1, $this->link->getEvents());
        $this->assertContainsOnlyInstancesOf(ClickEvent::class, $this->link->getEvents());
    }
}
