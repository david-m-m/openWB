<?php
session_start();
$speichervorhanden = file_get_contents('/var/www/html/openWB/ramdisk/speichervorhanden');
$soc1vorhanden = file_get_contents('/var/www/html/openWB/ramdisk/soc1vorhanden');
$lines = file('/var/www/html/openWB/openwb.conf');
foreach($lines as $line) {
	if(strpos($line, "logdailywh=") !== false) {
		list(, $logdailywh) = explode("=", $line);
	}
	if(strpos($line, "logeinspeisungneg=") !== false) {
		list(, $logeinspeisungneg) = explode("=", $line);
	}
}
$daydate1 = $_GET[thedate];
$daydate = date("Ymd", strtotime($daydate1));
$ll1file = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-ll1.csv';
$ll2file = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-ll2.csv';
$ll3file = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-ll3.csv';
$llgfile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-llg.csv';
$pvfile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-pv.csv';
$bezugfile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-bezug.csv';
$einspeisungfile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-einspeisung.csv';
$timefile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-date.csv';
$socfile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-soc.csv';
if ($speichervorhanden == 1) {
	$speicherifile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-speicheriwh.csv';
	$speicherefile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-speicherewh.csv';
	$speicheriwh = file($speicherifile, FILE_IGNORE_NEW_LINES);
	$speicherewh = file($speicherefile, FILE_IGNORE_NEW_LINES);
	$speichersocfile = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-speichersoc.csv';
	$speichersoc = file($speichersocfile, FILE_IGNORE_NEW_LINES);

	$firstsiwh = reset($speicheriwh);
	$lastsiwh = end($speicheriwh);
	$dailysiwh = number_format((($lastsiwh - $firstsiwh) / 1000), 2);
	$firstsewh = reset($speicherewh);
	$lastsewh = end($speicherewh);
	$dailysewh = number_format((($lastsewh - $firstsewh) / 1000), 2);
	$rspeicheriwh = $speicheriwh;
	$rspeicherewh = $speicherewh;

}
if ($soc1vorhanden == 1) {
	$soc1file = '/var/www/html/openWB/web/logging/data/daily/'.$daydate.'-soc1.csv';
	$soc1 = file($soc1file, FILE_IGNORE_NEW_LINES);
}

$bezug = file($bezugfile, FILE_IGNORE_NEW_LINES);
$einspeisung = file($einspeisungfile, FILE_IGNORE_NEW_LINES);
$pv = file($pvfile, FILE_IGNORE_NEW_LINES);
$timef = file($timefile, FILE_IGNORE_NEW_LINES);
$ll1 = file($ll1file, FILE_IGNORE_NEW_LINES);
$ll2 = file($ll2file, FILE_IGNORE_NEW_LINES);
$ll3 = file($ll3file, FILE_IGNORE_NEW_LINES);
$llg = file($llgfile, FILE_IGNORE_NEW_LINES);
$soc = file($socfile, FILE_IGNORE_NEW_LINES);

$firstbezug = reset($bezug);
$lastbezug = end($bezug);
$dailybezug = number_format((($lastbezug - $firstbezug) / 1000), 2);

$firstev = reset($llg);
$lastev = end($llg);
$dailyev = number_format((($lastev - $firstev) / 1000), 2);

$firstpv = reset($pv);
$lastpv = end($pv);
$dailypv = number_format((($lastpv - $firstpv) / 1000), 2);


$firsteinspeisung = reset($einspeisung);
$lasteinspeisung = end($einspeisung);
$dailyeinspeisung = number_format((($lasteinspeisung - $firsteinspeisung) / 1000), 2);

$rll1 = $ll1;
$rll2 = $ll2;
$rll3 = $ll3;
$rllg = $llg;
$rpv = $pv;
$rbezug = $bezug;
$reinspeisung = $einspeisung;

$anzahl = count($timef);

if ($logdailywh == 1) {
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $bezugdiff[$x] = ($rbezug[$x-1] - $rbezug[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $pvdiff[$x] = ($rpv[$x-1] - $rpv[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $einspeisungdiff[$x] = ($reinspeisung[$x-1] - $reinspeisung[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $llgdiff[$x] = ($rllg[$x-1] - $rllg[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $ll1diff[$x] = ($rll1[$x-1] - $rll1[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $ll2diff[$x] = ($rll2[$x-1] - $rll2[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $ll3diff[$x] = ($rll3[$x-1] - $rll3[$x]) * -1;
}
if ($speichervorhanden == 1) {
	for ($x = $anzahl - 1; $x > 0; $x--) {
	    $speicheriwhdiff[$x] = ($rspeicheriwh[$x-1] - $rspeicheriwh[$x]) * -1;
	}
	for ($x = $anzahl - 1; $x > 0; $x--) {
	    $speicherewhdiff[$x] = ($rspeicherewh[$x-1] - $rspeicherewh[$x]) * -1;
	}
}
} else {
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $bezugdiff[$x] = ($rbezug[$x-1] - $rbezug[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $pvdiff[$x] = ($rpv[$x-1] - $rpv[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	if ($logeinspeisungneg == 1) {
	$einspeisungdiff[$x] = $reinspeisung[$x-1] - $reinspeisung[$x];    
	} else {
	$einspeisungdiff[$x] = ($reinspeisung[$x-1] - $reinspeisung[$x]) * -1;
	}
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $llgdiff[$x] = ($rllg[$x-1] - $rllg[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $ll1diff[$x] = ($rll1[$x-1] - $rll1[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $ll2diff[$x] = ($rll2[$x-1] - $rll2[$x]) * -1;
}
for ($x = $anzahl - 1; $x > 0; $x--) {
	    $ll3diff[$x] = $rll3[$x-1] - $rll3[$x] * -1;
}
	for ($x = $anzahl - 1; $x > 0; $x--) {
	    $speicheriwhdiff[$x] = ($rspeicheriwh[$x-1] - $rspeicheriwh[$x]) * -1;
	}
	for ($x = $anzahl - 1; $x > 0; $x--) {
	    $speicherewhdiff[$x] = ($rspeicherewh[$x-1] - $rspeicherewh[$x]) * -1;
	}
}




for ($x = 0; $x < $anzahl; $x++){
	$line = $timef[$x] . "," . $bezugdiff[$x] . "," . $einspeisungdiff[$x] . "," . $llgdiff[$x] . "," . $pvdiff[$x] . "," . $speicheriwhdiff[$x] . "," . $speicherewhdiff[$x] . "," . $ll1diff[$x] . "," . $ll2diff[$x]  . "," . $soc[$x] . "," . $soc1[$x] . "," . $ll3diff[$x]  . "," . $speichersoc[$x] .  PHP_EOL;
	print($line);
}






