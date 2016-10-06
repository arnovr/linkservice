@delete
Feature: Delete an existing trackable link
  Background:
    Given The trackable link "abc123/helloworld/andsomethingelse" exists
  Scenario: Delete trackable link
    Given I have the payload
    """
    {
      "trackableLink": "abc123/helloworld/andsomethingelse"
    }
    """
    When I request "DELETE /api/link"
    Then the response status code should be 204


  Scenario: Could not delete trackable link
    Given I have the payload
    """
    {
      "trackableLink": "abc123/helloworld/notexistent"
    }
    """
    When I request "DELETE /api/link"
    Then the response status code should be 400