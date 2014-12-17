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
				$supplierinit=$fieldvaluefinal[0];
				$supplierarray=explode("|",$supplierinit);
				$supplier=$supplierarray[1];
				$mydate=$fieldvaluefinal[1];
				$predate=explode("T",$mydate);
				$mydate=$predate[0];
				//OPPORTUNITY TABLE
				
			
		if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
				$did=$_GET['delid'];
				$sqldl='UPDATE po SET
							ActiveInd=0,
							ModBy='.$uid.',
							ModDt="'.date('Y-m-d H:i:s').'"
							WHERE  PO_ID='.$did;
							$resdl = mysql_query ($sqldl);
			
		}
			$type=$_GET['type'];
			if($type==-1)
				{ 
				
				$sqlc='INSERT INTO po  (Supplier_ID,PO_Date,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
							'.intval($supplier).', "'.addslashes($mydate).'", 1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
							
				
				$resc = mysql_query ($sqlc);
				}
			
		if($type!=-1)
			{
					$sqlu='UPDATE  po SET 
					Supplier_ID='.intval($supplier).',
					PO_Date="'.addslashes($mydate).'",
					ActiveInd=1,
					ModBy='.$uid.',
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE PO_ID='.$type;
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
/*$sql = "SELECT P.`PO_ID`,P.`PO_Date`,S.`Supplier_Name`,SUM(PD.`Amount`) AS TOTAL FROM `po` P
LEFT JOIN supplier S ON S.`Supplier_ID`=P.`Supplier_ID`
LEFT JOIN po_dtl PD ON PD.`PO_ID`=P.`PO_ID`
WHERE P.`ActiveInd`=1 AND PD.`ActiveInd`=1
GROUP BY `PO_ID` ORDER BY P.`PO_ID` DESC LIMIT 0,5";*/
$sql = "SELECT S.`Supplier_Name`,P.`Supplier_ID`,P.`PO_ID`,P.`PO_Date`,P.`Amount` FROM `po` P
LEFT JOIN supplier S ON S.`Supplier_ID`=P.`Supplier_ID`
WHERE P.`ActiveInd`=1 ORDER BY P.`PO_ID` DESC LIMIT 0,20";


$res = mysql_query ($sql);

echo '<data>';
	echo $sqlc;	
if($res){//Supplier_ID
	while($row=mysql_fetch_array($res)){
   echo '<item id="'.$row['PO_ID'].'">';
   echo' <purchasessupplier>SP|'.$row['Supplier_ID'].'</purchasessupplier>';
   echo' <supplier>'.htmlentities($row['Supplier_Name']).'</supplier>';
   echo' <total>'.number_format($row['Amount'],2).'</total>';
   echo' <purchasesdate> '.date('Y-m-d',strtotime($row['PO_Date'])).'</purchasesdate>';
echo' </item> '; 
	}
}else{
//error occurs
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}

echo '</data>';

//echo '</rows>';

?>
