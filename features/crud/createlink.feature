Feature: Create a trackable link
  Scenario: Create link
    Given I have the payload
    """
    {
      "referrer": "abc123/helloworld/andsomethingelse",
      "link" : "https://www.url.com/info/versicherung/document/some/very/long/path"
    }
    """
    When I request "POST /api/link"
    Then the response status code should be 201

  Scenario: Could not create link, link exists
    Given The trackable link "abc123/helloworld/andsomethingelse" exists
    And I have the payload
    """
    {
      "referrer": "abc123/helloworld/andsomethingelse",
      "link" : "https://www.url.com/info/versicherung/document/some/very/long/path"
    }
    """
    When I request "POST /api/link"
    Then the response status code should be 409