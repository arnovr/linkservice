Feature: Update a trackable link
  Scenario: Update link
    Given I have the payload
    """
    {
      "trackableLink": "abc123/helloworld/andsomethingelse",
      "link" : "https://www.happycar.de/new/path"
    }
    """
    When I request "PUT /api/link"
    Then the response status code should be 204