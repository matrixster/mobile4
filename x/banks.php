<?php
session_start();
require_once('../p/config.php');
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
	 $fieldvaluef=str_replace('"','',$fieldvalue[1]); 
	 $fieldvaluef=str_replace('{','',$fieldvaluef);
	 $fieldvaluef=str_replace('}','',$fieldvaluef); 
	 $fieldvaluefinal[$j]=$fieldvaluef;
}
$bank=$fieldvaluefinal[0];
$branch=$fieldvaluefinal[1];
$accno=$fieldvaluefinal[2];

if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
	$did=$_GET['delid'];
	$sqldl='UPDATE bank_account SET
			ActiveInd=0,
			ModBy='.$uid.',
			ModDt="'.date('Y-m-d H:i:s').'"
			WHERE  Account_ID='.$did;
			$resdl = mysql_query ($sqldl);
}
$type=$_GET['type'];
if($type==-1)
{ 
	$sqlc='INSERT INTO bank_account (Bank,Account_Name,Account_Number,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
	"'.addslashes($bank).'","'.addslashes($branch).'","'.addslashes($accno).'",1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
	$resc = mysql_query ($sqlc);
} else {
	$sqlu='UPDATE  bank_account SET
	Bank="'.addslashes($bank).'",
	Account_Name="'.addslashes($branch).'", 
	Account_Number="'.addslashes($accno).'",
	ActiveInd=1,
	ModBy='.$uid.',
	ModDt="'.date('Y-m-d H:i:s').'"
	WHERE Account_ID='.$type;
	$resu = mysql_query ($sqlu);
}
$res = mysql_query ($sql);		
//XML DATA STARTS HERE	
error_reporting(E_ALL ^ E_NOTICE);
//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 
//output data from DB as XML
$sql ="SELECT A.Account_ID,A.Bank, A.Account_Name, A.Account_Number
FROM bank_account A
LEFT JOIN `user` U ON A.CreateBy = U.User_ID
WHERE A.ActiveInd=1 ORDER BY Account_ID DESC ";
$res = mysql_query ($sql);
echo '<data>';
if($res){
	while($row=mysql_fetch_array($res)){
	  echo '<item id="'.$row['Account_ID'].'">';
	  echo' <bank> '.$row['Bank'].'</bank>';
	  echo' <branch>'.htmlentities($row['Account_Name']).'</branch>';
	  echo'<accountnumber>'.$row['Account_Number'].'</accountnumber>';
	  echo' </item> '; 
	}
}else{
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}
echo '</data>';
?>
