#!/bin/sh

vendor/bin/php-cs-fixer fix --verbose --dry-run --diff

XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text -v
