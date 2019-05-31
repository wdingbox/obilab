

default:
	yum install mysql mysql-server
	/etc/init.d/mysqld restart

#You would be asked for the current root password which is blank to begin with, next you would be asked to set the new root password for the mysql server, after which you would be asked a few Y/n questions, answers to which are not difficult to guess. I chose Y for all of them.


	#mysql_secure_installation
	yum install httpd
	/etc/init.d/httpd restart
	yum install php mod_suphp

	

	yum install php-mysql php-magickwand  php-devel php-gd php-imap php-ldap php-odbc php-pear php-xml php-xmlrpc php-eaccelerator php-magpierss php-mapserver php-mbstring php-mcrypt php-mhash php-mssql php-shout php-snmp php-soap php-tidy curl curl-devel perl-libwww-perl ImageMagick libxml2 libxml2-devel

	#Now to ensure the web server as wel as mysql svr start at boot.
	chkconfig --levels 235 httpd on
	chkconfig --levels 235 mysqld on
	
	yum install phpmyadmin


