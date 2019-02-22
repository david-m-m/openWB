#!/bin/bash

# simulated consumption: step function with 0,1kw,2kw for 60 sec each
let timestamp=`date +%s`%180
if (( $timestamp < 60 )); then 
	wattbezug=0
elif (( $timestamp < 120 )); then
	wattbezug=1000
else
	wattbezug=2000
fi 

echo $wattbezug
# 	echo $wattbezug > /var/www/html/openWB/ramdisk/wattbezug
