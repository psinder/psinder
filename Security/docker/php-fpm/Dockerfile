FROM sip/psinder-php

USER root

RUN apk --no-cache add postgresql-dev \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-source delete

USER 1000:1000
