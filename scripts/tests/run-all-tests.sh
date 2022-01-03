#!/usr/bin/env bash

# Notas:
# - Lanzar Selenium una sesión de terminal aparte => bash ./scripts/tests/start-selenium.sh
# - Para detener Selenium => bash ./scripts/tests/stop-selenium.sh
# - Inicialización de datos, borrado logs, borrado e-mails, cachés, etc... es recomendado que lo lleve a cabo el test interesado

XDEBUG_MODE=off php bin/console doctrine:schema:drop --force --env=test
XDEBUG_MODE=off php bin/console doctrine:schema:update --force --env=test

./vendor/phpunit/phpunit/phpunit
XDEBUG_MODE=off php bin/console hautelook:fixtures:load --purge-with-truncate --no-interaction --env=test

./vendor/behat/behat/bin/behat --config=tests/behat.yaml

