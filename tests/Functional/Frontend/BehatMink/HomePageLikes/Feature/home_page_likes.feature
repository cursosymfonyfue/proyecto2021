# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --tags=HOME_PAGE_LIKES
@HOME_PAGE_LIKES
@javascript
Feature: Check Home Page Likes Functionallity
  In order to like a post
  As user
  I should be able to click on the likes button and see the counter increased by one

  Scenario: Home Page Likes Functionallity
    Given  I go to "http://test.cursosymfonyfue.local:81"
    # Then   I click on "Likes"
    # Then   I click on the first Likes counter
    When   I click on the "first" like
    Then   The number of likes for the "first" post should be 1
    # And    I take a screenshot "number-of-likes-for-the-first-post-should-be-1"

  # Alternativa
  Scenario: Home Page Likes Functionallity
    Given  I go to "http://test.cursosymfonyfue.local:81"
    And    I keep with the first post number of likes
    # Then   print last response
    Then   I click on the "first" like
    Then   First post number of likes should be increased by one

