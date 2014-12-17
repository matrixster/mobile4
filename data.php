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
$sql = "SELECT I.Item_ID,Item_Code,Description,Item_Category,ReOrder_Level,ReOrder_Units,IFNULL(Items,0) AS Items FROM item I
LEFT JOIN item_category C ON I.Item_Category_ID = C.Item_Category_ID
LEFT JOIN
(
SELECT Item_ID, sum(Qty) AS Items FROM stock_item GROUP BY Item_ID
) T ON T.Item_ID = I.Item_ID
LEFT JOIN `user` U ON U.User_ID = I.CreateBy
WHERE I.ActiveInd=1 AND Item_Type!='S' LIMIT 1,5";
$res = mysql_query ($sql);

echo '<data>';
	//$i=1;	
if($res){
	while($row=mysql_fetch_array($res)){
	

 echo '<item id="'.$row['Item_ID'].'">';
  echo' <itemname>'.$row['Description'].'</itemname>';
  echo' <itemno> '.$row['Items'].'</itemno>';
  echo' <itemcategory> '.$row['Item_Category'].'</itemcategory>';
  echo' <itemcode> '.$row['Item_Code'].'</itemcode>';
  echo' <reorderlevel> '.$row['ReOrder_Level'].'</reorderlevel>';

echo' </item> '; 

		
	
	}
}else{
//error occurs
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}

echo '</data>';

//echo '</rows>';








?>
