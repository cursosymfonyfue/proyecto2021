Feature: Check Frontend Routing
  In order to adquire knowledge from the web portal
  As user
  I should be able to navigate throughout all the sections properly

  Scenario: Home Page is accesible
    Given I go to "http://localhost:8000"
    Then  I should see "Bienvenid@s al Curso de Symfony Fue"

  Scenario: Contact form is accesible
    Given I go to "http://localhost:8000/contact-form-04"
    Then  I should see "Contact Form"

  Scenario: Registration form is accesible
    Given I go to "http://localhost:8000/register"
    Then  I should see "Register"
