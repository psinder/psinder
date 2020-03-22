Feature: Adopters
  Scenario: Registering valid adopter
    When I register example adopter
      | firstName | lastName | birthDate  | gender |
      | John       | Doe       | 1995-01-01  | m  |
    Then I should be able to log in as adopter
