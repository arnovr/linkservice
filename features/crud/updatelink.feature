@update
Feature: Update a trackable link
  Background:
    Given The trackable link "abc123/helloworld/andsomethingelse" exists
  Scenario: Update link
    Given I have the payload
    """
    {
      "trackableLink": "abc123/helloworld/andsomethingelse",
      "link" : "https://www.url.com/new/path"
    }
    """
    When I request "PUT /api/link"
    Then the response status code should be 204

  Scenario: Could not update trackable link
    Given I have the payload
    """
    {
      "trackableLink": "abc123/helloworld/notexistent",
      "link" : "https://www.url.com/new/path"
    }
    """
    When I request "PUT /api/link"
    Then the response status code should be 404