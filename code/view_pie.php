
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Chart.js demo</title>
   <?php
    $from=$_GET['from'];
  ?>
  <!-- import plugin script -->
  <script src='js/Chart.js'></script>
  
</head>
<body>

<!-- pie chart canvas element -->
<canvas id="countries" style="width:100%;height:300px;position:relative; top:40px;"></canvas>


<script>

  
  // pie chart data
  var pieData = [
    {
      value: <?php echo intval((1440-$from)/14.40);?>,
      color:"#33B776",
      label: "Total On-Time (mins) "
    },
    {
      value: <?php echo intval($from/14.40);?>,
      color: "#d9534f",
      label: "Total Tremor Time (mins)"
    }
   
  ];

  // pie chart options
  var pieOptions = {
    segmentShowStroke : true,
    animateScale : true
  }
  
  // get pie chart canvas
  var countries= document.getElementById("countries").getContext("2d");
  
  // draw pie chart
  new Chart(countries).Pie(pieData, pieOptions);
  
  
</script>

</body>
</html>
