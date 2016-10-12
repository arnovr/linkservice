FROM php:7.0-fpm

RUN docker-php-ext-install pdo pdo_mysql
RUN usermod -u 1000 www-data
USER www-data

COPY docker/php-fpm/php-fpm.conf /etc/php-fpm.conf

COPY composer.lock composer.lock
COPY app app
COPY src src
COPY web web
COPY vendor vendor
COPY var/bootstrap.php.cache var/bootstrap.php.cache