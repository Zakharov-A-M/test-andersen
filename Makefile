DOCKER_COMPOSE?=docker-compose
DOCKER_COMPOSE_PROD?=docker-compose -f docker-compose.prod.yaml
EXEC?=$(DOCKER_COMPOSE) exec php-fpm
COMPOSER=$(EXEC) composer

start: build up clear vendor db
start-prod: build-prod up clear db

build:
	$(DOCKER_COMPOSE) stop
	$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --force-rm --pull

build-prod:
	$(DOCKER_COMPOSE_PROD) stop
	$(DOCKER_COMPOSE_PROD) pull --ignore-pull-failures
	$(DOCKER_COMPOSE_PROD) build --force-rm --pull

up:
	$(DOCKER_COMPOSE) up -d --remove-orphans

clear:
	-$(EXEC) bin/console cache:clear

vendor:
	$(COMPOSER) install

db:
	-$(EXEC) php bin/console --no-interaction doctrine:migrations:migrate
