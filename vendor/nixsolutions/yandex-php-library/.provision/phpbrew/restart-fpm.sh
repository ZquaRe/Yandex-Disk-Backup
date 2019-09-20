#!/bin/bash

export PHPBREW_HOME=/opt/phpbrew
export PHPBREW_ROOT=/opt/phpbrew
source /opt/phpbrew/bashrc

# Hardcoded php version, not sure how to do better
phpbrew use '5.5.30'

phpbrew fpm restart