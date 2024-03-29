#-----------------------------------------------------------
# Docker
#-----------------------------------------------------------

# Start docker containers
start:
	docker-compose start

# Stop docker containers
stop:
	docker-compose stop

# Recreate docker containers
up:
	docker-compose up -d

# Stop and remove containers and networks
down:
	docker-compose down

# Stop and remove containers, networks, volumes and images
clean:
	docker-compose down --rmi local -v

# Restart all containers
restart: stop start

# Build and up docker containers
build:
	docker-compose build

# Build containers with no cache option
build-no-cache:
	docker-compose build --no-cache

# Build and up docker containers
rebuild: build up

env:
	[ -f .env ] && echo .env exists || cp .env.example .env

init: env up build install start

php-bash:
	docker exec -it --user=www-data ea-php bash
node-sh:
	docker exec -it --user=node ea-node sh

#-----------------------------------------------------------
# Database
#-----------------------------------------------------------

# Run database migrations
db-migrate:
	docker-compose exec php php artisan migrate

# Run migrations rollback
db-rollback:
	docker-compose exec php php artisan migrate:rollback

# Run last migration rollback
db-rollback-last:
	docker-compose exec php php artisan migrate:rollback --step=1

# Run seeders
db-seed:
	docker-compose exec php php artisan db:seed

# Fresh all migrations
db-fresh:
	docker-compose exec php php artisan migrate:fresh

#-----------------------------------------------------------
# Installation
#-----------------------------------------------------------

# Laravel
install:
	docker-compose stop
	#docker-compose run -u `id -u` --rm node npm i
	docker-compose run -u `id -u` --rm php composer i
	docker-compose run -u `id -u` --rm php php artisan key:generate
	docker-compose run -u `id -u` --rm php php artisan migrate:fresh --seed
	docker-compose run -u `id -u` --rm php php artisan l5-swagger:generate
	docker-compose run -u `id -u` --rm php php artisan storage:link
