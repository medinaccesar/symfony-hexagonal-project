FROM php:8.2-fpm-alpine

ARG UID

RUN adduser -u ${UID} --disabled-password --gecos "" appuser
RUN chown -R appuser:appuser /home/appuser/

RUN apk update \
    && apk add --no-cache \
    git \
    libzip-dev \
    sqlite-dev \  
    && docker-php-ext-install \
    zip

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN apk add --no-cache nodejs npm

USER appuser

WORKDIR /app
EXPOSE 8080

