# ./vendor/behat/behat/bin/behat --config=tests/behat.yaml --suite=admin_routing
@javascript
Feature: Browsing Admin Sections
  In order to administrate the web page
  As an admin user
  I should be able to navigate through all admin sections

  Scenario: Browsing the Admin Post section and subsections
    Given I go to "http://test.cursosymfonyfue.local:81/login"
    And   I navigate from a desktop browser
    And   I take a screenshot "deskto"
    And   I should see "Login form"

    When  I fill in "Email" with "admin@admin.admin"
    And   I fill in "Password" with "admin"
    And   I press "Acceder"
    Then  I should be on "http://test.cursosymfonyfue.local:81/admin/dashboard"
    And   I should see "WELLCOME TO THE COMUNITY MODERATOR DASHBOARD"

    # Aquí necesitamos Javascript, por el dropdown de secciones de admin!
    When I follow "Admin"
    And  I take a screenshot "admin"
    When I follow "Post"
    Then should be on "http://localhost:81/admin/post/"
    When I follow "Añadir publicación"
    Then should be on "http://test.cursosymfonyfue.local:8001/admin/post/add"
    And  I should see "NUEVA PUBLICACIÓN"

    When I move backward one page
    And  I follow "Editar"
    Then the url should match "/admin/post/edit"
    And  I should see "EDICIÓN DE PUBLICACIÓN EXISTENTE"
