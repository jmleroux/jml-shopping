DOCKER_EXEC = docker-compose exec fpm
DOCKER_RUN = docker-compose run --rm fpm

.PHONY: up
up:
	docker-compose up -d

xdebug-on:
	docker-compose stop fpm
	XDEBUG_ENABLED=1 docker-compose up -d fpm

xdebug-off:
	docker-compose stop fpm
	XDEBUG_ENABLED=0 docker-compose up -d fpm

.PHONY: down
down:
	docker-compose down --remove-orphans

.env.local: .env
	cp -n .env .env.local

vendor:
	rm -rf var/cache/* var/log/*
	$(DOCKER_RUN) composer install
	$(DOCKER_RUN)  bin/console cache:warmup
	docker-compose run --rm node yarn install

.PHONY: setup
setup:
	make down
	make .env.local
	rm -rf vendor
	make vendor
	docker-compose run --rm node yarn dev
	make database
	make up

.PHONY: database
database:
	$(DOCKER_RUN) bin/console jmlshopping:install
	$(DOCKER_RUN) bin/console jmlshopping:user:add jmleroux.pro@gmail.com

.PHONY: tests
tests:
	APP_ENV=test $(DOCKER_RUN) ./vendor/bin/phpspec run
	APP_ENV=test $(DOCKER_RUN) ./vendor/bin/simple-phpunit ${path}

.PHONY: coverage
coverage:
	XDEBUG_ENABLED=1 APP_ENV=test $(DOCKER_RUN) vendor/bin/simple-phpunit --coverage-html var/coverage

