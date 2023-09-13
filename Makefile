.SILENT:

DOCKER_COMPOSE = docker-compose
DOCKER_COMPOSE_M1 = docker-compose -f docker-compose-m1.yml
DOCKER_PHP_CONTAINER_EXEC = $(DOCKER_COMPOSE) exec ccapp
DOCKER_PHP_EXECUTABLE_CMD = $(DOCKER_PHP_CONTAINER_EXEC) php

CMD_ARTISAN = $(DOCKER_PHP_EXECUTABLE_CMD) artisan
CMD_COMPOSER = composer
CMD_NPM = npm

setup: .env
	$(DOCKER_COMPOSE) up -d --build
	$(CMD_COMPOSER) install
	$(CMD_NPM) install
	$(CMD_ARTISAN) key:generate
	echo "Waiting for MySQL to be ready..."
	sleep 3
	$(CMD_ARTISAN) migrate:fresh --seed
	$(CMD_ARTISAN) config:clear
	$(CMD_ARTISAN) route:clear
	$(CMD_ARTISAN) view:clear
	$(CMD_COMPOSER) dump-autoload
	$(CMD_NPM) run build
	$(CMD_NPM) run dev

setup-m1: .env
	$(DOCKER_COMPOSE_M1) up -d --build
	$(CMD_COMPOSER) install
	$(CMD_NPM) install
	$(CMD_ARTISAN) key:generate
	echo "Waiting for MySQL to be ready..."
	sleep 3
	$(CMD_ARTISAN) migrate:fresh --seed
	$(CMD_ARTISAN) config:clear
	$(CMD_ARTISAN) route:clear
	$(CMD_ARTISAN) view:clear
	$(CMD_COMPOSER) dump-autoload
	$(CMD_NPM) run build
	$(CMD_NPM) run dev

start:
	$(DOCKER_COMPOSE) up -d

start-m1:
	$(DOCKER_COMPOSE_M1) up -d

restart:
	$(DOCKER_COMPOSE) restart

build-m1:
	$(DOCKER_COMPOSE_M1) up -d --build

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

queue-work:
	$(DOCKER_PHP_CONTAINER_EXEC) php artisan queue:work

queue-listen:
	$(DOCKER_PHP_CONTAINER_EXEC) php artisan queue:listen

.env:
	cp .env.example .env

help:
	@echo "Laravel Docker Makefile"
	@echo ""
	@echo "Usage:"
	@echo "  make setup                 Setup the project"
	@echo "  make setup-m1              Setup the project for M1 Mac"
	@echo "  make start                 Start the project"
	@echo "  make start-m1              Start the project for M1 Mac"
	@echo "  make restart               Restart the project"
	@echo "  make build                 Build the project"
	@echo "  make build-m1              Build the project for M1 Mac"
	@echo "  make stop                  Stop the project"
	@echo "  make down                  Stop and remove containers, networks, images, and volumes"
	@echo "  make cache                 Clear cache"
	@echo "  make logs                  Show container logs"
	@echo "  make reset                 Reset the database and seed it"
	@echo "  make route-list            List routes"
	@echo "  make bash                  Access the app container bash"
	@echo "  make queue-work            Start the queue worker"
	@echo "  make queue-listen          Start the queue listener"
