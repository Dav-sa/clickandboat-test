COMPOSER = docker run --rm -it -v $$PWD:/app -w /app -u $$(id -u):$$(id -g) composer:2.2
PHP = docker run --rm -it -v $$PWD:/app -w /app -u $$(id -u):$$(id -g) php:8.1

composer.lock: composer.json
	$(COMPOSER) composer update --prefer-lowest
	touch composer.lock

vendor: composer.lock
	$(COMPOSER) composer install
	touch vendor

example: vendor
	$(PHP) php examples/sendAutomaticEmail.php
