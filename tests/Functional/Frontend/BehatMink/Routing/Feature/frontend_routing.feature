# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --tags=BACKEND_ROUTING
@BACKEND_ROUTING
Feature: Check Backend Routing
  In order to navigate throughout the admin sections
  As a community moderator
  I should be able to navigate throughout all the admin sections properly

  Background:
    Given I go to "http://test.cursosymfonyfue.local/login"

  Scenario: Home Page is accessible
    Then  I should see "Bienvenid@s al Curso de Symfony Fue"

  Scenario: Contact form is accessible
    Given I go to "http://test.cursosymfonyfue.local/contact-form"
    Then  I should see "Contact Form"

  Scenario: Registration form is accessible
    Given I go to "http://test.cursosymfonyfue.local/register"
    Then  I should see "Register"

  Scenario: Login form is accessible
    Given I go to "http://test.cursosymfonyfue.local/login"
    Then  I should see "Login form"

  Scenario: Admin Posts are not accessible is user is not logged in
    Given I go to "http://test.cursosymfonyfue.local/admin/post/"
    Then  I should see "Login form"

  Scenario: Admin Categories are not accesible is user is not logged in
    Given I go to "http://test.cursosymfonyfue.local/admin/category/"
    Then  I should see "Login form"
