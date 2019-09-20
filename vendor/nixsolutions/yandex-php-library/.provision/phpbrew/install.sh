#!/bin/bash

export PHPBREW_HOME=/opt/phpbrew
export PHPBREW_ROOT=/opt/phpbrew

PHP_TIMEZONE="UTC"

phpbrew init

chown -R vagrant:vagrant /opt/phpbrew

source /opt/phpbrew/bashrc

RESULT=`grep -c "phpbrew" /etc/bash.bashrc`
if [ "$RESULT" == "0" ];
then
    cat $PROVISION_DIR/.provision/phpbrew/bashrc.sh >> /etc/bash.bashrc
fi

phpbrew install $PHP_VERSION +default +fpm +curl

sudo sed -i "s/;date.timezone =.*/date.timezone = ${PHP_TIMEZONE}/" /opt/phpbrew/php/php-$PHP_VERSION/etc/php.ini

phpbrew switch php-$PHP_VERSION
phpbrew ext install xdebug stable
phpbrew ext install opcache
phpbrew ext install iconv

phpbrew fpm stop
phpbrew fpm test
sed -i 's/nobody/vagrant/g' /opt/phpbrew/php/php-$PHP_VERSION/etc/php-fpm.conf
phpbrew fpm start