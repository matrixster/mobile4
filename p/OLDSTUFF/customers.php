<?php
	session_start();
	require_once('config.php');
	//require_once('w_init.php');
	$uid=1;  //DEFAULT USER ID
  if(isset($_GET['inf'])){ //GETTING THE DATA FROM THE CLIENT SIDE
	$data=$_GET['inf'];
	$type=$_GET['type'];
	
	}
	/*$data=htmlentities($data,ENT_NOQUOTES);
	$fieldvaluefinal=json_decode($data);
	$data=substr_replace($data,"[",0,1); 
	$data=strrev($data);
	$data=substr_replace($data,"]",0,1); 
	$data=strrev($data);*/

	
	$_SESSION['type']=$type;
	$_SESSION['data']=$data;
	$fielddata=explode('","',$data);		//FECTCHING THE FIELD VALUE AND REMOVING THE UNWANTED DATA
	for($j=0; $j<(sizeof($fielddata)); $j++)
	{
		
		   $fieldvalue=explode('":"',$fielddata[$j]);
	       $fieldvaluef=str_replace('"','',$fieldvalue[1]); 
		   $fieldvaluef=str_replace('{','',$fieldvaluef);
		   $fieldvaluef=str_replace('}','',$fieldvaluef); 
		   $fieldvaluefinal[$j]=addslashes($fieldvaluef);
		
	}

		$title=$fieldvaluefinal[0];
		$customer=$fieldvaluefinal[1];
		$code= $fieldvaluefinal[2];
		$status=$fieldvaluefinal[3];
		$phone=$fieldvaluefinal[4];
		$email=$fieldvaluefinal[5];
		$box=$fieldvaluefinal[6];
		$town=$fieldvaluefinal[7];

		if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
			$did=$_GET['delid'];
			
			$sqldl='UPDATE  crm_account  SET 
					ActiveInd=0,
					ModBy="'.date('Y-m-d H:i:s').'",
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE CAccount_ID='.$did;
	
		    $resdl = mysql_query ($sqldl);
			
		}

		$type=$_GET['type'];
	if($type==-1)
		{
		$sqlx='INSERT INTO contact (Address_1, City, Email, Tel_1) VALUES("'.addslashes($box).'", "'.addslashes($town).'", "'.addslashes($email).'", "'.addslashes($phone).'")';
		$resx = mysql_query ($sqlx);
		
		$sqlv='SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1';
		$resv = mysql_query ($sqlv);
		$rowv=mysql_fetch_array($resv);
		$contact_id=$rowv['Contact_ID'];
		
		$sqlc='INSERT INTO crm_account (Title,CName,CCode,Status,Contact_ID,ActiveInd,CreateBy, CreateDt, ModBy, ModDt) VALUES ("'.$title.'","'.addslashes($customer).'", "'.addslashes($code).'","'.addslashes($status).'",'.intval($contact_id).',1,'.$uid.',"'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
		
		$resc = mysql_query ($sqlc);
		}
		
if($type!=-1)
	{
			$sqlu='UPDATE  crm_account  SET 
			Title="'.addslashes($title).'",
			CName="'.addslashes($customer).'",
			CCode='.addslashes($code).',
			Status="'.addslashes($status).'",
			ActiveInd=1,
			ModBy='.$uid.',
			ModDt="'.date('Y-m-d H:i:s').'"
			WHERE CAccount_ID='.$type;
			$resu = mysql_query ($sqlu);
			
			$sqlus='SELECT Contact_ID from crm_account WHERE  CAccount_ID='.$type;
			$resus = mysql_query ($sqlus);
			$rowus=mysql_fetch_array($resus);
			$contact_idn=$rowus['Contact_ID'];
			
			$sqla='UPDATE contact  
			Address_1="'.addslashes($box).'",
			City="'.addslashes($town).'",
			Email="'.addslashes($email).'",
			Tel_1='.addslashes($phone).',
			ModBy='.$uid.',
			ModDt="'.date('Y-m-d H:i:s').'"
			WHERE Contact_ID='.$contact_idn;
			$resa = mysql_query ($sqla);
}
			$res = mysql_query ($sql);
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
			$sql = "SELECT A.`Title`,A.`CName` AS CustName,A.*,C.* from crm_account A
			LEFT JOIN contact C ON A.Contact_ID = C.Contact_ID
			LEFT JOIN `user` U ON A.CreateBy = U.User_ID
			WHERE A.ActiveInd=1 ORDER BY CAccount_ID DESC  LIMIT 0,20";
			$res = mysql_query ($sql);
			echo '<data>';
			if($res){
			 while($row=mysql_fetch_array($res)){
			   echo '<item id="'.$row['CAccount_ID'].'">';
			   echo' <field1>'.htmlentities($row['CustName']).'</field1>';
			   echo' <field2>'.$row['Tel_1'].'</field2>';
			   echo' </item> '; 
				}
			}else{
				echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
			}
			
			echo '</data>';
?>
