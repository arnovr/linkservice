FROM php:7.0-fpm

RUN docker-php-ext-install pdo pdo_mysql

USER www-data

COPY php-fpm.conf /etc/php-fpm.conf 

#WORKDIR /var/www/html
