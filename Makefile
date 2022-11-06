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
	$(COMPOSER) install -n

wait-for-db:
	$(EXEC) php -r "set_time_limit(60);for(;;){if(@fsockopen('mysql',3306)){echo \"db ready\n\"; break;}echo \"Waiting for db\n\";sleep(1);}"

db: vendor wait-for-db
	-$(EXEC) php bin/console doctrine:migrations:migrate
