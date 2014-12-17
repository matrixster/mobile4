<?php
	session_start();
	require_once('config.php');
	include('queries.php');
	
	if(isset($_GET['id'])){$id=$_GET['id'];}
			//XML DATA STARTS HERE	
			error_reporting(E_ALL ^ E_NOTICE);
			header("Content-type: text/xml");
			echo('<?xml version="1.0" encoding="utf-8"?>'); 
				$sql = getQuery($id);
				$res = mysql_query ($sql);
			echo '<data>';
			if($res){
			 while($row=mysql_fetch_array($res)){
			   echo '<item id="'.$row['ID'].'">';
			   echo' <field1>'.htmlentities($row['field1']).'</field1>';
			   echo' <field2>'.htmlentities($row['field2']).'</field2>';
			   echo' </item> '; 
				}
			}else{
				echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
			}
			
			echo '</data>';
?>
