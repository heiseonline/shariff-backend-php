#!/bin/sh

phpcs --standard=PSR2 src/ tests/
phpunit
