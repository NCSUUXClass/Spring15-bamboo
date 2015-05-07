<?php 
    include('head.php');
     if(isset($_GET['from'])){
    $from=$_GET['from'];
 }
 else{
    $from=date("Y");  

 }

?>
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="move jumbotron " style="padding:10px; width:95%;margin:auto;">
         
        </header>


 <?php
 include('foot.php');
 ?>