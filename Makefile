# Executables (local)
DOCKER_COMPOSE = docker compose --env-file frankenphp/env/docker-compose.override.env

# Docker containers
PHP_CONTAINER = $(DOCKER_COMPOSE) exec php

# Executables in containers
PHP      = $(PHP_CONTAINER) php
COMPOSER = $(PHP) composer
SYMFONY  = $(PHP) bin/console

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc test

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker Compose  🐳 ————————————————————————————————————————————————————————————————
env-create: ## Create environment variables
	cp -i frankenphp/env/docker-compose.env frankenphp/env/docker-compose.override.env

install: ## Builds the Docker images
	make env-create
	make build

build: ## Builds the Docker images
	@$(DOCKER_COMPOSE) build --pull --no-cache

rebuild: ## Rebuilds the Docker images
	$(DOCKER_COMPOSE) build --pull --no-cache

chown: ## Change the owner of file system files and directories
	$(DOCKER_COMPOSE) run --rm php chown -R 1000:1000 .

ps: ## List containers
	$(DOCKER_COMPOSE) ps

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMPOSE) up --detach

run: ## Start the docker hub in attached mode (with logs)
	@$(DOCKER_COMPOSE) up

down: ## Stop the docker hub
	@$(DOCKER_COMPOSE) down --remove-orphans

logs: ## Show live logs
	@$(DOCKER_COMPOSE) logs --tail=0 --follow

##—————— PHP container ——————
e: ## Connect to the FrankenPHP container via bash so up and down arrows go to previous commands
	$(PHP_CONTAINER) bash

sh: ## Connect to the FrankenPHP container
	@$(PHP_CONTAINER) sh

test: ## Start tests with phpunit, pass the parameter "c=" to add options to phpunit, example: make test c="--group e2e --stop-on-failure"
	@$(eval c ?=)
	@$(DOCKER_COMPOSE) exec -e APP_ENV=test php bin/phpunit $(c)

php-check-all: ## Check code style, static code analysis, audit the composer packages and run tests
	$(PHP_CONTAINER) check-all
