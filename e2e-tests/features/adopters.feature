Feature: Registering adopter
  Scenario: Register valid adopter
    Given information about adopter
      | firstName | lastName | birthDate  | gender |
      | John       | Doe       | 1995-01-01  | m  |
    When I register adopter
    Then I should be able to log in as adopter
