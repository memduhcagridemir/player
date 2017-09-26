#!/usr/bin/env bash

# configure locale
sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen
sed -i -e 's/# tr_TR.UTF-8 UTF-8/tr_TR.UTF-8 UTF-8/' /etc/locale.gen
echo 'LANG="en_US.UTF-8"'>/etc/default/locale
dpkg-reconfigure --frontend=noninteractive locales
update-locale LANG=en_US.UTF-8

# configure timezone
ln -fs /usr/share/zoneinfo/Europe/Istanbul /etc/localtime
dpkg-reconfigure -f noninteractive tzdata

apt-get update
# apt-get -y upgrade

# optional
sudo apt-get install -y build-essential

sudo apt-get install -y php php-dom php-common php-xml php-curl php-intl php-mysql mysql-server