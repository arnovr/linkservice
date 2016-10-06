<?php

namespace BehatTests\Api;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\Response;

class ApiContext extends KernelWebTestCase implements Context
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var string
     */
    private $payload;

    /**
     * @Given The trackable link :trackableLink exists
     */
    public function theTrackableLinkExists($trackableLink)
    {
        $this->shouldAddTrackableLinkToRepository($trackableLink, "empty", 0);
    }

    /**
     * @Given /^I have the payload$/
     */
    public function iHaveThePayload(PyStringNode $payload)
    {
        $this->payload = $payload->getRaw();
    }

    /**
     * @When /^I request "([^"]*)"$/
     */
    public function iRequest($call)
    {
        $parts = explode(' ',$call);
        $this->client->request(
            $parts[0],
            $parts[1],
            [], [], [],
            $this->payload
        );
        $this->response = $this->client->getResponse();
    }

    /**
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe($statusCode)
    {
        $this->assertSame(
            (int) $statusCode,
            $this->response->getStatusCode()
        );
    }
}