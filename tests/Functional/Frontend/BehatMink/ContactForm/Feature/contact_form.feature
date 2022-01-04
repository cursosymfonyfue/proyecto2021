# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --tags=CONTACT_FORM

# NOTA: Si no hace falta JAVASCRIPT mejor!
# Ver Step Definitions de la Extensión para MailHog: https://github.com/rpkamp/mailhog-behat-extension/blob/master/src/Context/MailhogContext.php
@CONTACT_FORM
Feature: Check ContactForm

  Background:
    Given  I go to "http://test.cursosymfonyfue.local:81/contact-form"
    And    I navigate from a desktop browser
    And    I should see "Contact Form"
    # Given  my inbox is empty

  Scenario: Check Required Fields
    When  I press "Contactar!"
    Then  I should see "Full name required"
    And   I should see "Subject required"
    And   I should see "Body required"
    And   there should be 0 emails in my inbox

  Scenario: Send Contact Form Properly
    When  I fill in "First name *" with "Edu"
    And   I fill in "Subject *" with "Queridos reyes magos"
    And   I fill in "Body *" with "Me gustaría que me trajeran un portátil de 3.000 pavos"
    And   I press "Contactar!"
    Then  I should see "SOLICITUD DE CONTACTO RECIBIDA CORRECTAMENTE"
    And   there should be 1 email in my inbox
    And   I should see "Me gustaría que me trajeran un portátil de 3.000 pavos" in email
    When  I go to "http://test.cursosymfonyfue.local:81/login"
    And   I fill in "Email" with "admin@admin.admin"
    And   I fill in "Password" with "admin"
    And   I press "Acceder"

    # Esto no va si no estamos con Javascript
    #And   I follow "Admin"
    # Atención, este click se haría sobre el primer contact, no el del menú de "Admin" tendríamos que crear un Custom Step Definition
    #And   I follow "Contact"
    # En su lugar acceder directamente a la sección
    When  I go to "http://test.cursosymfonyfue.local:81/admin/contact"

    Then  I should see "Queri ..."
    And   I should see "Me gu ..."

    # #############################
    # Custom Step Definitions
    # #############################
    And   I should see only one row
    # Alternativa a Loguearse (depedencia del framework, no es considerada una buena práctica, pero esto es debatible)
    And   The contact form should be saved properly into the database
    # #############################
