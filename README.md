##CURSO SYMFONY FUE

**Creación de imágenes de docker:**
```
docker-compose -f ./docker/docker-compose.yaml build
```

**Inicio contenedores de docker:**
```
docker-compose -f ./docker/docker-compose.yaml up
```

**Detener contenedores de docker:**
```
docker-compose -f ./docker/docker-compose.yaml down
```

**Acceder dentro del contenedor de php (donde están composer, symfony y php unit instalados)**
```
exec -it -u www-data csf_php bash
```

**Ejecutar comando composer update desde fuera del contenedor:**
```
exec -it -u www-data csf_php composer
```

**Ejecutar comando symfony desde fuera del contenedor:**
```
exec -it -u www-data csf_php symfony
```

Dentro del directorio docker/mariadb/migrations hay un dump de base de datos básico. 
Este dump se ejecutará la primera vez que se construya el contenedor, generará la base de datos del proyecto y la de mysql con los usuarios y contraseñas correspondientes.

**Acceso a la web desde un navegador:**

http://localhost:8000

**Acceso a phpmyadmin (panel para gestionar la base de datos):**

http://localhost:8080

Usuario/Clave: admin/password

**Acceso a e-mails enviados en modo local:**

http://localhost:8025

**Inicialización de base de datos en entorno dev**


XDEBUG_MODE=off php bin/console doctrine:schema:drop --force --env=dev

XDEBUG_MODE=off php bin/console doctrine:schema:update --force --env=dev

XDEBUG_MODE=off php bin/console doctrine:fixtures:load --env=dev

XDEBUG_MODE=off php bin/console hautelook:fixtures:load --purge-with-truncate --env=dev

___

Urls disponibles básicas:

- http://localhost:8000
- http://localhost:8000/hello-world
- http://localhost:8000/phpinfo.php
