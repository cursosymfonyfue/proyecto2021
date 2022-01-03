# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --tags=CONTACT_FORM
@CONTACT_FORM
Feature: Check ContactForm

  Scenario: Check Required Fields
    Given  I go to "http://test.cursosymfonyfue.local:81/contact-form"
    And   I press "Contactar!"
    Then  I should see "Full name required"
    Then  I should see "Subject required"
    Then  I should see "Body required"

  Scenario: Send Contact Form Properly
    Given  I go to "http://test.cursosymfonyfue.local:81/contact-form"
    Then   I should see "Contact Form"

    When   I fill in "First name *" with "Edu"
    And   I fill in "Subject *" with "Queridos reyes magos"
    And   I fill in "Body *" with "Me gustaría que me trajeran un portátil de 3.000 pavos"
    And   I press "Contactar!"
    Then  I should see "SOLICITUD DE CONTACTO RECIBIDA CORRECTAMENTE"

