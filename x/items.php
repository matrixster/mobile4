<?php
session_start();
require_once('../p/config.php');
//require_once('../p/w_init.php');

$uid=1;

  if(isset($_GET['inf'])){ //GETTING THE DATA FROM THE CLIENT SIDE
	$_SESSION['data']=$_GET['inf'];
}
		
	$_SESSION['type']=$type;

	$data=$_SESSION['data'];
	//$data=htmlentities($data);
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
	$category=$fieldvaluefinal[1];
	//ITEM TABLE
	$item_code=$fieldvaluefinal[2];
	$price=$fieldvaluefinal[3];
	$commision= $fieldvaluefinal[4];



if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
		$did=$_GET['delid'];
		$sqldl='UPDATE  item SET 
				    ActiveInd=0,
					ModBy="'.date('Y-m-d H:i:s').'",
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE  Item_ID='.$did;
	
					$resdl = mysql_query ($sqldl);
	
}
	$type=$_GET['type'];
	if($type==-1)
		{
		
		$sqlc='INSERT INTO item (Description,Item_Code, Price, Commission,Item_Category_ID,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES ("'.addslashes($item).'",
					"'.addslashes($item_code).'", '.floatval($price).', '.floatval($commision).', '.intval($category).', 1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
		
		$resc = mysql_query ($sqlc);
		}
	
if($type!=-1)
	{
			$sqlu='UPDATE  item  SET 
			Description="'.addslashes($item).'",
			Item_Code="'.addslashes($item_code).'",
			Price='.floatval($price).',
			Commission="'.floatval($commision).'",
			Item_Category_ID="'.intval($category).'",
			ActiveInd=1,
			ModBy='.$uid.',
			ModDt="'.date('Y-m-d H:i:s').'"
			WHERE Item_ID='.$type;
			$resu = mysql_query ($sqlu);
		
	
}
$res = mysql_query ($sql);



//XML DATA STARTS HERE	

error_reporting(E_ALL ^ E_NOTICE);

//include db connection settings
//change this setting according to your environment
//require_once('../p/config.php');

//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 

//start output of data
//echo '<rows id="0">';
//output data from DB as XML
$sql = "SELECT Item_ID,Item_Code,Description,Item_Category,I.Price,Commission,I.Item_Category_ID  FROM item I
LEFT JOIN item_category C ON I.Item_Category_ID = C.Item_Category_ID
LEFT JOIN `user` U ON U.User_ID = I.CreateBy
WHERE I.ActiveInd=1 AND I.Item_Type='S' ORDER BY Item_ID DESC  ";
$res = mysql_query ($sql);

echo '<data>';
	//$i=1;	
if($res){
	$no=3;
	while($row=mysql_fetch_array($res)){
		echo  $_SESSION['query'];
   echo '<item id="'.$row['Item_ID'].'">';
    echo' <product_name>'.$row['Description'].'</product_name>';
   echo' <item_code>'.htmlentities($row['Item_Code']).'</item_code>';
   echo' <category>'.$row['Item_Category'].'</category>';
   echo' <price> '.number_format($row['Price'],2).'</price>';
   echo' <commision> '.$row['Commission'].'</commision>';
    echo' <catid>'.$row['Item_Category_ID'].'</catid>';
	
   echo' </item> '; 
	}
}else{
//error occurs
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}
echo '</data>';
?>
