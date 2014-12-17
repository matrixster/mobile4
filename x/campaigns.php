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
			$sql =' SELECT *, U.Org_ID As OrgID, CT.Type As CampType FROM crm_campaign P
			LEFT JOIN campaign_type CT ON P.Type = CT.Type_ID
			LEFT JOIN user U ON P.CreateBy = U.User_ID
			LEFT JOIN organization O ON U.Org_ID = O.Org_ID
			WHERE P.Campaign_ID='.$id.' AND P.ActiveInd=1';
			$res = mysql_query ($sql);
			echo '<data>';
			if($id!=-1){
					if($res){
					 while($row=mysql_fetch_array($res)){
					   echo '<item id="'.intval($row['Campaign_ID']).'">';
					   echo'<rid>'.intval($row['Campaign_ID']).'</rid>';
					   echo' <cname>'.htmlentities($row['Campaign_Name']).'</cname>';
					   echo' <venue>'.htmlentities($row['Venue']).'</venue>';
					   echo' <sdate>'.$row['Start_Date'].'</sdate>';
					   echo' <edate>'.$row['End_Date'].'</edate>';
					   echo' <status>'.$row['Status'].'</status>';
					   echo' <memo>'.$row['Descr'].'</memo>';
					   echo' </item> '; 
						}
					}else{
						echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
					}
			}else{
				//DEFAULT VALUES
				
				  echo '<item id="-1">';
				   echo'<rid>-1</rid>';
				   echo' <cname></cname>';
				   echo' <venue></venue>';
				   echo' <sdate>'.date('Y-m-d').'</sdate>';
				   echo' <edate>'.date('Y-m-d').'</edate>';
				   echo' <status>Open</status>';
				   echo' <memo></memo>';
				   echo' </item> '; 
				
				
			}
			echo '</data>';
?>
