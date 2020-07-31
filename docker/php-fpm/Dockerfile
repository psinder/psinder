FROM php:7.4-fpm-alpine

RUN apk --no-cache add autoconf g++ make \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) json \
    && docker-php-source delete

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY php.ini $PHP_INI_DIR/php.ini

USER 1000:1000

WORKDIR /var/www/app
