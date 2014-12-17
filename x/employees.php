<?php
	session_start();
	require_once('../p/config.php');
	//require_once('../p/w_init.php');
	$id=-1;
	if(isset($_GET['id'])){$id=$_GET['id'];}
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
			$sql = 'SELECT *, E.Station_ID as StationID, E.Post_ID as PostID, E.Contract_TypeID as ContractTypeID, X.Dept_ID as DeptID, E.End_ReasonID as EndReasonID, E.Gender as Genderer, E.Start_Date as StartDt, E.End_Date as EndDt, E.PIN_No AS PIN, E.ActiveInd as InActive FROM employee E
LEFT JOIN station S ON S.Station_ID = E.Station_ID
LEFT JOIN post P ON P.Post_ID = E.Post_ID
LEFT JOIN section X ON X.Section_ID = E.Station_ID
LEFT JOIN contract_type C ON C.Contract_TypeID = E.Contract_TypeID
LEFT JOIN end_reason R ON R.End_ReasonID = E.End_ReasonID
LEFT JOIN contact T ON T.Contact_ID = E.Contact_ID
WHERE Employee_ID='.$id;
			$res = mysql_query ($sql);
			echo '<data>';
			if($res){
		
			 while($row=mysql_fetch_array($res)){
			   echo '<item id="'.$row['Employee_ID'].'">';
			   echo' <title>'.htmlentities($row['Title']).'</title>';
			   echo' <othername>'.htmlentities($row['Other_Name']).'</othername>';
			   echo' <surname>'.htmlentities($row['Surname']).'</surname>';
			   echo' <code>'.$row['Employee_Code'].'</code>';
			   echo' <post>'.$row['Post'].'</post>';
			   echo' <tel>'.$row['Tel_1'].'</tel>';
			   echo' <address>'.$row['Address_1'].'</address>';
			   echo' <email>'.$row['Email'].'</email>';
			   echo' <city>'.$row['City'].'</city>';
			   echo' </item> '; 
				}
			}else{
				echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
			}
			
			echo '</data>';
?>
