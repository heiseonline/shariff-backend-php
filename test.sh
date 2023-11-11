#!/bin/sh

vendor/bin/phpcs --standard=PSR12 index.php src/ tests/
vendor/bin/php-cs-fixer fix --verbose --dry-run --diff

export XDEBUG_MODE=coverage
vendor/bin/phpunit --coverage-text -v
