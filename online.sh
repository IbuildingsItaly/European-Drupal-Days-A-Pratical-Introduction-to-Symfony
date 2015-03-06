#!/bin/bash
php app/console doctrine:schema:update --dump-sql
php app/console doctrine:schema:update --force
php app/console assets:install
php app/console assetic:dump --env=prod --no-debug
php app/console cache:clear --env=prod --no-debug
composer install --no-dev --optimize-autoloader
