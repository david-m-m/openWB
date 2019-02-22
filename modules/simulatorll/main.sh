#! /bin/bash

# simulator for EV charging 

. /var/www/html/openWB/openwb.conf

if [[ $lademodus == "3" ]]; then 
    llaktuell=0
else
    # if charging just set target power 
    llaktuell=$llsoll*230
fi

echo $llaktuell > /var/www/html/openWB/ramdisk/llaktuell