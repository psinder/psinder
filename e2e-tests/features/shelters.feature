Feature: Registering shelter
  Scenario: Register valid shelter
    Given information about shelter:
      | name | address_street | address_number | address_postal | address_city |
      | Example shelter | shelter st | 1  | 00-000 | shelter city |
    When I register shelter
    Then I should be able to log in
