FROM php:8.4-cli

RUN pecl install redis \
    && docker-php-ext-enable redis

WORKDIR /var/www