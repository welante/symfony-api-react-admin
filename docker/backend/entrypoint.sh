#!/bin/sh
set -e

if [ ! -f "vendor/autoload.php" ]; then
  composer install
fi

exec "$@"
