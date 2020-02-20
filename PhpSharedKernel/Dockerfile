FROM php:7.3-rc-alpine

RUN apk --no-cache add autoconf g++ make \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) json \
    && pecl install ds-1.2.6 \
    && docker-php-ext-enable ds \
    && docker-php-source delete

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN php -v
