#!/bin/bash

echo "After Script"
echo "-- Repo Slug: $TRAVIS_REPO_SLUG"
echo "-- Repo Tag: $TRAVIS_TAG"
echo "-- PHP Version: $TRAVIS_PHP_VERSION"
echo "-- PULL Request: $TRAVIS_PULL_REQUEST"

if [ "$TRAVIS_PHP_VERSION" != "7.0" ] && [ "$TRAVIS_PHP_VERSION" != "hhvm" ]; then

    php vendor/bin/coveralls -v
    wget https://scrutinizer-ci.com/ocular.phar
    php ocular.phar code-coverage:upload --format=php-clover .reports/clover.xml

fi

if [ "$TRAVIS_REPO_SLUG" == "nixsolutions/yandex-php-library" ] && [ "$TRAVIS_PULL_REQUEST" == "false" ] && [ "$TRAVIS_PHP_VERSION" == "5.6" ]; then

  composer update --no-dev --no-autoloader
  composer dump-autoload --no-dev
  php phar.php

fi
