Feature: Update a referrer
  Background:
    Given The trackable link "abc123/helloworld/andsomethingelse" exists
  Scenario: Update referrer
    Given I have the payload
    """
    {
      "referrer": "abc123/helloworld/andsomethingelse",
      "link" : "https://www.url.com/new/path"
    }
    """
    When I request "PUT /api/link"
    Then the response status code should be 204

  Scenario: Could not update referrer
    Given I have the payload
    """
    {
      "referrer": "abc123/helloworld/notexistent",
      "link" : "https://www.url.com/new/path"
    }
    """
    When I request "PUT /api/link"
    Then the response status code should be 404