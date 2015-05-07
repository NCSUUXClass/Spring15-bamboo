
<?php
session_start();
include('db_connect.php');
$query="select * from post order by count desc";
$result=mysql_query($query);
echo "<h2>Top posts:</h2>";
while($row=mysql_fetch_array($result)){
	echo '<div class=" bs-callout bs-callout-info" >';
	echo "<h5 align='right'>by <b>".$row['nickname']." </b> on <b>".$row['timestamp']."</b></h5><p>".$row['description']."</p><h5 align='right'><b>Points: ".$row['count']."</b><br><br>";
	echo "<button onclick='upvote(".$row['post_id'].")' class='btn btn-default'>+1</button>&nbsp;&nbsp;&nbsp;<button onclick='downvote(".$row['post_id'].")' class='btn btn-default'>-1</button></h5>";
	echo "</div>";
}
?>
