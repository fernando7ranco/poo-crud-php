MYPATH=/var/www/app.dev

autoload:
	docker-compose exec -w $(MYPATH) php composer dumpautoload -o

composer-install:
	docker-compose exec -w $(MYPATH) php composer install

run-test-file:
	docker-compose exec -w $(MYPATH) composer test --verbose $(FILE)