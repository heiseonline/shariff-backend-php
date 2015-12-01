#!/bin/sh

phpcs --standard=PSR2 src/ tests/
vendor/bin/phpunit
