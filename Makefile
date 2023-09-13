.SILENT:

DOCKER_COMPOSE = docker-compose
DOCKER_PHP_CONTAINER_EXEC = $(DOCKER_COMPOSE) exec ccapp
DOCKER_PHP_EXECUTABLE_CMD = $(DOCKER_PHP_CONTAINER_EXEC) php

CMD_ARTISAN = $(DOCKER_PHP_EXECUTABLE_CMD) artisan
CMD_COMPOSER = composer
CMD_NPM = npm

setup:
	$(DOCKER_COMPOSE) up -d --build
ifeq (,$(wildcard ./.env))
	cp .env.example .env
endif
ifeq (,$(wildcard ./vendor/))
	$(CMD_COMPOSER) install
endif
ifeq (,$(wildcard ./node_modules/))
	$(CMD_NPM) install
endif
	$(CMD_ARTISAN) key:generate
	echo "Waiting for MySQL to be ready..."
	timeout 3
	$(CMD_ARTISAN) migrate:fresh --seed
	$(CMD_ARTISAN) config:clear
	$(CMD_ARTISAN) route:clear
	$(CMD_ARTISAN) view:clear
	$(CMD_COMPOSER) dump-autoload
	$(CMD_NPM) run build
	$(CMD_NPM) run dev

start:
	$(DOCKER_COMPOSE) up -d

restart:
	$(DOCKER_COMPOSE) restart

build:
	$(DOCKER_COMPOSE) up -d --build

stop:
	$(DOCKER_COMPOSE) stop

down:
	$(DOCKER_COMPOSE) down

cache:
	$(CMD_ARTISAN) config:clear
	$(CMD_ARTISAN) route:clear
	$(CMD_ARTISAN) view:clear
	$(CMD_ARTISAN) optimize:clear

logs:
	$(DOCKER_COMPOSE) logs -ft --tail=50

reset:
	$(CMD_ARTISAN) migrate:fresh --seed

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

help:
	@echo "Laravel Docker Makefile"
	@echo ""
	@echo "Usage:"
	@echo "  make setup                 Setup the project"
	@echo "  make start                 Start the project"
	@echo "  make restart               Restart the project"
	@echo "  make build                 Build the project"
	@echo "  make stop                  Stop the project"
	@echo "  make down                  Stop and remove containers, networks, images, and volumes"
	@echo "  make cache                 Clear cache"
	@echo "  make install               Install the project"
	@echo "  make logs                  Show container logs"
	@echo "  make reset                 Reset the database and seed it"
	@echo "  make route-list            List routes"
	@echo "  make bash                  Access the app container bash"
	@echo "  make test-unit             Run unit tests"
	@echo "  make queue-work            Start the queue worker"
	@echo "  make queue-listen          Start the queue listener"
