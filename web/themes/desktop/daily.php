<html>



<?php
	$result = '';
	$lines = file('/var/www/html/openWB/openwb.conf');
	foreach($lines as $line) {
		if(strpos($line, "grapham=") !== false) {
			list(, $graphamold) = explode("=", $line);
		}
		if(strpos($line, "graphinteractiveam=") !== false) {
			list(, $graphinteractiveamold) = explode("=", $line);
		}

		if(strpos($line, "lastmanagement=") !== false) {
			list(, $lastmanagementold) = explode("=", $line);
		}
		if(strpos($line, "lastmanagements2=") !== false) {
			list(, $lastmanagements2old) = explode("=", $line);
		}
		if(strpos($line, "verbraucher1_name=") !== false) {
			list(, $verbraucher1_nameold) = explode("=", $line);
		}
		if(strpos($line, "verbraucher2_name=") !== false) {
			list(, $verbraucher2_nameold) = explode("=", $line);
		}
		if(strpos($line, "verbraucher3_name=") !== false) {
			list(, $verbraucher3_nameold) = explode("=", $line);
		}



	}
	$speichervorhanden = file_get_contents('/var/www/html/openWB/ramdisk/speichervorhanden');
	$soc1vorhanden = file_get_contents('/var/www/html/openWB/ramdisk/soc1vorhanden');
	$verbraucher1vorhanden = file_get_contents('/var/www/html/openWB/ramdisk/verbraucher1vorhanden');
	$verbraucher2vorhanden = file_get_contents('/var/www/html/openWB/ramdisk/verbraucher2vorhanden');
	$verbraucher3vorhanden = file_get_contents('/var/www/html/openWB/ramdisk/verbraucher3vorhanden');
	$verbraucher1_nameold = trim(preg_replace('/\s+/', ' ', $verbraucher1_nameold));
	$verbraucher2_nameold = trim(preg_replace('/\s+/', ' ', $verbraucher2_nameold));
	$verbraucher3_nameold = trim(preg_replace('/\s+/', ' ', $verbraucher3_nameold));

					?>








<?php
$today = date('Y-m-d');
if (isset($_GET[date])) {
	$daydate = $_GET[date];
	$_SESSION = $daydate;

}
else
{
	$daydate = $today;
	$_SESSION = $daydate;

}
$daybefore = date('Y-m-d',strtotime($daydate . "-1 days"));
$nextday = date('Y-m-d',strtotime($daydate . "+1 days"));
?>
	
<script>
	// which graphs needed

	var lastmanagements2 = <?php echo $lastmanagements2old ?>;
	var lastmanagement = <?php echo $lastmanagementold ?>;
	var soc1vorhanden = <?php echo $soc1vorhanden ?>;
	var speichervorhanden = <?php echo $speichervorhanden ?>;
	var graphinteractiveam = <?php echo $graphinteractiveamold ?>;
	var verbraucher1vorhanden = <?php echo $verbraucher1vorhanden ?>;
	var verbraucher1name = "Import: <?php echo $verbraucher1_nameold ?>";
	var verbrauchere1name = "Export: <?php echo $verbraucher1_nameold ?>";
	var verbraucher2vorhanden = <?php echo $verbraucher2vorhanden ?>;
	var verbraucher2name = "Import: <?php echo $verbraucher2_nameold ?>";
	var verbrauchere2name = "Export: <?php echo $verbraucher2_nameold ?>";
	var verbraucher3vorhanden = <?php echo $verbraucher3vorhanden ?>;
	var verbraucher3name = "<?php echo $verbraucher3_nameold ?>";

if ( graphinteractiveam == 1 ){
	am4core.useTheme(am4themes_animated);
}
// Create chart instance
var chart = am4core.create("dailydiv", am4charts.XYChart);
 chart.numberFormatter.numberFormat = "#.## a";
// Set up data source
chart.dataSource.url = "/openWB/web/logging/graph-dailye.php?thedate=<?php echo $daydate ?>";
chart.dataSource.parser = new am4core.CSVParser();
chart.dataSource.parser.options.useColumnNames = false;
//
// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "col0";

// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Wh";

