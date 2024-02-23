#!/bin/bash

docker compose exec api cp .env.example .env

docker compose exec ui cp .env.example .env

docker compose exec api composer install
docker compose exec api php artisan migrate:fresh --seed
docker compose exec api php artisan key:generate
docker compose exec api php artisan storage:link
