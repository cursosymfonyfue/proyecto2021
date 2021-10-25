#!/usr/bin/env bash

cd /var/www/html && /usr/local/bin/php /usr/local/bin/composer install
php-fpm 
