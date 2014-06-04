install:
	sudo apt-get update
	sudo apt-get install lamp-server^
start: 
	sudo /usr/sbin/apache2ctl start
stop:
	sudo /usr/sbin/apache2ctl stop
restart:
	sudo /usr/sbin/apache2ctl restart

