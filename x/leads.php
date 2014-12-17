<?php
	session_start();
	require_once('../p/config.php');
	//require_once('../p/w_init.php');
	$id=-1;
	if(isset($_GET['id'])){$id=$_GET['id'];}
			//XML DATA STARTS HERE	
			error_reporting(E_ALL ^ E_NOTICE);
			//include db connection settings
			//change this setting according to your environment
			//include XML Header (as response will be in xml format)
			header("Content-type: text/xml");
			//encoding may be different in your case
			echo('<?xml version="1.0" encoding="utf-8"?>'); 
			//start output of data
			//output data from DB as XML
			$sql ='SELECT *,L.Lead_ID AS RID, L.Contact_ID AS ContactID, U1.Org_ID AS OrgID, L.Campaign_ID As CampaignID, L.Industry AS Indu, L.Descr AS Cmt, L.`Type` AS IDNo, L.Assigned_To AS Agent 
FROM crm_lead L 
LEFT JOIN contact C ON L.Contact_ID = C.Contact_ID
LEFT JOIN crm_campaign G ON L.Campaign_ID = G.Campaign_ID
LEFT JOIN crm_agent A ON L.Assigned_To = A.Agent_ID
LEFT JOIN user U1 ON L.CreateBy = U1.User_ID 
LEFT JOIN `organization` O ON U1.Org_ID = O.Org_ID
WHERE L.ActiveInd = 1 AND L.Lead_ID='.$id;
			$res = mysql_query ($sql);
			
			echo '<data>';
			if($id!=-1){
					if($res){
					 while($row=mysql_fetch_array($res)){
					   echo '<item id="'.intval($row['RID']).'">';
					   echo' <rid>'.intval($row['RID']).'</rid>';
					   echo' <title>'.$row['Title'].'</title>';
					   echo' <lead>'.htmlentities($row['Last_Name']).'</lead>';
					   echo' <campaign>'.$row['CampaignID'].'</campaign>';
					   echo' <tel>'.$row['Tel_1'].'</tel>';
					   echo' <email>'.$row['Email'].'</email>';
					   echo' <address>'.$row['Address_1'].'</address>';
					   echo' <city>'.$row['City'].'</city>';
					   echo' </item> '; 
					   
					   //COMBO SESSIONS INITIALIZATIONS
					   $_SESSION['leadsCampaignId']=$row['CampaignID'];
						}
					}else{
						echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
					}
			}else{
				//DEFAULT VALUES
				
				  echo '<item id="-1">';
				   echo'<rid>-1</rid>';
			  echo' <lead></code>';
			   echo' <campaign></campaign>';
			   echo' <tel></tel>';
			   echo' <email></email>';
			   echo' <address></address>';
			   echo' <city></city>';
			   echo' </item> '; 
				
				
			}
			echo '</data>';
?>
