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
$sql = "SELECT ARequisition_ID, C.Asset_Category, U.User, R.Description, R.Start_Date, R.End_Date, R.Status, R.Qty FROM asset_requisition R
	LEFT JOIN asset_category C ON R.Asset_Category_ID = C.Asset_Category_ID
	LEFT JOIN user U ON R.User_ID = U.User_ID
	LEFT JOIN employee E ON E.Employee_ID = U.Employee_ID
	LEFT JOIN post P ON P.Post_ID = E.Post_ID
	LEFT JOIN section S ON S.Section_ID = P.Section_ID
	LEFT JOIN dept D ON D.Dept_ID = S.Section_ID
	WHERE R.ActiveInd=1";
$res = mysql_query ($sql);

echo '<data>';
	//$i=1;	
if($res){
	while($row=mysql_fetch_array($res)){
	

 echo '<item id="'.$row['ARequisition_ID'].'">';
  echo' <itemrid>'.$row['ARequisition_ID'].'</itemrid>';
  echo' <category> '.$row['Asset_Category'].'</category>';
  echo' <desc> '.$row['Description'].'</desc>';
  echo' <status> '.$row['Status'].'</status>';
  echo' <start> '.$row['Start_Date'].'</start>';
  echo' <end> '.$row['End_Date'].'</end>';

echo' </item> '; 

		
	
	}
}else{
//error occurs
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}

echo '</data>';

//echo '</rows>';








?>
