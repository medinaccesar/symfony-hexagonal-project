UID = $(shell id -u)
SERVICE = symfony_php

install:
	U_ID=${UID} docker-compose up -d --build
	docker exec --user ${UID} ${SERVICE} composer install --no-interaction

migration:
	docker exec --user ${UID} ${SERVICE} php bin/console make:migration --no-interaction

migrations-migrate:
	docker exec --user ${UID} ${SERVICE} php bin/console doctrine:migrations:migrate --no-interaction

start: ## Start the containers
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

down: ## Stop the containers
	U_ID=${UID} docker-compose down

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

sh: ## sh into container
	docker exec -it --user ${UID} ${SERVICE} sh