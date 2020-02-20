FROM php:7.3-rc-fpm-alpine

RUN apk --no-cache add autoconf g++ make \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) json \
    && pecl install ds-1.2.6 \
    && docker-php-ext-enable ds \
    && docker-php-source delete

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

USER 1000:1000

WORKDIR /var/www/app
