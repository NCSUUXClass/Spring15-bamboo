<?php
session_start();
include('db_connect.php');
$text=$_POST['post_desc'];
$query='insert into post (description,nickname) values ("'.$text.'","'.$_SESSION["nickname"].'")';
$result=mysql_query($query);
echo $query;
header('location:make_post.php');
?>