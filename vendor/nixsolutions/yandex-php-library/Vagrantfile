# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "ubuntu/trusty64"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.provider :virtualbox do |virtualbox|
      # For composer update mostly
      virtualbox.customize ["modifyvm", :id, "--memory", "1024"]
    end

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.synced_folder "./", "/var/www/yandex-php-library/", id: "yandex-php-library", type: nil,
      group: 'vagrant', owner: 'vagrant', mount_options: ["dmode=775", "fmode=764"]

  config.vm.provision "shell", path: ".provision/provision.sh"

  config.vm.provision "shell", path: ".provision/phpbrew/restart-fpm.sh", run: "always"
end
