#!/usr/bin/env bash

echo "correindo composer install"
composer install

echo "creando las migraciones"
php scripts/CrearDatabaseMySQL.php

echo "Todo listo"