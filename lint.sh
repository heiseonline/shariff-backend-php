#!/bin/sh
set -eu

files=$(find . -type f -name '*.php' ! -path './vendor/*')

if [ -z "$files" ]; then
    echo 'lint.sh: no PHP files found' >&2
    exit 1
fi

find . -type f -name '*.php' ! -path './vendor/*' -print0 \
    | xargs -0 -I{} sh -c 'php -l -n "$1" >/dev/null || { echo "Syntax error in $1" >&2; exit 255; }' _ {}

echo 'syntax OK'