valueAxis.adapter.add("getTooltipText", (text) => {
if (text.includes("k")) {
	text = text.substring(0, text.length -1);
	text = text * 12 * 1000;
	text = Math.round(text);
	text = text +"W";
} else {
	text = text * 12 + "W";
}

return text;
});


var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis2.renderer.opposite = true;
valueAxis2.title.text = "% SoC";
valueAxis2.renderer.grid.template.disabled = true;
// Creaite series
var series1 = chart.series.push(new am4charts.LineSeries());
series1.dataFields.valueY = "col1";
series1.dataFields.categoryX = "col0";
series1.name = "Bezug";
series1.fill = am4core.color("#ff0000");
series1.stroke = am4core.color("#ff0000");
series1.strokeWidth = 3;
series1.tensionX = 0.8;
series1.tensionY = 0.8;
series1.strokeWidth = 1.5;
series1.fillOpacity = 0.3;

var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "col3";
series2.dataFields.categoryX = "col0";
series2.name = "LL Gesamt";
series2.stroke = am4core.color("#4074c9");
series2.tensionX = 0.8;
series2.tensionY = 0.8;
series2.strokeWidth = 1.5;
series2.fill = am4core.color("#4074c9");
series2.fillOpacity = 0.3;

var series4 = chart.series.push(new am4charts.LineSeries());
series4.dataFields.valueY = "col4";
series4.dataFields.categoryX = "col0";
series4.name = "PV";
series4.stroke = am4core.color("#00ff00");
series4.tensionX = 0.8;
series4.tensionY = 0.8;
series4.strokeWidth = 1.5;
series4.fill = am4core.color("#00ff00");
series4.fillOpacity = 0.3;

var series9 = chart.series.push(new am4charts.LineSeries());
series9.dataFields.valueY = "col2";
series9.dataFields.categoryX = "col0";
series9.name = "Einspeisung";
series9.stroke = am4core.color("#fff600");
series9.tensionX = 0.8;
series9.tensionY = 0.8;
series9.strokeWidth = 1.5;
series9.fill = am4core.color("#fff600");
series9.fillOpacity = 0.3;

