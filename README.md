Summer Research Project

Live site: http://rockhopper.monmouth.edu/~srpsu14/

Test Environment: http://127.0.0.1:4567

MySQL credentials (Test Enviornment): root/123

Contributors: 
* Dr. Cui Yu
* Greg Kilmartin
* Connor Persteezy
* Hubert Chen

To setup development environment:

	Install VirtualBox at https://www.virtualbox.org/wiki/Downloads	
	Install Vagrant at http://www.vagrantup.com/downloads.html
	git clone https://github.com/HubertChen/SRP.git
	vagrant up
	vagrant ssh
	cd /vagrant/config && php database_init.php
	exit
