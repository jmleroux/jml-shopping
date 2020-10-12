DOCKER_EXEC = docker-compose exec fpm
DOCKER_RUN = docker-compose run -e PHP_XDEBUG_ENABLED=0 --rm fpm
DOCKER_RUN_XDEBUG = docker-compose run -e PHP_XDEBUG_ENABLED=1 --rm fpm

.PHONY: up
up:
	docker-compose up -d

xdebug-on:
	docker-compose stop fpm
	sed -i -e "s/PHP_XDEBUG_ENABLED: 0/PHP_XDEBUG_ENABLED: 1/g" docker-compose.override.yml
	docker-compose up -d fpm

xdebug-off:
	docker-compose stop fpm
	sed -i -e "s/PHP_XDEBUG_ENABLED: 1/PHP_XDEBUG_ENABLED: 0/g" docker-compose.override.yml
	docker-compose up -d fpm

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
	APP_ENV=test docker-compose run -e PHP_XDEBUG_ENABLED=0 --rm fpm ./vendor/bin/simple-phpunit ${path}

.PHONY: coverage
coverage:
	$(DOCKER_RUN_XDEBUG) vendor/bin/simple-phpunit --coverage-html var/coverage

