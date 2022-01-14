# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --tags=FRONTEND_ROUTING
@FRONTEND_ROUTING
Feature: Check Frontend Routing
  In order to navigate throughout the frontend website
  As a community moderator
  I should be able to navigate throughout all the public sections properly

  Scenario: Home Page is accessible
    Given I go to "http://test.cursosymfonyfue.local:81/"
    Then  I should see "Bienvenid@s al Curso de Symfony Fue"

  Scenario: Contact form is accessible
    Given I go to "http://test.cursosymfonyfue.local:81/contact-form"
    Then  I should see "Contact Form"

  Scenario: Registration form is accessible
    Given I go to "http://test.cursosymfonyfue.local:81/register"
    Then  I should see "Register"

  Scenario: Login form is accessible
    Given I go to "http://test.cursosymfonyfue.local:81/login"
    Then  I should see "Login form"

  Scenario: Admin Posts are not accessible is user is not logged in
    Given I go to "http://test.cursosymfonyfue.local:81/admin/post/"
    Then  I should see "Login form"

  Scenario: Admin Categories are not accesible is user is not logged in
    Given I go to "http://test.cursosymfonyfue.local:81/admin/category/"
    Then  I should see "Login form"
