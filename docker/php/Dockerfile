##################################################################################################################
FROM php:7.4.23-fpm

# Install Composer
RUN cd /tmp && curl -sS https://getcomposer.org/installer > composer.phar && \
    chmod +x /tmp/composer.phar && \
    mv /tmp/composer.phar /usr/local/bin/composer

RUN /usr/local/bin/php /usr/local/bin/composer && \
    mv composer.phar /usr/local/bin/composer


# Install Symfony Command
RUN cd /tmp && curl -sS https://get.symfony.com/cli/installer > symfony.phar && \
    chmod +x symfony.phar && \
    mv symfony.phar /usr/local/bin/symfony

RUN cd /tmp && symfony && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Install PHPUnit Globally
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

# Install GoogleChromeStable
#RUN sudo sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list'   \
#    sudo apt-get update \
#    sudo apt-get install google-chrome-stable

RUN curl -LO https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
RUN apt-get install -y ./google-chrome-stable_current_amd64.deb
RUN rm google-chrome-stable_current_amd64.deb

# INSTALL REDIS
RUN pecl install redis && docker-php-ext-enable redis

# INSTALL XDEBUG
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo pdo_mysql opcache zip

COPY conf/php.ini /usr/local/etc/php/php.ini
COPY conf/php-fpm-pool.conf /usr/local/etc/php/pool.d/www.conf
COPY conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# ENABLE XDEBUG BY UNCOMMENTING THE FOLLOWING LINE:
# COPY conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini


RUN echo "www-data ALL=(ALL) ALL" > /etc/sudoers

WORKDIR /var/www/html
USER www-data
RUN chown www-data:www-data /var/www/html

RUN mkdir -p /var/www/html/var/log
RUN chown www-data:www-data /var/www/html/var/log

ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_CHROME_ARGUMENTS='--disable-dev-shm-usage --disable-gpu --disable-extensions --remote-debugging-port=9222'

# Install composer from oficial image
COPY --from=composer /usr/bin/composer /usr/bin/composer



EXPOSE 9000

#ENTRYPOINT ["sh", "./docker/php/init.sh"]
##################################################################################################################
