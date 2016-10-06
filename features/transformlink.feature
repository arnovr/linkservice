Feature: transform a link into a trackable link
  Background:
    Given a trackable link "abc123/helloworld/andsomethingelse" which refers to link "https://www.happycar.de/info/versicherung/document/some/very/long/path" with "0" clicks
  Scenario: Transform link
    When requesting the link
    Then the link should be "https://www.happycar.de/info/versicherung/document/some/very/long/path"
    And the clicks should be incremented for trackable link "abc123/helloworld/andsomethingelse"
