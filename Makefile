DOCKER_COMPOSE?=docker-compose
EXEC?=$(DOCKER_COMPOSE) exec php-fpm
COMPOSER=$(EXEC) composer

DOCKER_COMPOSE_PROD?=$(DOCKER_COMPOSE) -f docker-compose.prod.yaml
EXEC_PROD?=$(DOCKER_COMPOSE_PROD) exec php-fpm
COMPOSER_PROD=$(EXEC_PROD) composer

start: build up clear vendor db
start-prod: build-prod clear-prod db-prod

# Local
build:
	$(DOCKER_COMPOSE) stop
	$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --force-rm --pull

up:
	$(DOCKER_COMPOSE) up -d --remove-orphans

clear:
	-$(EXEC) bin/console cache:clear

vendor:
	$(COMPOSER) install

db:
	-$(EXEC) php bin/console --no-interaction doctrine:migrations:migrate

# Prod
build-prod:
	$(DOCKER_COMPOSE_PROD) stop
	$(DOCKER_COMPOSE_PROD) pull --ignore-pull-failures
	$(DOCKER_COMPOSE_PROD) build --force-rm --pull

up-prod:
	$(DOCKER_COMPOSE_PROD) up -d --remove-orphans

clear-prod: up-prod
	-$(EXEC_PROD) bin/console cache:clear

vendor-prod:
	$(COMPOSER_PROD) install

wait-for-db:
	$(EXEC_PROD) php -r "set_time_limit(60);for(;;){if(@fsockopen('mysql',3306)){echo \"db ready\n\"; break;}echo \"Waiting for db\n\";sleep(1);}"

db-prod: wait-for-db
	-$(EXEC_PROD) php bin/console --no-interaction doctrine:migrations:migrate