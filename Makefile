DOCKER_RUN = docker run --init -it --env-file=.env --rm -v `pwd`/..:/app -v /tmp/composer-cache:/.composer/cache -w /app/$(APP_DIR) -u 1000 $(IMAGE_NAME)
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
