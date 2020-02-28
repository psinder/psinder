all: composer-install qa

PROJECT_DIR = ../
DOCKER_ENV_FILES =

include ../Makefile

IMAGE_NAME = sip/psinder-php-sharedkernel
APP_DIR=PhpSharedKernel
PHP_RUN=$(DOCKER_RUN)

include ../Makefile-php

build:
	docker build . -t $(IMAGE_NAME)

setup:
	$(MAKE) build
	$(MAKE) composer-install
