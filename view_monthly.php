<?php 
;
    include('head.php');
     if(isset($_GET['from'])){
    $to=$_GET['from'];
 }
 else{
    $to=$_SESSION['from'];  

 }
 $from=date('Y-m-d', strtotime('-31 day', strtotime($to)));
  $before=date('Y-m-d', strtotime('-31 day', strtotime($from)));
 $user=$_SESSION['user'];
?>
    <a id="prev" href="view_monthly.php?from=<?php echo date('Y-m-d', strtotime('0 day', strtotime($from)));?>"><img src="img/left.png" style="height:35px;position:absolute;left:10px;"></a>
    <a id="next" href="view_monthly.php?from=<?php echo date('Y-m-d', strtotime('+62 day', strtotime($from)));?>"><img src="img/right.png" style="height:35px;position:absolute;right:10px;"></a>
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="move jumbotron hero-spacer" style="height:500px; padding:10px;">
         <iframe scrolling="no" seamless="seamless" style="width:100%;height:100%;border:none;" src="weekly_bar.php?from=<?php echo $from;?>&to=<?php echo $to;?>"></iframe>
        </header>


  <?php 
             $query="select avg(ts.symptom_duration) as symptom from (SELECT sum(to_seconds(end_time)-to_seconds(start_time))/60 as 'symptom_duration' from user_data where project='".$user."' and code='ST0' and start_time>'".$from."' and end_time<'".$to."' group by date(start_time)) as ts";
             $result=mysql_query($query);
             $row=mysql_fetch_array($result);
             $total_symptom_duration=$row['symptom'];
             $query="select avg(ts.symptom_duration) as symptom from (SELECT sum(to_seconds(end_time)-to_seconds(start_time))/60 as 'symptom_duration' from user_data where project='".$user."' and code='ST0' and start_time>'".$before."' and end_time<'".$from."' group by date(start_time)) as ts";
             $result=mysql_query($query);
             $row=mysql_fetch_array($result);
             $average_symptom_duration=$row['symptom'];
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

       <div class="row text-center">

           <a href="view_monthly.php?from=<?php echo $to?>"><div class="col-md-4  hero-feature <?php echo $card_color; if(strpos($_SERVER['REQUEST_URI'], 'view_monthly.php')!== FALSE) echo " chosen";?> ">
                <div class="thumbnail">
                    
                    <div class="caption">
                        <h3>Average Symptom Duration</h3>
                        <h4>
                         <?php echo intval($total_symptom_duration);?> mins</h4>
                        <h4><?php echo $percent;?> % <?php    
                            if($card_color=="good"){
                                echo "below last 30 days</h4><h4>Great!";
                            }
                            else{ 
                                echo "above last 30 days</h4><h4>Hang in there!";
                            } ?></h4>
                    </div>
                </div>
            </div>
            </a>
           <div class="col-md-4  hero-feature view " style="height:190px;">
                <div class="thumbnail">
                    <div class="caption"><br><br>
                        <h3>Medication Adherence</h3>
                    
                    </div>
                </div>
            </div>
            <a href="#">
            <div class="col-md-4  hero-feature okay <?php if(strpos($_SERVER['REQUEST_URI'], 'notes.php')!== FALSE) echo " chosen";?>" style="height:190px;">
                <div class="thumbnail">
                    
                    <div class="caption"><br><br>
                        <h3>View Notes</h3>
                        
                    </div>
                </div>
            </div>
            </a>
        

    </div>
 <?php
 include('foot.php');
 ?>