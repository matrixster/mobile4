<?php
session_start();
require_once('config.php');




  if(isset($_GET['inf'])){ //GETTING THE DATA FROM THE CLIENT SIDE
	$_SESSION['data']=$_GET['inf'];
}
		
	$_SESSION['type']=$type;

	$data=$_SESSION['data'];
	$fielddata=explode(",",$data);		//FECTCHING THE FIELD VALUE AND REMOVING THE UNWANTED DATA
	
	
	
	for($j=0; $j<(sizeof($fielddata)); $j++)
	{
		
		$fieldvalue=explode(":",$fielddata[$j]);
		
		//echo $fieldvalue[0].'<BR/>';
		
	     $fieldvaluef=str_replace('"','',$fieldvalue[1]); 
		 $fieldvaluef=str_replace('{','',$fieldvaluef);
		  $fieldvaluef=str_replace('}','',$fieldvaluef); 
 
			//echo $fieldvaluef.'</BR>';

		 $fieldvaluefinal[$j]=$fieldvaluef;
		
	}



$code=$fieldvaluefinal[3];
$desc= $fieldvaluefinal[0];
//$type=$fieldvaluefinal[2];
$level=$fieldvaluefinal[4];
$itemid=$fieldvaluefinal[5];

	
	
	$type=$_GET['type'];
// echo $type;
 
	if($type=="newitem")
		{
		//Item_Category_ID,
		$sql='INSERT INTO item (Item_Code, Description, Item_Type, ReOrder_Level,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
					"'.addslashes($code).'", "'.addslashes($desc).'", '.addslashes($type).', '.intval($level).', 1, '.$id.', "'.date('Y-m-d H:i:s').'", '.$id.', "'.date('Y-m-d H:i:s').'")';
		
		}

//Item_Category_ID='.intval($strC).', 
//Item_Type="'.$type.'",
if($type=='myupdate')
{
	//echo 'This is update!';

			$sql='UPDATE item SET 
			Item_Code="'.addslashes($code).'",
			Description="'.addslashes($desc).'",
			ReOrder_Level='.intval($level).',
			ModBy ='.intval($id).',
			ModDt="'.date('Y-m-d H:i:s').'"
			WHERE Item_ID='.$itemid;
	
}

 
 //echo $sql;

	
$res = mysql_query ($sql);
	
	
	
	
//XML DATA STARTS HERE	
	


error_reporting(E_ALL ^ E_NOTICE);

//include db connection settings
//change this setting according to your environment
//require_once('config.php');
//require_once('w_init.php');

//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 

//start output of data
//echo '<rows id="0">';

//output data from DB as XML
$sql = "SELECT Assignment_ID, Make, AssetModel, U.User, S.Description, StartDate, EndDate, S.Status, Qty_Out FROM assignments S
LEFT JOIN assets A ON S.Asset_ID = A.Asset_ID
LEFT JOIN user U ON U.User_ID = S.User_ID
WHERE S.ActiveInd=1";
$res = mysql_query ($sql);

echo '<data>';
	//$i=1;	
if($res){
	while($row=mysql_fetch_array($res)){
	

 echo '<item id="'.$row['Assignment_ID'].'">';
  echo' <make>'.$row['Make'].'</make>';
  echo' <model> '.$row['AssetModel'].'</model>';
  echo' <assignedto> '.$row['User'].'</assignedto>';
  echo' <description> '.$row['Description'].'</description>';
  echo' <start> '.$row['StartDate'].'</start>';
   echo' <end> '.$row['EndDate'].'</end>';
   echo' <status> '.$row['Status'].'</status>';
   echo' <no> '.$row['Qty_Out'].'</no>';
   

echo' </item> '; 

		
	
	}
}else{
//error occurs
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}

echo '</data>';

//echo '</rows>';








?>
