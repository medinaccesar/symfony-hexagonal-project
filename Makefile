UID = $(shell id -u)
SERVICE = php

install:
	U_ID=${UID} docker-compose up -d --build
	docker exec --user ${UID} ${SERVICE} composer install --no-interaction
	docker exec --user ${UID} ${SERVICE} php bin/console doctrine:migrations:migrate --no-interaction

jwt-config:
	docker exec --user ${UID} ${SERVICE} mkdir -p config/jwt
	docker exec --user ${UID} ${SERVICE} openssl genrsa -out config/jwt/private.pem 4096
	docker exec --user ${UID} ${SERVICE} openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

jwt-pp-config:
	docker exec --user ${UID} ${SERVICE} mkdir -p config/jwt
	docker exec -it --user ${UID} ${SERVICE} openssl genrsa -out config/jwt/private.pem -aes256 4096
	docker exec -it --user ${UID} ${SERVICE} openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

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

cc: ## cache clear
	docker exec --user ${UID} ${SERVICE} php bin/console doctrine:cache:clear-metadata
	docker exec --user ${UID} ${SERVICE} php bin/console doctrine:cache:clear-query
	docker exec --user ${UID} ${SERVICE} php bin/console doctrine:cache:clear-result
	docker exec --user ${UID} ${SERVICE} php bin/console cache:clear

