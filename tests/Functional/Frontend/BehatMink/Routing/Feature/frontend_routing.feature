# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --tags=FRONTEND_ROUTING
@FRONTEND_ROUTING
Feature: Check Frontend Routing
  In order to adquire knowledge from the web portal
  As user
  I should be able to navigate throughout all the sections properly

  Scenario: Home Page is accesible
    Given I go to "http://test.cursosymfonyfue.local"
    Then  I should see "Bienvenid@s al Curso de Symfony Fue"

  Scenario: Contact form is accesible
    Given I go to "http://test.cursosymfonyfue.local/contact-form-04"
    Then  I should see "Contact Form"

  Scenario: Registration form is accesible
    Given I go to "http://test.cursosymfonyfue.local/register"
    Then  I should see "Register"
