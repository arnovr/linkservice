<?php

namespace BehatTests\Api;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;

class CreateLinkContext extends KernelWebTestCase implements Context
{

    /**
     * @Given /^I have the payload$/
     */
    public function iHaveThePayload(PyStringNode $payload)
    {
        $payload->getRaw();
    }

    /**
     * @When /^I request "([^"]*)"$/
     */
    public function iRequest($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        throw new PendingException();
    }
}