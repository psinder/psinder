FROM php:7.3-rc-alpine

RUN apk --no-cache add autoconf g++ make \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) json \
    && docker-php-source delete

COPY --from=composer /usr/bin/composer /usr/bin/composer

USER 1000:1000

CMD vendor/bin/behat

WORKDIR /var/www/app
