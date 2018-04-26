Installation Guide

1. log in the system with username "yecuser"

2. update ubuntu

sudo apt-get update -y                    
sudo apt-get upgrade -y

3. install apache2

sudo apt-get install apache2 -y
echo "ServerName 138.197.151.243" >> /etc/apache2/apache2.conf   # add ServerName <domain name> to the /etc/apache2/apache2.conf to supress syntax error warning
                                                                 # <domain name> is the public ip address in this example
																 sudo apache2ctl configtest                                       # optional. check status. expected result "syntax ok"

4. Enable firewall
sudo ufw allow in "Apache Full"
5. install mysql server
apt-get install mysql-server                                     # install mysql server. need to set password during installation
                                                                 # in this example: mysql123!Q@W#E
mysql_secure_installation                                        # enter password set from last step

6. Change the system and database timezone if need (Optional)
6.1 Ubuntu time zone
sudo dpkg-reconfigure tzdata                                     # A GUI program to set ubuntu time zone.
6.2 Database time zone
vim /etc/mysql/mysql.conf.d/mysqld.cnf                           # Open the mysql config file
                                                                 # Add  this line to the file:      default-time-zone='-07:00'
7. Restart the database after configuration finished.                                                                 
systemctl status mysql.service                                   # check the status of mysql server; "active (running)"

8. Install php and some php libraries used in this website
sudo apt-get install php libapache2-mod-php php-mcrypt php-mysql php-gd

8.1  Modify the file /etc/apache2/mods-enabled/dir.conf, set index.php as the first item.
# <IfModule mod_dir.c> 
#    DirectoryIndex index.html index.cgi index.pl index.php index.xhtml index.htm
#</IfModule>

8.2 Change the website root folder to /home/yecuser/html
vim /etc/apache2/sites-available/000-default.conf and add/modify the following configuration:
	DocumentRoot /home/yecuser/html
	<Directory />
		Options FollowSymLinks
		AllowOverride None
	</Directory>
	<Directory /home/yecuser/html>
		Options FollowSymLinks
		AllowOverride None
		Require all granted
	</Directory>
8.3 Restart apach after configuration finished.
sudo systemctl restart apache2 

9.  Install phpadmin (Optional and be cautious to operate database directly)
######### !!! IMPORTANT: !!!###########
# data integrity would be broken by directly operating on the database. Please:
# 1. Make sure you know what the result would be of your operation.
# 2. Shutdown the web server before operating database to avoid new changes made by others.
# 2. Backup the data before you make any change. 
# 3. Restore the data if your changes doesn't work as you expected.  


# instal phpmyadmin to manually operate database (Optional)
sudo apt-get install phpmyadmin php-mbstring php-gettext
sudo phpenmod mcrypt
sudo phpenmod mbstring
sudo ln -s /usr/share/phpmyadmin ~/html/phpmyadmin

# https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04#step-1-install-apache-and-allow-in-firewall 
# https://help.ubuntu.com/lts/serverguide/ftp-server.html

