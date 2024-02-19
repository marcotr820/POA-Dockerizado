# solo ejecutando el comando make setup se ejecutara todos los comandos registrados
setup:
	@make build
	@make up

build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
	docker exec laravel-docker-poa bash -c "composer install --ignore-platform-req=ext-zip"

# antes de ejecutar make data verificar la conexion a la bd, host, username, password en el .env
data:
	docker exec laravel-docker-poa bash -c "php artisan migrate"
	docker exec laravel-docker-poa bash -c "php artisan db:seed"
serve:
	docker exec laravel-docker-poa bash -c "php artisan serve"