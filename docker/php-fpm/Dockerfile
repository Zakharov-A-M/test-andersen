FROM php:8.1-fpm as erp-php

COPY ./docker/php-fpm/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    libonig-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libxml2-dev \
    libzip-dev \
    librabbitmq-dev \
    zip

RUN docker-php-ext-install pdo pdo_mysql mbstring

RUN pecl install amqp-1.11.0 && docker-php-ext-enable amqp
RUN pecl install xdebug-3.1.5 && docker-php-ext-enable xdebug

WORKDIR /var/www/erp

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . ./
