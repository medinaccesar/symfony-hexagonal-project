FROM php:8.2-fpm-alpine

# Define a UID argument to allow the user to set the user ID when creating the container
ARG UID

# Add a non-privileged user 'appuser' with the specified UID
RUN adduser -u ${UID} --disabled-password --gecos "" appuser
RUN chown -R appuser:appuser /home/appuser/

# Update packages and install necessary dependencies
RUN apk update \
    && apk add --no-cache \
    git \
    libzip-dev \
    sqlite-dev \
    # Adding build dependencies
    autoconf \
    gcc \
    g++ \
    make \
    pkgconf \
    rabbitmq-c-dev \
    # Libraries for development
    rabbitmq-c

RUN docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# If you want to use Webpack, install Node.js and npm
RUN apk add --no-cache nodejs npm

# Install PHP's PDO and PDO MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install amqp extension
RUN pecl install amqp \
    && docker-php-ext-enable amqp

USER appuser
WORKDIR /app

EXPOSE 8080