if (speichervorhanden == 1) {
var series11 = chart.series.push(new am4charts.LineSeries());
series11.dataFields.valueY = "col5";
series11.dataFields.categoryX = "col0";
series11.name = "Speicherladung";
series11.stroke = am4core.color("#fcbe1e");
series11.fill = am4core.color("#fcbe1e");
series11.fillOpacity = 0.3;
series11.tensionX = 0.8;
series11.tensionY = 0.8;
series11.strokeWidth = 1.5;
var series3 = chart.series.push(new am4charts.LineSeries());
series3.dataFields.valueY = "col6";
series3.dataFields.categoryX = "col0";
series3.name = "Speicherentladung";
series3.stroke = am4core.color("#fc6f1e");
series3.fill = am4core.color("#fc6f1e");
series3.fillOpacity = 0.3;
series3.tensionX = 0.8;
series3.tensionY = 0.8;
series3.strokeWidth = 1.5;
var series12 = chart.series.push(new am4charts.LineSeries());
series12.dataFields.valueY = "col12";
series12.dataFields.categoryX = "col0";
series12.name = "Speicher SoC";
series12.stroke = am4core.color("#fc6f1e");
series12.strokeWidth = 1.5;
series12.yAxis = valueAxis2;
series11.legendSettings.valueText = "{valueY.sum}Wh";
series3.legendSettings.valueText = "{valueY.sum}Wh";



}
var series5 = chart.series.push(new am4charts.LineSeries());
series5.dataFields.valueY = "col7";
series5.dataFields.categoryX = "col0";
series5.name = "LP 1";
series5.stroke = am4core.color("#845EC2");
series5.tensionX = 0.8;
series5.tensionY = 0.8;
series5.strokeWidth = 1.5;
if ( lastmanagement == 1) {
var series6 = chart.series.push(new am4charts.LineSeries());
series6.dataFields.valueY = "col8";
series6.dataFields.categoryX = "col0";
series6.name = "LP 2";
series6.stroke = am4core.color("#aa5ec2");
series6.tensionX = 0.8;
series6.tensionY = 0.8;
series6.strokeWidth = 1.5;
series6.legendSettings.valueText = "{valueY.sum}Wh";

}
if ( lastmanagements2 == 1) {
var series30 = chart.series.push(new am4charts.LineSeries());
series30.dataFields.valueY = "col11";
series30.dataFields.categoryX = "col0";
series30.name = "LP 3";
series30.stroke = am4core.color("#aa5ec2");
series30.tensionX = 0.8;
series30.tensionY = 0.8;
series30.strokeWidth = 1.5;

}
if ( verbraucher1vorhanden == 1) {
var series31 = chart.series.push(new am4charts.LineSeries());
series31.dataFields.valueY = "col13";
series31.dataFields.categoryX = "col0";
series31.name = verbraucher1name ;
series31.stroke = am4core.color("#bb5ec2");
series31.tensionX = 0.8;
series31.tensionY = 0.8;
series31.strokeWidth = 1.5;
series31.legendSettings.valueText = "{valueY.sum}Wh";
var series41 = chart.series.push(new am4charts.LineSeries());
series41.dataFields.valueY = "col14";
series41.dataFields.categoryX = "col0";
series41.name = verbrauchere1name ;
series41.stroke = am4core.color("#e01036");
series41.tensionX = 0.8;
series41.tensionY = 0.8;
series41.strokeWidth = 1.5;
series41.legendSettings.valueText = "{valueY.sum}Wh";
}
if ( verbraucher2vorhanden == 1) {
var series32 = chart.series.push(new am4charts.LineSeries());
series32.dataFields.valueY = "col15";
series32.dataFields.categoryX = "col0";
series32.name = verbraucher2name ;
series32.stroke = am4core.color("#fb5ec2");
series32.tensionX = 0.8;
series32.tensionY = 0.8;
series32.strokeWidth = 1.5;
series32.legendSettings.valueText = "{valueY.sum}Wh";
var series52 = chart.series.push(new am4charts.LineSeries());
series52.dataFields.valueY = "col16";
series52.dataFields.categoryX = "col0";
series52.name = verbrauchere2name ;
series52.stroke = am4core.color("#fb5ec2");
series52.tensionX = 0.8;
series52.tensionY = 0.8;
series52.strokeWidth = 1.5;
series52.legendSettings.valueText = "{valueY.sum}Wh";
}
if ( verbraucher3vorhanden == 1) {
var series33 = chart.series.push(new am4charts.LineSeries());
series33.dataFields.valueY = "col16";
series33.dataFields.categoryX = "col0";
series33.name = verbraucher3name ;
series33.stroke = am4core.color("#ebeec2");
series33.tensionX = 0.8;
series33.tensionY = 0.8;
series33.strokeWidth = 1.5;
series33.legendSettings.valueText = "{valueY.sum}Wh";

}
var series8 = chart.series.push(new am4charts.LineSeries());
series8.dataFields.valueY = "col9";
series8.dataFields.categoryX = "col0";
series8.name = "Lp1 SoC";
series8.stroke = am4core.color("#845EC2");
//series8.tensionX = 0.8;
//series8.tensionY = 0.8;
series8.strokeWidth = 1.5;
series8.yAxis = valueAxis2;


if (soc1vorhanden == 1) {
var series10 = chart.series.push(new am4charts.LineSeries());
series10.dataFields.valueY = "col10";
series10.dataFields.categoryX = "col0";
series10.name = "Lp2 SoC";
series10.stroke = am4core.color("#aa5ec2");
//series9.tensionX = 0.8;
//series9.tensionY = 0.8;
series10.strokeWidth = 1.5;
series10.yAxis = valueAxis2;
}

chart.cursor = new am4charts.XYCursor();
// Add legend

series4.customField = 12;
series1.legendSettings.valueText = "{valueY.sum}Wh";
series4.legendSettings.valueText = "{valueY.sum}Wh";
series2.legendSettings.valueText = "{valueY.sum}Wh";
series9.legendSettings.valueText = "{valueY.sum}Wh";
series5.legendSettings.valueText = "{valueY.sum}Wh";
chart.legend = new am4charts.Legend();
</script>


























</html>
