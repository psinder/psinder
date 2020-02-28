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
	$(DOCKER_COMPOSE) up -d $(service)

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
	cd Adoption && $(MAKE) db-fixtures-load && cd ..
	cd Security && $(MAKE) db-reset && cd ..

.env:
	cp .env.dist .env

initial-setup:
	$(MAKE) docker-compose-down
	cd PhpSharedKernel && $(MAKE) setup && cd ..
	$(MAKE) docker-compose-up
	cd Adoption && $(MAKE) setup && cd ..
	cd Security && $(MAKE) setup && cd ..
	cd e2e-tests && $(MAKE) setup && cd ..
