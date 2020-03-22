IMAGE_NAME = sip/psinder-e2e
APP_DIR=e2e-tests
PROFILE=api
PROJECT_DIR = ../

include ../Makefile

PHP_SERVICE=e2e

include ../Makefile-php

e2e-run:
	$(MAKE) -C .. reload-db
	service=${PHP_SERVICE} cmd="php vendor/bin/behat --profile=api" $(MAKE) docker-compose-exec

behat:
	service=${PHP_SERVICE} cmd="php vendor/bin/behat $(arg)" $(MAKE) docker-compose-exec

shell:
	service=${PHP_SERVICE} cmd="/bin/sh" $(MAKE) docker-compose-exec

setup: composer-install
