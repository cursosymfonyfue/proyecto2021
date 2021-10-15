##CURSO SYMFONY FUE

**Creación de imágenes de docker:**
```
docker-compose -f ./docker/docker-compose.yaml build
```

**Inicio contenedores de docker:**
```
docker-compose -f ./docker/docker-compose.yaml up
```

Dentro del directorio dpcker/mariadb/migrations hay un dump de base de datos básico. 
Este dump se ejecutará la primera vez que se construya el contenedor, generará la base de datos del proyecto y la de mysql con los usuarios y contraseñas correspondientes.

**Acceso a la web desde un navegador:**

http://localhost:8000

**Acceso a phpmyadmin (panel para gestionar la base de datos):**

http://localhost:8080

Usuario/Clave: root/root

**Acceso a e-mails enviados en modo local:**

http://localhost:8025

___

Urls disponibles básicas:

- http://localhost:8000
- http://localhost:8000/hello-world
- http://localhost:8000/phpinfo.php
