#!/usr/bin/env bash

sudo apt-get -y update
# sudo apt-get install -y python-software-properties
# sudo add-apt-repository -y ppa:ondrej/php5
# sudo apt-get -y update
sudo apt-get install -y apache2
sudo apt-get install -y php5
sudo apt-get install -y libapache2-mod-php5
sudo apt-get install -y vim
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password 123'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 123'
sudo apt-get install -y mysql-server
sudo apt-get install -y php5-mysql
# sudo apt-get -y dist-upgrade
sudo rm -rf /var/www
sudo ln -fs /vagrant/src /var/www
