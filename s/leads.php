<?php
session_start();
require_once('../p/config.php');
//require_once('../p/w_init.php');
	$uid=1;
	  if(isset($_POST['data'])){$rawdata=$_POST['data'];
	  
						if(isset($_POST['id'])){$type=$_POST['id'];}else{$type=$data['rid'];}
						$decodeddata = html_entity_decode($rawdata);
						$data = json_decode($decodeddata, true);
				//	Lead_ID 	Title 	First_Name 	Last_Name 	DOB 	Dept 	Biz 	Industry 	Type 	Revenue 	Employees 	Status 	ModDt 	Lead_Source 	Campaign_ID 	Contact_ID 	Assigned_To 	Descr 	CAccount_ID 	ActiveInd 	CreateBy 	CreateDt 	ModBy 		
							$id=$data['rid'];
							$title=$data['title'];
							$lead=$data['lead'];
							$camp=$data['campaigncom'];
							$tel=$data['tel'];
							$email=$data['email'];
							$address=$data['address'];
							$city=$data['city'];
				
						} else
				{echo 'Data not Received.'; exit();}
		

					
						if($type==-1){
							
							$sqlx='INSERT INTO contact (Address_1, City, Email, Tel_1) VALUES("'.addslashes($address).'", "'.addslashes($city).'", "'.addslashes($email).'", "'.addslashes($tel).'")';
							$resx = mysql_query ($sqlx);
							
							$sqlv='SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1';
							$resv = mysql_query ($sqlv);
							$rowv=mysql_fetch_array($resv);
							$contact_id=$rowv['Contact_ID'];
							$sql='INSERT INTO crm_lead (Title,Last_Name,Campaign_ID,Contact_ID,ActiveInd,CreateBy, CreateDt, ModBy, ModDt) VALUES ("'.addslashes($title).'","'.addslashes($lead).'",'.intval($camp).','.intval($contact_id).',1,'.$uid.',"'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
							}else{
								if($type==-5){
										$sql='UPDATE crm_lead SET  ActiveInd=0,ModBy='.$uid.', ModDt="'.date('Y-m-d H:i:s').'" WHERE Lead_ID='.$id;
									}else{
								
								
								$sqlus='SELECT Contact_ID from crm_lead WHERE  Lead_ID ='.$type;
								$resus = mysql_query ($sqlus);
								$rowus=mysql_fetch_array($resus);
								$contact_idn=$rowus['Contact_ID'];
								
								$sqla='UPDATE contact  SET 
								Address_1="'.addslashes($address).'",
								City="'.addslashes($city).'",
								Email="'.addslashes($email).'",
								Tel_1="'.addslashes($tel).'",
								ModBy='.$uid.',
								ModDt="'.date('Y-m-d H:i:s').'"
								WHERE Contact_ID='.$contact_idn;
								$resa = mysql_query ($sqla);				
								
								$sql='UPDATE  crm_lead  SET 
								Title="'.addslashes($title).'",
								Last_Name="'.addslashes($lead).'",
								Campaign_ID='.intval($camp).',
								ActiveInd=1,
								ModBy='.$uid.',
								ModDt="'.date('Y-m-d H:i:s').'"
								WHERE Lead_ID='.$type;
									}
								
								
							}
					
							$res=mysql_query($sql);

						
						//echo $data['lead'];
						//echo $type;	
					
		if($res && $type==-1){echo 'Record saved';}else if(!$res && $type==-1){echo 'Saving failed';}
			if($res && $type!=-1 && $type!=-5){echo 'Record saved';}else if(!$res && $type!=-1 && $type!=-5){echo 'Editing failed';}
			if($res && $type==-5){echo 'Record deleted';} else if(!$res && $type==-5){echo 'Deletion failed';}
			//	
			//echo $sqla;
?>
