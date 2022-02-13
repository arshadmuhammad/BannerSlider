# Banner Slider Module for magneto 2


## Requirements
* Magento Community Edition 2.1.x-2.4.x or Magento Enterprise Edition 2.1.x-2.4.x


## Installation 
* Download [ZIP Archive](https://github.com/arshadmuhammad/bannerslider/archive/refs/heads/main.zip)
* Extract files
* In your Magento 2 root directory create folder app/code/Arshad/Slider
* Copy files and folders from archive to that folder
* In command line, using "cd", navigate to your Magento 2 root directory
* Run the commands:
```
php bin/magento module:enable Arshad_Slider
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```
