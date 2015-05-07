
<?php
session_start();
include('db_connect.php');
$id=$_GET['id'];
$query="select * from post where post_id=".$id;
$result=mysql_query($query);
$row=mysql_fetch_array($result);
$count=$row['count']-1;
$query="update post set count=".$count." where post_id=".$id;
$result=mysql_query($query);
echo $query;
?>
