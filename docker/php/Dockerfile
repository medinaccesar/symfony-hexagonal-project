FROM php:8.2-fpm-alpine

ARG UID
ENV AMQP_VERSION=2.1.0
ENV XDEBUG_VERSION=3.2.2

# Add a non-privileged user 'appuser' with the specified UID
RUN adduser -u ${UID} --disabled-password --gecos "" appuser \
    && chown -R appuser:appuser /home/appuser/

# Update and upgrade apk packages, then install necessary dependencies
RUN apk --update upgrade \
    && apk add --no-cache \
    autoconf \
    automake \
    make \
    gcc \
    g++ \
    git \
    bash \
    icu-dev \
    libzip-dev \
    rabbitmq-c-dev \
    linux-headers

# Install PHP extensions
RUN docker-php-ext-install \
    zip  \
    pdo  \
    bcmath \
    opcache \
    intl \
    pdo_mysql \
    &&  pecl install  \
    amqp-${AMQP_VERSION}  \
    xdebug-${XDEBUG_VERSION} \
    redis \
    && docker-php-ext-enable  \
    amqp  \
    xdebug \
    redis


# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash -s - --install-dir /usr/local/bin


COPY conf /usr/local/etc/php/

USER appuser
WORKDIR /app