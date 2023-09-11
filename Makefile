.SILENT:

DOCKER_COMPOSE = docker-compose
DOCKER_PHP_CONTAINER_EXEC = $(DOCKER_COMPOSE) exec app
DOCKER_PHP_EXECUTABLE_CMD = $(DOCKER_PHP_CONTAINER_EXEC) php

CMD_ARTISAN = $(DOCKER_PHP_EXECUTABLE_CMD) artisan
CMD_COMPOSER = $(DOCKER_PHP_EXECUTABLE_CMD) -dmemory_limit=1G /usr/bin/composer

start:
	$(DOCKER_COMPOSE) up -d

stop:
	$(DOCKER_COMPOSE) stop

down:
	$(DOCKER_COMPOSE) down

install:
ifeq (,$(wildcard ./.env))
	cp .env.example .env
	$(CMD_ARTISAN) key:generate
endif
ifeq (,$(wildcard ./vendor/))
	$(CMD_COMPOSER) install
endif
	$(CMD_ARTISAN) queue:table
	$(CMD_ARTISAN) migrate
	$(CMD_ARTISAN) db:seed

logs:
	$(DOCKER_COMPOSE) logs -ft --tail=50

reset:
	$(CMD_ARTISAN) migrate:fresh
	$(CMD_ARTISAN) db:seed --class=DatabaseSeeder

swagger-generate:
	$(CMD_ARTISAN) l5-swagger:generate

route-list:
	$(CMD_ARTISAN) route:list

bash:
	$(DOCKER_PHP_CONTAINER_EXEC) bash

test-unit:
	$(CMD_ARTISAN) test

queue-work:
	$(DOCKER_PHP_CONTAINER_EXEC) php artisan queue:work

queue-listen:
	$(DOCKER_PHP_CONTAINER_EXEC) php artisan queue:listen

dispatch-update-wallet:
	$(DOCKER_PHP_CONTAINER_EXEC) php artisan tinker --execute "dispatch(new UpdateWallet($$CUSTOMER_ID, $$AMOUNT));"

help:
	@echo "Laravel Docker Makefile"
	@echo ""
	@echo "Usage:"
	@echo "  make start                 Start Docker containers"
	@echo "  make stop                  Stop Docker containers"
	@echo "  make install               Install Laravel application and seed the database"
	@echo "  make logs                  Show container logs"
	@echo "  make reset                 Reset the database and seed it"
	@echo "  make swagger-generate      Generate Swagger documentation"
	@echo "  make route-list            List routes"
	@echo "  make bash                  Access the app container bash"
	@echo "  make test-unit             Run unit tests"
	@echo "  make queue-work            Start the queue worker"
	@echo "  make queue-listen          Start the queue listener"
	@echo "  make dispatch-update-wallet  Dispatch the UpdateWallet job example: make dispatch-update-wallet CUSTOMER_ID=123 AMOUNT=123.00"
