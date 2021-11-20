Feature: Browsing Admin Sections
  In order to administrate the web page
  As an admin user
  I should be able to navigate through all admin sections

  Scenario: Browsing the Admin Post section and subsections
    Given I go to "http://localhost:8000/admin/post"
    Then  the response status code should be 200

    When I follow "Añadir publicación"
    Then should be on "http://localhost:8000/admin/post/add"
    And  I should see "NUEVA PUBLICACIÓN"

    When I move backward one page
    And  I follow "Editar"
    Then the url should match "/admin/post/edit/"
    And  I should see "EDICIÓN DE PUBLICACIÓN EXISTENTE"
