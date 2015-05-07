

<a href="view.php?from=<?php echo $from?>"><div class="col-md-4  hero-feature <?php echo $card_color; if(strpos($_SERVER['REQUEST_URI'], 'view.php')!== FALSE) echo " chosen";?> ">
                <div class="thumbnail">
                    
                    <div class="caption">
                        <h3>Total Tremor Duration</h3>
                        <h4>
                         <?php echo intval($total_symptom_duration);?> mins</h4>
                        <h4><?php echo $percent;?> % <?php    
                            if($card_color=="good"){
                                echo "below yesterday</h4><h4>Great!";
                            }
                            else{ 
                                echo "above yesterday</h4><h4>Hang in there!";
                            } ?></h4>
                    </div>
                </div>
            </div>
            </a>
            <div class="col-md-4  hero-feature  <?php if($MS1_count==$_SESSION['med1_count']&&$MS2_count==$_SESSION['med2_count']) echo "good";else echo "bad";?>" style="height:190px;">
                <div class="thumbnail">
                    <div class="caption">
                        <h3 >Medications</h3>
                        <h4>
                            <?php
                                if($MS1_count==$_SESSION['med1_count']&&$MS2_count==$_SESSION['med2_count']){
                                    echo "Great! <br><br>You took all your meds today!";
                                }
                                else{
                                    echo "Whoops!<br><br>";
                                    if($MS1_count<$_SESSION['med1_count']){
                                        echo "You missed ".($_SESSION['med1_count']-$MS1_count)." dose(s) of Medication 1 today!<br>";
                                    }
                                    if($MS2_count<$_SESSION['med2_count']){
                                        echo "You missed ".($_SESSION['med2_count']-$MS2_count)." dose(s) of Medication 2 today!<br>";
                                    }
                                    if($MS1_count>$_SESSION['med1_count']){
                                        echo "You took ".-($_SESSION['med1_count']-$MS1_count)." extra dose(s) of Medication 1 today!<br>";
                                    }
                                    if($MS2_count>$_SESSION['med2_count']){
                                        echo "You took ".-($_SESSION['med2_count']-$MS2_count)." extra dose(s) of Medication 2 today!<br>";
                                    }
                                }
                            ?>
                        </h4>                    
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
            