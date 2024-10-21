#!/bin/bash

sudo chown oem:oem /var/www

composer install
php-fpm --nodaemonize
sleep infinity
