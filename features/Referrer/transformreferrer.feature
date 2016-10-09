Feature: transform a referrer into a link
  Scenario: Transform referrer
    Given a referrer "abc123/helloworld/andsomethingelse" which refers to link "https://www.url.com/info/versicherung/document/some/very/long/path" with "0" clicks
    When requesting the referrer
    Then the link should be "https://www.url.com/info/versicherung/document/some/very/long/path"
    And the clicks should be incremented for referrer "abc123/helloworld/andsomethingelse"
