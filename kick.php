
<?php
 include('head.php');
 if(isset($_GET['from'])){
    $from=$_GET['from'];
 }
 else{
    $from=$_SESSION['from'];  
 }
 $to=date('Y-m-d', strtotime('+1 day', strtotime($from)));
 $user=$_SESSION['user'];

 $query="SELECT sum(to_seconds(end_time)-to_seconds(start_time))/60 as 'symptom duration' from user_data where start_time>'".$from."' and end_time<'".$to."' and project='".$user."' and code='ST0' group by date(start_time)";
 $result=mysql_query($query);
 $row=mysql_fetch_array($result);
 $total_symptom_duration=$row['symptom duration'];
 $query="select avg(ts.symptom_duration) as symptom from (SELECT sum(to_seconds(end_time)-to_seconds(start_time))/60 as 'symptom_duration' from user_data where project='".$user."' and code='ST0' group by date(start_time)) as ts";
 $result=mysql_query($query);
 $row=mysql_fetch_array($result);
 $average_symptom_duration=$row['symptom'];
    
 ?>
    <div style="position:absolute;color:#fff;font-size:22px;text-align:center;width:100%"><b><?php echo date('l , d F y',strtotime($from));?></b></div>

    <a href="kick.php?from=<?php echo date('Y-m-d', strtotime('-1 day', strtotime($from)));?>"><img src="img/left.png" style="height:35px;position:absolute;left:10px;"></a>
    <a href="kick.php?from=<?php echo date('Y-m-d', strtotime('+1 day', strtotime($from)));?>"><img src="img/right.png" style="height:35px;position:absolute;right:10px;"></a>
    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer" style="height:500px;">
         <iframe scrolling="no" seamless="seamless" style="width:100%;height:100%;border:none;" src="kick_in.php?from=<?php echo $from;?>&to=<?php echo $to;?>"></iframe>
        </header>


        <!-- Title -->

        <!-- Page Features -->
        <div class="row text-center">

            <?php 
            $percent=intval(($total_symptom_duration/$average_symptom_duration)*100);
            if($percent<=100){
                $card_color="good";
                $percent=100-$percent;
            }
            else{
                $card_color="bad";
                $percent=$percent-100;   
            }
            ?>
            <?php include('cards.php');?>
            
        <!-- /.row -->


        <!-- Footer -->
        

    </div>
    <!-- /.container -->
<?
    include('foot.php');
?>