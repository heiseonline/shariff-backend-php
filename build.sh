#!/bin/sh

mkdir -p build
rm -fr build/*
composer install --no-dev
if [ -d "cleaner" ]; then
  php cleaner/bin/composer-cleaner
else
  composer create-project dg/composer-cleaner cleaner v0.2
  php cleaner/bin/composer-cleaner
fi
cp index.php build
cp shariff.json build
cp -a vendor build
cp -a src build
composer install
