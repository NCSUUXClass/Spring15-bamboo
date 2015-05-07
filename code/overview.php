<?php include("db_connect.php");?>
<?php
session_start();
$from=$_GET['from'];
$to=$_GET['to'];
$from_time = $from." 00:00:00";
$to_time = $to." 00:00:00";
?>
<!DOCTYPE html>
<html>
<head>
<title>Gantt Chart</title>
<link type="text/css" href="http://mbostock.github.io/d3/style.css" rel="stylesheet" />
<link type="text/css" href="example.css" rel="stylesheet" />
</head>
<body>
     
</body>
</html>
        <script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>
	<?php include('gantt-chart-d3v2.php') ?>
	<?php include('gantt.php') ?>
	<script type="text/javascript" src="example3.js"></script>