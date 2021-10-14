##################################################################################################################
FROM php:7.4-fpm

# Install PHPUnit
RUN cd /tmp && curl https://phar.phpunit.de/phpunit.phar > phpunit.phar && \
    chmod +x phpunit.phar && \
    mv /tmp/phpunit.phar /usr/local/bin/phpunit


RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget nodejs zip unzip \
    gnupg gnupg1 gnupg2 \
    zlib1g-dev \
    sudo \
    vim \
    libzip-dev

# INSTALL REDIS
RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-install pdo pdo_mysql opcache zip

COPY conf/php.ini /usr/local/etc/php/php.ini
COPY conf/php-fpm-pool.conf /usr/local/etc/php/pool.d/www.conf
COPY conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini


RUN echo "www-data ALL=(ALL) ALL" > /etc/sudoers

WORKDIR /var/www/html
USER www-data
RUN chown www-data:www-data /var/www/html

RUN mkdir -p /var/www/html/var/log
RUN chown www-data:www-data /var/www/html/var/log

EXPOSE 9000
CMD ["php-fpm"]
##################################################################################################################
