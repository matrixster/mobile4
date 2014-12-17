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
				$item=$fieldvaluefinal[0];
				$price=$fieldvaluefinal[1];
				//OPPORTUNITY TABLE
				$quantity=$fieldvaluefinal[2];
				$amount= $fieldvaluefinal[3];
				$memo= $fieldvaluefinal[4];
			
		if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
				$did=$_GET['delid'];
				$sqldl='UPDATE po_dtl SET
							ActiveInd=0,
							ModBy='.$uid.',
							ModDt="'.date('Y-m-d H:i:s').'"
							WHERE  Dtl_ID='.$did;
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
				$sqlc='INSERT INTO po_dtl  (Item, Price, Amount,Qty,Memo,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
							"'.addslashes($item).'", '.floatval($price).', '.intval($quantity).', '.floatval($amount).',"'.addslashes($memo).'", 1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
				$resc = mysql_query ($sqlc);
				}
			
		if($type!=-1)
			{
					$sqlu='UPDATE  po_dtl SET 
					Item="'.addslashes($item).'",
					Price='.floatval($price).',
					Amount='.floatval($amount).',
					Qty='.intval($quantity).',
					Memo="'.addslashes($memo).'",
					ActiveInd=1,
					ModBy='.$uid.',
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE Dtl_ID='.$type;
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
//require_once('config.php');
//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 

//start output of data
//echo '<rows id="0">';
//output data from DB as XML
$sql = "SELECT `Dtl_ID`,`Item`,`Price`,`Amount`,`Qty`,`Memo` FROM `po_dtl` WHERE `ActiveInd`=1 ORDER BY Dtl_ID DESC LIMIT 0,20";
$res = mysql_query ($sql);

echo '<data>';
	//$i=1;	
if($res){
	while($row=mysql_fetch_array($res)){
 echo '<item id="'.$row['Dtl_ID'].'">';
 echo $sqlu;
  echo' <item>'.htmlentities($row['Item']).'</item>';
  echo' <price>'.number_format($row['Price'],2).'</price>';
   echo' <qty> '.$row['Qty'].'</qty>';
  echo' <amount> '.number_format($row['Amount'],2).'</amount>';
    echo' <memo> '.$row['Memo'].'</memo>';

echo' </item> '; 

		
	
	}
}else{
//error occurs
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}

echo '</data>';

//echo '</rows>';









?>
