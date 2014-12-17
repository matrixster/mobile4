<?php
session_start();
		require_once('config.php');
		//require_once('w_init.php');
		$uid=1;
		  if(isset($_GET['inf'])){ //GETTING THE DATA FROM THE CLIENT SIDE
			$_SESSION['data']=$_GET['inf'];
		}
				$_SESSION['type']=$type;
				$data=$_SESSION['data'];
				$fielddata=explode('","',$data);		//FECTCHING THE FIELD VALUE AND REMOVING THE UNWANTED DATA
			for($j=0; $j<(sizeof($fielddata)); $j++)
			{
			  $fieldvalue=explode('":"',$fielddata[$j]);
			//echo $fieldvalue[1].'<BR/>';
			  $fieldvaluef=str_replace('"','',$fieldvalue[1]); 
			  $fieldvaluef=str_replace('{','',$fieldvaluef);
			  $fieldvaluef=str_replace('}','',$fieldvaluef); 
				//echo $fieldvaluef.'</BR>';
			 $fieldvaluefinal[$j]=$fieldvaluef;
			}
				
				$customerinit=$fieldvaluefinal[0];
				$customerarray=explode("|",$customerinit);
				
				$customer=$customerarray[1];
				$mydate=$fieldvaluefinal[1];
				$predate=explode("T",$mydate);
				$mydate=$predate[0];
				//OPPORTUNITY TABLE
			
		if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
				$did=$_GET['delid'];
				$sqldl='UPDATE  crm_so SET
							ActiveInd=0,
							ModBy='.$uid.',
							ModDt="'.date('Y-m-d H:i:s').'"
							WHERE  SO_ID='.$did;
							$resdl = mysql_query ($sqldl);
			
		}
			$type=$_GET['type'];
			if($type==-1)
				{ 
				/*$sqlx='INSERT INTO contact (Tel_1,Email) VALUES("'.addslashes($phone).'", "'.addslashes($email).'")';
				$resx = mysql_query ($sqlx);
				
				$sqlv='SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1';
				$resv = mysql_query ($sqlv);
				$rowv=mysql_fetch_array($resv);
				$contact_id=$rowv['Contact_ID'];*/
				//Item_Code,Price,Commission
				
				$sqlc='INSERT INTO  crm_so  (CAccount_ID,SO_Date,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
							'.intval($customer).', "'.addslashes($mydate).'",1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
				$resc = mysql_query ($sqlc);
				}
			
		if($type!=-1)
			{
					$sqlu='UPDATE  crm_so  SET 
					CAccount_ID='.intval($customer).',
					SO_Date="'.addslashes($mydate).'",
					ActiveInd=1,
					ModBy='.$uid.',
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE SO_ID='.$type;
					$resu = mysql_query ($sqlu);
					
				/*	$sqlus='SELECT Contact_ID from supplier WHERE  Supplier_ID='.$type;
					$resus = mysql_query ($sqlus);
					$rowus=mysql_fetch_array($resus);
					$contact_idn=$rowus['Contact_ID'];
					
					$sqla='UPDATE contact SET  
					Tel_1="'.addslashes($phone).'",
					Email="'.addslashes($email).'",
					ModBy="'.date('Y-m-d H:i:s').'",
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE Contact_ID='.$contact_idn;
					$resa = mysql_query ($sqla);*/
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
//echo '<rows id="0">';
//output data from DB as XML
$sql = "SELECT S.`SO_ID`,S.`CAccount_ID`,S.`SO_Date`,A.`CName`,S.`Amount` FROM `crm_so` S
 LEFT JOIN `crm_account` A ON A.`CAccount_ID`=S.`CAccount_ID` 
WHERE S.`ActiveInd` =1 ORDER BY S.`SO_ID` DESC  ";
$res = mysql_query ($sql);

echo '<data>';
echo $sqlc;
if($res){
	while($row=mysql_fetch_array($res)){
   echo '<item id="'.$row['SO_ID'].'">';
    echo' <salescustid>C|'.$row['CAccount_ID'].'</salescustid>';
   echo' <customer>'.htmlentities($row['CName']).'</customer>';
   echo' <amount>'.number_format($row['Amount'],2).'</amount>';
   echo' <receiptdate> '.$row['SO_Date'].'</receiptdate>';
   echo' </item> '; 
	}
}else{
//error occurs
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}

echo '</data>';

//echo '</rows>';








?>
