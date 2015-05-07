<?php
include('db_connect.php');
$device="2015A001";
$type="Complete";
$query="select * from events_raw where device='".$device."' and type='".$type."'";
echo $query;
$result = mysql_query($query);
$num=mysql_num_rows($result);
while($row= mysql_fetch_assoc($result)){
	echo "<br>ID: ".$row['id']." Time: ".$row['time']." Code: ".$row['code'];
}
