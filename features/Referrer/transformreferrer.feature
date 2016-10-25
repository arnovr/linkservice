Feature: transform a referrer into a link
  Scenario: Transform referrer
    Given a referrer "abc123/helloworld/andsomethingelse" which refers to link "https://www.url.com/info/versicherung/document/some/very/long/path"
    When requesting the referrer
    Then the link should be "https://www.url.com/info/versicherung/document/some/very/long/path"
    And a click event should have occurred for referrer "abc123/helloworld/andsomethingelse"
