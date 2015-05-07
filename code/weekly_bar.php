<!DOCTYPE HTML>
<?php
session_start();
$user=$_SESSION['user'];
?>
<html>

<head>  
 
  <script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Tremor Durations"    
      },
      animationEnabled: true,
      axisY: {
        title: "Duration(mins)"
      },
      legend: {
        verticalAlign: "bottom",
        horizontalAlign: "center"
      },
      theme: "theme2",
      data: [

      {        
        type: "column",  
        showInLegend: true, 
        legendMarkerColor: "grey",
        legendText: "Date",
        dataPoints: [
        <?php
          $from=$_GET['from'];
          $to=$_GET['to'];
          include('db_connect.php');
          $query= "SELECT DATE_FORMAT(date(start_time),'%d-%b-%y')as day,sum(to_seconds(end_time)-to_seconds(start_time))/60 as 'symptom duration' from user_data where start_time>'".$from."' and end_time<'".$to."' and project='".$user."' and code='ST0' group by date(start_time)";
          $result=mysql_query($query);
          while($row=mysql_fetch_array($result)){
            $txt = "{y: ".$row['symptom duration'].", label: '".$row['day']."'},";
            echo $txt;
          }
        ?>             
        ]
      }   
      ]
    });

    chart.render();
  }
  </script>
  <script type="text/javascript" src="js/canvasjs.min.js"></script>
</head>
  <body>
  <div id="chartContainer" style="height: 100%; width: 100%;">
    </div>
  </body>
</html>
