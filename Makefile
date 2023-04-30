install:
	docker compose up -d --build
	docker compose exec php composer install
	docker compose exec php bin/console doctrine:migrations:migrate

up:
	docker compose up -d

down:
	docker compose down

php_bash:
	docker compose exec php sh

test_build:
	docker compose exec php bin/console cache:clear --env=test
	docker compose exec php bin/console doctrine:database:drop --env=test --if-exists --force
	docker compose exec php bin/console doctrine:database:create --env=test --if-not-exists
	docker compose exec php bin/console doctrine:migrations:migrate --env=test --no-interaction

test:
	docker compose exec php bin/phpunit

cs_fix:
	docker compose exec php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src --allow-risky=yes
