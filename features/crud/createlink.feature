@create
Feature: Create a trackable link
  Scenario: Create link
    Given I have the payload
    """
    {
      "trackableLink": "abc123/helloworld/andsomethingelse",
      "link" : "https://www.url.com/info/versicherung/document/some/very/long/path"
    }
    """
    When I request "POST /api/link"
    Then the response status code should be 201