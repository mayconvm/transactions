FROM php:7.4-fpm-alpine

MAINTAINER mayconvm@gmail.com

RUN apk  add --no-cache git unzip zip zlib-dev libzip-dev
RUN docker-php-ext-install zip \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN cd /usr/bin/ && wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php

RUN mkdir /var/www/html/app
WORKDIR /var/www/html/app

ENTRYPOINT ["sh", "docker/php/install.sh"]
CMD ["php-fpm"]
