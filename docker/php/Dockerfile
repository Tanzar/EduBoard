FROM php:8.1-fpm-alpine as app

# Copy php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

# Useful PHP extension installer image, copy binary into your container
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install php extensions
# exit on errors, exit on unset variables, print every command as it is executed
RUN set -eux; \
    install-php-extensions pdo pdo_mysql;

# allow super user
ENV COMPOSER_ALLOW_SUPERUSER=1

# obtain composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install bash
RUN apk update && apk add bash

# seting timezone for container
RUN apk add --no-cache tzdata
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# install symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

# Install NPM
RUN apk --no-cache add nodejs npm yarn

# Production build
FROM app as app_prod

WORKDIR /var/www/html

# copy application files to the working directory
COPY ./app .

# install
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# run composer dump-autoload --optimize
RUN composer dump-autoload --optimize

RUN yarn run build

RUN chmod -R 777 /var/www/html

# Dev elements
FROM app as app_dev

# Xdebug has different modes / functionalities. We can default to 'off' and set to 'debug'
# when we run docker compose up if we need it
ENV XDEBUG_MODE=debug

# Install xdebug
RUN set -eux; \
	install-php-extensions xdebug

