Feature: Create a trackable link
  Scenario: Transform link
    Given I have the payload
    """
    {
      "trackableLink": "abc123/helloworld/andsomethingelse",
      "link" : "https://www.happycar.de/info/versicherung/document/some/very/long/path"
    }
    """
    When I request "POST /api/link"
    Then the response status code should be 201