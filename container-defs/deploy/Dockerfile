FROM php:8.3.12-apache-bullseye

ENV TZ="Europe/London"

RUN apt update && apt install -y wget \
    && wget https://github.com/phalcon/cphalcon/releases/download/v5.8.0/phalcon-pecl.tgz \
    && pecl install ./phalcon-pecl.tgz \
    && apt remove -y --purge wget \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions pdo_mysql

RUN a2enmod rewrite

COPY ./php.ini /usr/local/etc/php/php.ini
