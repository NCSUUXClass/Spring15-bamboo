	<?php
	include('db_connect.php');
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	$query="select * from events_raw";
	#echo $query;
	$result = mysql_query($query);
	$num=mysql_num_rows($result);
	while($row= mysql_fetch_assoc($result))
	{	
		#echo "<br><br>".$row['code'];
		$code= "select * from `codes` where code='".$row['code']."'";
		$result1 = mysql_query($code);
		$row1=mysql_fetch_assoc($result1);
		if($row1['type']=='M')
		{
			$sql= "insert into user_data(id,device,project,start_time,end_time,code,status) values('".$row['id']."','".$row['device']."','".$row['project']."','".$row['time']."','".$row['time']."'+INTERVAL 5 MINUTE,'".$row['code']."','Med')";
			$result2 = mysql_query($sql);
			#echo "<br>Insert successful";
			#echo "<br><br>true: ".$row1['type'];
		}
		#for symptoms
		else
		{
			$flag=0;
			#if start record
			if(ereg("0$", $row['code']))
			{
				$sql="select * from user_data where status= 'Pending' and project='".$row['project']."' and code='".$row['code']."' ORDER BY id desc";
				$result2=mysql_query($sql);
				#if there are pending records for that symptom
				if($result2)				
				{	$row1=mysql_fetch_assoc($result2);
				#if start_time entry of new record is less than end_time of fetched record, then discard
					if($row['time'] < $row1['end_time'])
					{
						#echo "<br>Discard the row";
						$flag=1;
					}
					else
					{
						#echo "<br>update previous and insert new row";
						$sql="update user_data set status='Completed' where id='".$row1['id']."'";
						$result2=mysql_query($sql);
						$sql="select * from user_data where status='Med' and project ='".$row1['project']."' and start_time between '".$row1['start_time']."' and '".$row1['end_time']."' order by id desc";
					$result3=mysql_query($sql);
					if($medrow=mysql_fetch_assoc($result3))
					{
					 $sql="insert into kickin_time(id,medicine,symptom,project,start_time,end_time) values('".$medrow['id']."','".$medrow['code']."','".$row1['code']."','".$medrow['project']."','".$medrow['start_time']."','".$row1['end_time']."')";
					 mysql_query($sql);
					}
					}
				}
				if($flag==0)
				{
					$sql= "insert into user_data(id,device,project,start_time,end_time,code,status) values('".$row['id']."','".$row['device']."','".$row['project']."','".$row['time']."','".$row['time']."'+INTERVAL 15 MINUTE,'".$row['code']."','Pending')";
					$result2 = mysql_query($sql);
					#echo "<br>Insert successful";
				}
			}
			#if it is an end record
			else
			{ 
				$code_prefix=substr($row['code'],0,-1);
				#echo "<br>".$code_prefix;
				$sql="select * from user_data where status= 'Pending' and project='".$row['project']."' and code like '".$code_prefix."%' ORDER BY id desc";
				$result2=mysql_query($sql);
				#if there are pending records for that symptom
				if($result2)
				{	$row1=mysql_fetch_assoc($result2);
					#echo "<br>update existing status and end_time";
					$sql="update user_data set status='Completed',end_time='".$row['time']."' where id='".$row1['id']."'";
					$result2=mysql_query($sql);
					$sql="select * from user_data where status='Med' and project ='".$row1['project']."' and start_time between '".$row1['start_time']."' and '".$row['time']."' order by id desc";
					$result3=mysql_query($sql);
					if($medrow=mysql_fetch_assoc($result3))
					{
					 $sql="insert into kickin_time(id,medicine,symptom,project,start_time,end_time) values('".$medrow['id']."','".$medrow['code']."','".$row1['code']."','".$medrow['project']."','".$medrow['start_time']."','".$row['time']."')";
					 mysql_query($sql);
					}
					
				}
			}
			
		}
		#echo "<br><br>ID: ".$row['id']." Time: ".$row['time']." Code: ".$row['code'];
	}
$query="insert into archived_events select * from events_raw";
mysql_query($query);
$query="truncate table events_raw";
mysql_query($query);