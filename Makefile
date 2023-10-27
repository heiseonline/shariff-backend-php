cs:
	vendor/bin/php-cs-fixer fix -vvv

cs_dry_run:
	vendor/bin/php-cs-fixer fix -vvv --dry-run --diff
