<script type="text/javascript" src="js/amcharts.js"></script>
<script type="text/javascript" src="js/pie.js"></script>
<script type="text/javascript" src="js/light.js"></script>
<style type="text/css">
#chartdiv {
	width		: 100%;
	height		: 300px;
	font-size	: 11px;
}		
</style>
<?php
    $from=$_GET['from'];
 ?>
<div id="chartdiv"></div>
<script>				
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "pie",
  "theme": "light",
  "legend": {
    "markerType": "circle",
    "position": "bottom",
    "marginRight": 0,
    "autoMargins": true
  },
  "dataProvider": [ {
    "country": "No symptoms (mins)",
    "litres": <?php echo intval((1440-$from));?>
  }, {
    "country": "Total Tremor Time (mins)",
    "litres": <?php echo intval(($from));?>
  } ],
  "valueField": "litres",
  "titleField": "country",
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]mins</b> ([[percents]]%)</span>"
} );
</script>