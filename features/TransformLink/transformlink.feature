Feature: transform a link into a trackable link
  Scenario: Transform link
    Given a trackable link "abc123/helloworld/andsomethingelse" which refers to link "https://www.url.com/info/versicherung/document/some/very/long/path" with "0" clicks
    When requesting the link
    Then the link should be "https://www.url.com/info/versicherung/document/some/very/long/path"
    And the clicks should be incremented for trackable link "abc123/helloworld/andsomethingelse"
