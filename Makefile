cs:
	vendor/bin/php-cs-fixer fix --verbose --fixers=-empty_return,-unalign_double_arrow

cs_dry_run:
	vendor/bin/php-cs-fixer fix --verbose --fixers=-empty_return,-unalign_double_arrow --dry-run
