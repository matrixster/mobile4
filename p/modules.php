<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection settings
//change this setting according to your environment
//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="ISO-8859-1" ?>'); 
//start output of data
echo '<data>';
require_once('config.php');
if ($oVIP->sme!=true) {
	//output data from DB as XML
	$sql = "SELECT DISTINCT F.Module_ID, Module FROM form_rights R 
	LEFT JOIN `form` F ON R.Form_ID = F.Form_ID
	LEFT JOIN modules M ON F.Module_ID = M.Module_ID
	WHERE M.ActiveInd=1 AND F.ActiveInd=1 AND F.Menu=1  ORDER By M.Panga";
	$res = mysql_query($sql);
			
	if($res){
		while($row=mysql_fetch_array($res)){
			   echo '<item id="'.$row['Module_ID'].'|'.$row['Module'].'">';
			   echo' <module>'.$row['Module'].'</module>';
			   echo' </item> '; 
}
	}
	
}

echo '</data>';

?>