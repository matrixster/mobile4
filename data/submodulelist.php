<?php
session_start();
require_once('config.php');
//XML DATA STARTS HERE	
error_reporting(E_ALL ^ E_NOTICE);
//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 
//output data from DB as XML
$sql = "SELECT `Form` FROM `form` WHERE `Module_ID`=0  AND  `Parent_ID`=0  AND
ActiveInd=1 ORDER BY `Panga` ";
$res = mysql_query ($sql);
echo '<data>';
if($res){
		while($row=mysql_fetch_array($res)){
	      // echo '<item id="'.$row['Form'].'">';
	       //echo' <module>'.$row['Form'].'</module>';
 		   $sql1 = "SELECT `Form` FROM `form` WHERE `Module_ID`=0  AND ActiveInd=1 AND Description='".$row['Form']."'  AND Form!='".$row['Form']."'  ORDER BY `Panga` ";
		   $res1 = mysql_query ($sql1);
 /***************PRINTING THE SUB MODULE**********************/
			if($res1){
					 while($row1=mysql_fetch_array($res1)){
							  echo '<item id="'.$row1['Form'].'">';
							  echo' <module>'.$row1['Form'].'</module>';
							  echo' </item> '; 
							}
					}
			//echo' </item> '; 
	}
}else{
	echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}
echo '</data>';
?>
