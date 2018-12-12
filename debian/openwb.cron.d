#
# Regular cron jobs for the openwb package
#
# 0 4	* * *	root	[ -x /usr/bin/openwb_maintenance ] && /usr/bin/openwb_maintenance
@reboot root /usr/lib/openwb/runs/atreboot.sh
#
* * * * * root  /usr/lib/openwb/scripts/regel.sh >> /var/log/openWB.log 2>&1 
* * * * * root  sleep 10 && /usr/lib/openwb/scripts/regel.sh >> /var/log/openWB.log 2>&1 
* * * * * root  sleep 20 && /usr/lib/openwb/scripts/regel.sh >> /var/log/openWB.log 2>&1 
* * * * * root  sleep 30 && /usr/lib/openwb/scripts/regel.sh >> /var/log/openWB.log 2>&1 
* * * * * root  sleep 40 && /usr/lib/openwb/scripts/regel.sh >> /var/log/openWB.log 2>&1 
* * * * * root  sleep 50 && /usr/lib/openwb/scripts/regel.sh >> /var/log/openWB.log 2>&1 
