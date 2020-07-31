FROM php:7.4-alpine

RUN apk --no-cache add autoconf g++ make \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) json \
    && docker-php-source delete

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN touch $PHP_INI_DIR/php.ini && echo "memory_limit = 256M" >> $PHP_INI_DIR/php.ini

RUN php -v
