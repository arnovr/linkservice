<?php

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class ApiLinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given /^a trackable link "([^"]*)" which refers to link "([^"]*)" with "([^"]*)" clicks$/
     */
    public function aTrackableLinkWhichRefersToLinkWithClicks($trackableLink, $link, $clicks) {

    }

    /**
     * @Given /^it has (\d+) clicks$/
     */
    public function itHasClicks($arg1)
    {
    }

    /**
     * @When /^requesting the link$/
     */
    public function requestingTheLink()
    {
    }
    /**
     * @Then /^the link should be "([^"]*)"$/
     */
    public function theLinkShouldBe($arg1)
    {
    }

    /**
     * @Given /^the clicks should be incremented$/
     */
    public function theClicksShouldBeIncremented()
    {
    }
}
