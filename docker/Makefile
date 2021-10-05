init: up landing-init activity-init
up:
	docker-compose up -d
landing-init:
	docker-compose run --rm landing-php composer install
activity-init:
	docker-compose run --rm activity-php composer install
	docker-compose run --rm activity-php php artisan migrate --force
tests:
	docker-compose run landing-php php artisan test
