<?php 
    include('head.php');
     if(isset($_GET['from'])){
    $from=$_GET['from'];
 }
 else{
    $from=date("Y");  

 }

?>
    <a id="prev" href="view_calendar.php?from=<?php echo $from-1;?>"><img src="img/left.png" style="height:35px;position:absolute;left:10px;"></a>
    <a id="next" href="view_calendar.php?from=<?php echo $from+1;?>"><img src="img/right.png" style="height:35px;position:absolute;right:10px;"></a>
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="move jumbotron hero-spacer" style="padding:10px;height:750px; width:95%;margin:auto;">
         <iframe scrolling="no" seamless="seamless" style="width:100%;height:100%;border:none;" src="calendar.php?from=<?php echo $from;?>"></iframe>
        </header>


 <?php
 include('foot.php');
 ?>