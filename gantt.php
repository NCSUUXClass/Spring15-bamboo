<script type="text/javascript">
var tasks = [
<?php
	
	$user=$_SESSION['user'];
	$query="SELECT * FROM user_data WHERE code like 'MS%'and start_time >= '".$from."' and start_time < '".$to."' and project = '".$user."' ORDER BY start_time ASC";
	$result=mysql_query($query);
	if($result === FALSE) { 
    die(mysql_error()); // TODO: better error handling
	}
	$count=mysql_num_rows($result);
	$count1=0;
	while($row=mysql_fetch_array($result)){
		$count1=$count1+1;
		echo '{"startDate":new Date("'.$row["start_time"].'"),"endDate":new Date("'.$row["end_time"].'"),"taskName":"'.$row['description'].'",';
		if($row['code']=="MS1") 	echo '"status":"RUNNING"},';
		if($row['code']=="MS2") 	echo '"status":"KILLED"},';
	}
	$query="SELECT * FROM user_data WHERE start_time >= '".$from."' and start_time < '".$to."' and project = '".$user."' and code = 'ST0' ORDER BY start_time ASC";
	//echo $query;
	$result=mysql_query($query);
	if($result === FALSE) { 
    die(mysql_error()); // TODO: better error handling
	}
	$count=mysql_num_rows($result);
	$count1=0;
	while($row=mysql_fetch_array($result)){
		$count1=$count1+1;
		echo '{"startDate":new Date("'.$row["start_time"].'"),"endDate":new Date("'.$row["end_time"].'"),"taskName":"'.$row['description'].'","status":"FAILED"}';
		if($count>$count1) echo ","	;
	}
?>
];
<?php
$query1="SELECT distinct description FROM user_data WHERE start_time >= '".$from."' and start_time < '".$to."'  and project = '".$user."' order by description";
$result1=mysql_query($query1);
$count=mysql_num_rows($result1);
$i=1;
$comma=",";
?>
var taskNames = [ <?php while($row1=mysql_fetch_array($result1)){ echo "'".$row1['description']."'"; if($i<$count){echo $comma; $i=$i+1;}}?>];

var taskStatus = {
    "SUCCEEDED" : "bar",
    "FAILED" : "bar-failed",
    "RUNNING" : "bar-running",
    "KILLED" : "bar-killed"
};

</script>
<style type="text/css">
text{
	font-size: 20px;
}
</style>