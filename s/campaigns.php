<?php
session_start();
require_once('../p/config.php');
//require_once('../p/w_init.php');
	$uid=1;
	  if(isset($_POST['data'])){$rawdata=$_POST['data'];
		if(isset($_POST['id'])){$type=$_POST['id'];}else{	$type=$data['rid'];}
		$decodeddata = html_entity_decode($rawdata);
		$data = json_decode($decodeddata, true);
		//echo '<pre>', print_r($data), '</pre>';
			$id=$data['rid'];
			$campname=$data['cname'];
			$venue=$data['venue'];
			$sdate=$data['sdate'];
			$edate=$data['edate'];
			$status=$data['status'];
			$memo=$data['memo'];

		}
		


	if($type==-1){
		$sql='INSERT INTO crm_campaign (Campaign_Name,Start_Date,End_Date,Venue,Status,Descr,ActiveInd,ModBy,ModDt) VALUES("'.addslashes($campname).'","'.$sdate.'","'.$edate.'","'.addslashes($venue).'","'.$status.'", "'.$memo.'",1,'.$uid.',"'.date('Y-m-d H:i:s').'")';	
		}else{
			if($type==-5){
					$sql='UPDATE crm_campaign SET  ActiveInd=0,ModBy='.$uid.', ModDt="'.date('Y-m-d H:i:s').'" WHERE Campaign_ID='.$id;
				}else{
			
				$sql='UPDATE crm_campaign SET Campaign_Name="'.addslashes($campname).'", Start_Date="'.$sdate.'", End_Date="'.$edate.'", Venue="'.addslashes($venue).'", Status="'.$status.'",  Descr="'.$memo.'", ModBy='.$uid.', ModDt="'.date('Y-m-d H:i:s').'" WHERE Campaign_ID='.$id;
					}
		}

	$res=mysql_query($sql);

		
		
	if($res && $type!=-5){echo 'Record saved';}else if(!$res && $type!=-5){echo 'Saving failed';}
	if($res && $type==-5){echo 'Record deleted';} else if(!$res && $type==-5){echo 'Deletion failed';}

?>
