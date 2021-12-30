# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --tags=HOME_PAGE_LIKES
@HOME_PAGE_LIKES
@javascript
Feature: Check Home Page Likes Functionallity
  In order to like a post
  As user
  I should be able to click on the likes button and see the counter increased by one

  Scenario: Home Page Likes Functionallity
    Given I go to "http://cursosymfonyfue.local"
    Then  print last response
    Then  I click on "Likes"
