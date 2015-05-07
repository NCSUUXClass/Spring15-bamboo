<?php
include('db_connect.php');
$username=$_POST['user'];
$password=$_POST['password'];
$password=md5($password);
echo $password;
$query="select * from users where project='".$username."' and password_hash='".$password."'";
echo $query;
$result = mysql_query($query);
$num=mysql_num_rows($result);
$row= mysql_fetch_assoc($result);
if($num < 1){
	header('location:login.php');
}
else
{
	session_start();
	$_SESSION['user']=$row['project'];
	$time=getdate();
	$now=$time['year']."-".$time['mon']."-".$time['mday'];
	echo $now;
	$_SESSION['from']=$now;
	$query="select * from profile where project_id='".$_SESSION['user']."'";
	$result = mysql_query($query);
	$row= mysql_fetch_assoc($result);
	$_SESSION['nickname']=$row['nickname'];
	$_SESSION['med1_count']=$row['med1_count'];
	$_SESSION['med2_count']=$row['med2_count'];
	header('location:view.php');
	echo $_SESSION['user'];
}