#!/usr/bin/env bash
echo 'start  .........'

echo copy env
cp .env.example .env

echo 'npm install'
npm install

echo 'composer install'
composer install

echo 'app key:generate'
php artisan key:generate

echo 'npm run build'
npm run build

echo 'php artisan serve'
php artisan serve

echo '....... finish'
