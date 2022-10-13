#!/bin/bash

SITES_AVAILABLE_URL=/etc/apache2/sites-available/$1.4rtw.tk.conf

sudo rm $SITES_AVAILABLE_URL
sudo touch $SITES_AVAILABLE_URL

echo "
 <VirtualHost *:80>

    ServerName $1.4rtw.tk

    ProxyPreserveHost On
    ProxyPass / http://127.0.0.1:$2/
    ProxyPassReverse / http://127.0.0.1:$2/

 </VirtualHost>
" > $SITES_AVAILABLE_URL

sudo rm /etc/apache2/sites-enabled/$1.4rtw.tk.conf
sudo ln -s /etc/apache2/sites-available/$1.4rtw.tk.conf /etc/apache2/sites-enabled/$1.4rtw.tk.conf
sudo apachectl configtest
sudo service apache2 restart

echo "Execute this command when ssl is ready to go ->"
echo "sudo certbot -d $1.4rtw.tk"
