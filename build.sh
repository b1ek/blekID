#!/usr/bin/bash
cp .env.example .env
php artisan key:generate
composer install
npm install
npm run build
docker-compose up -d
