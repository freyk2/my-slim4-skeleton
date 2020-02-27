docker-down:
	docker-compose down --remove-orphans

docker-up:
	docker-compose up -d

docker-reload: docker-down docker-up

docker-build:
	docker-compose up --build -d

docker-in:
	docker-compose exec api-cli bash

api-permissions:
	sudo chmod -R 777 api/var

api-env:
	docker-compose exec api-cli rm -f .env
	docker-compose exec api-cli ln -sr .env.example .env

api-composer:
	docker-compose exec api-cli composer install

clear-db:
	docker-compose exec api-cli php bin/app.php orm:clear-cache:metadata
	docker-compose exec api-cli php bin/app.php orm:schema-tool:drop --force
	docker-compose exec api-cli php bin/app.php orm:schema-tool:update --force
