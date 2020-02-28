all: docker-compose-up composer-install qa

PROJECT_DIR = ../

include ../Makefile

PHP_SERVICE=security-php

include ../Makefile-php

db-prepare: db-migrations-migrate

db-reset:
	service=${PHP_SERVICE} cmd="php vendor/bin/doctrine orm:schema-tool:drop --force" $(MAKE) docker-compose-exec
	service=${PHP_SERVICE} cmd="php vendor/bin/doctrine orm:schema-tool:update --force" $(MAKE) docker-compose-exec

db-migrations-diff:
	service=${PHP_SERVICE} cmd="php vendor/bin/doctrine-migrations migrations:diff" $(MAKE) docker-compose-exec

db-migrations-migrate:
	service=${PHP_SERVICE} cmd="php vendor/bin/doctrine-migrations migrations:migrate --no-interaction" $(MAKE) docker-compose-exec

console:
	service=${PHP_SERVICE} cmd="php bin/console $(arg)" $(MAKE) docker-compose-exec

setup: .env composer-install db-prepare
	$(MAKE) console arg="amqp:declare"
