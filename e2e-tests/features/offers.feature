Feature: Posting offers
  Scenario: Post valid offer
    Given example shelter
    And information about pet:
      | name | sex | birthdate | type | breed |
      | Doggo | m | 2015-01-01 | dog  | pitbull |
    When I post an offer
    Then it should be visible on offer list
