CREATE USER 'admin'@'localhost' IDENTIFIED BY 'password';
CREATE USER 'admin'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON curso_symfony_fue.* TO 'admin'@'%';

CREATE USER 'test_user'@'localhost' IDENTIFIED BY 'test_password';
CREATE USER 'test_user'@'%' IDENTIFIED BY 'test_password';
GRANT ALL PRIVILEGES ON curso_symfony_fue_test.* TO 'test_user'@'%';

FLUSH PRIVILEGES;
