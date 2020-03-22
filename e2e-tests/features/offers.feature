Feature: Posting offers
  Scenario: Post valid offer
    Given logged in as example shelter
    And information about pet:
      | name | sex | birthdate | type | breed |
      | Doggo | m | 2015-01-01 | dog  | pitbull |
    When I post an offer
    Then it should be visible on offer list
  Scenario: Adopter applying to offers
    Given logged in as example shelter
    And information about pet:
      | name | sex | birthdate | type | breed |
      | Doggo | m | 2015-01-01 | dog  | pitbull |
    When I post an offer
    Given logged in as example adopter
    And I apply to offer
    Then I should be visible on offer applicants list
