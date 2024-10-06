FROM php:8.3.12-apache-bullseye

ENV TZ="Europe/London"

RUN apt update && apt install -y wget \
    && wget https://github.com/phalcon/cphalcon/releases/download/v5.8.0/phalcon-pecl.tgz \
    && pecl install ./phalcon-pecl.tgz \
    && apt remove -y --purge wget \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions pdo_mysql xdebug zip

RUN a2enmod rewrite

COPY ./php.ini /usr/local/etc/php/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer
