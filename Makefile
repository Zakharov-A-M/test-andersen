DOCKER_COMPOSE?=docker-compose
EXEC?=$(DOCKER_COMPOSE) exec php-fpm
COMPOSER=$(EXEC) composer

start: build up clear db

build:
	$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --force-rm --pull

up:
	$(DOCKER_COMPOSE) up -d --remove-orphans

clear:
	-$(EXEC) bin/console cache:clear

vendor:
	$(COMPOSER) install

db: vendor
	-$(EXEC) php bin/console doctrine:migrations:migrate
