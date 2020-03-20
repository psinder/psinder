DOCKER_ENV_FILES ?= --env-file=.env
DOCKER_RUN = docker run --init -it $(DOCKER_ENV_FILES) --rm -v `pwd`/..:/app -v /tmp/composer-cache:/.composer/cache -w /app/$(APP_DIR) -u 1000 $(IMAGE_NAME)
PROJECT_DIR ?= ./
DOCKER_COMPOSE = docker-compose --project-directory=$(PROJECT_DIR)
COMPOSE_EXEC = $(DOCKER_COMPOSE) exec

.PHONY: test

docker-compose-ps:
	$(DOCKER_COMPOSE) ps

docker-compose-exec:
	$(DOCKER_COMPOSE) exec $(service) $(cmd)

docker-compose-up:
	$(DOCKER_COMPOSE) up --force-recreate -d $(service)

docker-compose-build:
	$(DOCKER_COMPOSE) build

docker-compose-config:
	$(DOCKER_COMPOSE) config

docker-compose-stop:
	$(DOCKER_COMPOSE) stop $(arg)

docker-compose-down:
	$(DOCKER_COMPOSE) down -v

docker-compose-logs:
	$(DOCKER_COMPOSE) logs $(arg) $(service)

docker-build:
	docker build -t $(IMAGE_NAME) .

reload-db:
	SERVICE=Adoption cmd=db-fixtures-load $(SERVICE_EXECUTE)
	SERVICE=Security cmd=db-fixtures-load $(SERVICE_EXECUTE)

.env:
	cp .env.dist .env

service-execute:
	$(MAKE) -C $(SERVICE) $(cmd)

# cross-service targets
initial-setup: .env
	docker build -t sip/psinder-php docker/php-fpm
	$(MAKE) docker-compose-down
	SERVICE=PhpSharedKernel cmd=setup $(MAKE) service-execute
	$(MAKE) docker-compose-build
	$(MAKE) docker-compose-up
	SERVICE=Security cmd=setup $(MAKE) service-execute
	SERVICE=Adoption cmd=setup $(MAKE) service-execute
	SERVICE=e2e-tests cmd=setup $(MAKE) service-execute

qa-all:
	SERVICE=PhpSharedKernel cmd=qa $(MAKE) service-execute
	SERVICE=Security cmd=qa $(MAKE) service-execute
	SERVICE=Adoption cmd=qa $(MAKE) service-execute
	SERVICE=e2e-tests cmd=e2e-run $(MAKE) service-execute
