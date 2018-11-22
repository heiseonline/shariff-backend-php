#!/bin/sh

mkdir -p build
rm -fr build/*
composer require --no-update nyholm/psr7:^1.0
composer require --no-update php-http/guzzle6-adapter:^2.0
composer install --prefer-dist --no-dev
cp index.php build
cp -a vendor build
cp -a src build
composer install
