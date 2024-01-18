#!/bin/sh
set -ex

find . -type f -name '*.php' ! -path './vendor/*' -exec php -l -n {} \; | (! grep -v "No syntax errors detected" )
echo 'syntax OK'
