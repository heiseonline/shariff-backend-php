#!/bin/sh

mkdir -p build
rm -fr build/*
composer install --prefer-dist --no-dev
cp bin/* build
cp shariff.json build
cp -a vendor build
cp -a src build
composer install
