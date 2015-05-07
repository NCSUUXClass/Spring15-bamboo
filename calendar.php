<?php
include('db_connect.php');
session_start();
$user=$_SESSION['user'];
$from=$_GET["from"];
$to=$from+1;
$date_to=$to."-01-01 00:00:00";
$date_from=$from."-01-01 00:00:00";
$query= "SELECT DATE_FORMAT(date(start_time),'%Y-%m-%d')as day,sum(to_seconds(end_time)-to_seconds(start_time))/60 as 'symptom duration' from user_data where start_time>'".$date_from."' and end_time<'".$date_to."' and project='".$user."' and code='ST0' group by date(start_time)";
$result=mysql_query($query);
$myfile = fopen("data.csv", "w");
$txt = "Date,Close\n";
fwrite($myfile, $txt);
while($row=mysql_fetch_array($result)){
  $txt = $row['day'].",".intval($row['symptom duration'])."\n";
  fwrite($myfile, $txt);
}
fclose($myfile);

?>
<!DOCTYPE html>
<meta charset="utf-8">
<html>
  <head>
    <style>

      body {
        font: 1.1em sans-serif;
      }

      #chart{
        width: 800px;
        margin: 0 auto;
      }
      .background {
        fill: #eee;
      }

      line {
        stroke: #fff;
      }

      text.active {
        fill: red;
      }

      .day {
        fill: #fff;
        stroke: #ccc;
      }

      .month {
        fill: none;
        stroke: #fff;
        stroke-width: 4px;
      }
      .year-title {
        font-size: 1.5em;
      }

      /* color ranges */
      .RdYlGn .q0-11{fill:rgb(165,0,38)}
      .RdYlGn .q1-11{fill:rgb(215,48,39)}
      .RdYlGn .q2-11{fill:rgb(244,109,67)}
      .RdYlGn .q3-11{fill:rgb(253,174,97)}
      .RdYlGn .q4-11{fill:rgb(254,224,139)}
      .RdYlGn .q5-11{fill:rgb(255,255,191)}
      .RdYlGn .q6-11{fill:rgb(217,239,139)}
      .RdYlGn .q7-11{fill:rgb(166,217,106)}
      .RdYlGn .q8-11{fill:rgb(102,189,99)}
      .RdYlGn .q9-11{fill:rgb(26,152,80)}
      .RdYlGn .q10-11{fill:rgb(0,104,55)}

      /* hover info */
      #tooltip {
        background-color: #fff;
        border: 2px solid #ccc;
        padding: 10px;
      }

    </style>
  </head>
    <body>

      <div id="chart" class="clearfix"></div>

  <script src="http://d3js.org/d3.v3.js"></script>
  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <script>
    var width = 960,
        height = 750,
        cellSize = 25; // cell size

    var no_months_in_a_row = Math.floor(width / (cellSize * 7 + 50));
    var shift_up = cellSize * 3;

    var day = d3.time.format("%w"), // day of the week
        day_of_month = d3.time.format("%e") // day of the month
        day_of_year = d3.time.format("%j")
        week = d3.time.format("%U"), // week number of the year
        month = d3.time.format("%m"), // month number
        year = d3.time.format("%Y"),
        percent = d3.format(".1%"),
        format = d3.time.format("%Y-%m-%d");

    var color = d3.scale.quantize()
        .domain([600, 300])
        .range(d3.range(11).map(function(d) { return "q" + d + "-11"; }));

    var svg = d3.select("#chart").selectAll("svg")
        .data(d3.range(<?php echo $from;?>, <?php echo $to;?>))
      .enter().append("svg")
        .attr("width", width)
        .attr("height", height)
        .attr("class", "RdYlGn")
      .append("g")

    var rect = svg.selectAll(".day")
        .data(function(d) { 
          return d3.time.days(new Date(d, 0, 1), new Date(d + 1, 0, 1));
        })
      .enter().append("rect")
        .attr("class", "day")
        .attr("width", cellSize)
        .attr("height", cellSize)
        .attr("x", function(d) {
          var month_padding = 1.2 * cellSize*7 * ((month(d)-1) % (no_months_in_a_row));
          return day(d) * cellSize + month_padding; 
        })
        .attr("y", function(d) { 
          var week_diff = week(d) - week(new Date(year(d), month(d)-1, 1) );
          var row_level = Math.ceil(month(d) / (no_months_in_a_row));
          return (week_diff*cellSize) + row_level*cellSize*8 - cellSize/2 - shift_up;
        })
        .datum(format);

    var month_titles = svg.selectAll(".month-title")  // Jan, Feb, Mar and the whatnot
          .data(function(d) { 
            return d3.time.months(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
        .enter().append("text")
          .text(monthTitle)
          .attr("x", function(d, i) {
            var month_padding = 1.2 * cellSize*7* ((month(d)-1) % (no_months_in_a_row));
            return month_padding;
          })
          .attr("y", function(d, i) {
            var week_diff = week(d) - week(new Date(year(d), month(d)-1, 1) );
            var row_level = Math.ceil(month(d) / (no_months_in_a_row));
            return (week_diff*cellSize) + row_level*cellSize*8 - cellSize - shift_up;
          })
          .attr("class", "month-title")
          .attr("d", monthTitle);

    var year_titles = svg.selectAll(".year-title")  // Jan, Feb, Mar and the whatnot
          .data(function(d) { 
            return d3.time.years(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
        .enter().append("text")
          .text(yearTitle)
          .attr("x", function(d, i) { return width/2 - 100; })
          .attr("y", function(d, i) { return cellSize*5.5 - shift_up; })
          .attr("class", "year-title")
          .attr("d", yearTitle);


    //  Tooltip Object
    var tooltip = d3.select("body")
      .append("div").attr("id", "tooltip")
      .style("position", "absolute")
      .style("z-index", "10")
      .style("visibility", "hidden")
      .text("a simple tooltip");

    d3.csv("data.csv", function(error, csv) {
      var data = d3.nest()
        .key(function(d) { return d.Date; })
        .rollup(function(d) { 
          console.log(d[0].Close)
          return (d[0].Close); 
        })
        .map(csv);

      rect.filter(function(d) { return d in data; })
          .attr("class", function(d) { return "day " + color(data[d]); })
        .select("title")
          .text(function(d) { return d + ": " + data[d]; });

      //  Tooltip
      rect.on("mouseover", mouseover);
      rect.on("mouseout", mouseout);
      rect.on("click",qwe);
      function qwe(d) {
        window.top.location.href="view.php?from="+d;
      }
      function mouseover(d) {
        tooltip.style("visibility", "visible");
        var percent_data = (data[d] !== undefined) ? data[d] : 0;
        var purchase_text = d + ": " + percent_data+" mins";

        tooltip.transition()        
                    .duration(200)      
                    .style("opacity", .9);      
        tooltip.html(purchase_text)  
                    .style("left", (d3.event.pageX)+30 + "px")     
                    .style("top", (d3.event.pageY) + "px"); 
      }
      function mouseout (d) {
        tooltip.transition()        
                .duration(500)      
                .style("opacity", 0); 
        var $tooltip = $("#tooltip");
        $tooltip.empty();
      }

    });

    function dayTitle (t0) {
      return t0.toString().split(" ")[2];
    }
    function monthTitle (t0) {
      return t0.toLocaleString("en-us", { month: "long" });
    }
    function yearTitle (t0) {
      return t0.toString().split(" ")[3];
    }
  </script>

  </body>
</html>