#!/bin/bash

START=`date +%s`

export DIR="$( cd "$( dirname "$0" )" && pwd )"
export SITE_DOMAIN="yandex-php-library"
export PROVISION_DIR="/var/www/$SITE_DOMAIN"

export PHP_VERSION='5.5.30'

echo "Provision dir: $DIR"

# locale
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8

export DEBIAN_FRONTEND=noninteractive

# colorize
sed -i 's/#force_color_prompt=yes/force_color_prompt=yes/g' /home/vagrant/.bashrc

# For latest nginx 1.8
apt-get purge nginx nginx-common
add-apt-repository ppa:nginx/stable

apt-get update

apt-get -q -y  -o Dpkg::Options::=--force-confnew  install \
    htop \
    git \
    make \
    vim \
    g++ \
    nginx \
    wget \
    mc

apt-get install -y \
    php5-fpm \
    php5 \
    php5-dev \
    php-pear \
    autoconf \
    automake \
    curl \
    build-essential \
    libxslt1-dev \
    re2c \
    libxml2 \
    libxml2-dev \
    php5-cli \
    bison \
    libbz2-dev \
    libreadline-dev

apt-get install -y \
    libssl-dev \
    openssl

apt-get install -y libicu-dev

apt-get install -y \
    libmhash-dev \
    libmhash2

apt-get install -y \
    libmcrypt-dev \
    libmcrypt4

apt-get install -y libcurl4-openssl-dev

wget -O $DIR/phpbrew https://github.com/phpbrew/phpbrew/raw/master/phpbrew
chmod a+x $DIR/phpbrew
mv -v $DIR/phpbrew /usr/bin/phpbrew

chmod +x $PROVISION_DIR/.provision/phpbrew/install.sh
$PROVISION_DIR/.provision/phpbrew/install.sh

cp -v $PROVISION_DIR/.provision/nginx/nginx.conf /etc/nginx/nginx.conf
cp -v $PROVISION_DIR/.provision/nginx/conf.d/* /etc/nginx/conf.d

mkdir -v -p /etc/nginx/sites-available
mkdir -v -p /etc/nginx/sites-enabled
rm /etc/nginx/sites-enabled/default
cp -v $PROVISION_DIR/.provision/nginx/$SITE_DOMAIN.conf /etc/nginx/sites-available/$SITE_DOMAIN
ln -s /etc/nginx/sites-available/$SITE_DOMAIN /etc/nginx/sites-enabled/$SITE_DOMAIN

service nginx restart

# Install composer globaly
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Add github access token to composer config
if [ -f $PROVISION_DIR/.provision/composer/set-github-oauth-token.sh ]
then
    $PROVISION_DIR/.provision/composer/set-github-oauth-token.sh
fi

# Init examples settings if settings file not found
if [ ! -f $PROVISION_DIR/examples/settings.ini ]; then
    cp -v $PROVISION_DIR/examples/settings.example.ini $PROVISION_DIR/examples/settings.ini
fi

# Check versions
echo `lsb_release -a`
echo `nginx -v`
echo `php -v`

echo "Ready to go"

END=`date +%s`

PROVISION_TIME=$((END - START))

echo "Provision took: '$PROVISION_TIME' seconds"
