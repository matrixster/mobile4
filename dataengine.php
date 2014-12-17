<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection settings
//change this setting according to your environment
require_once('config.php');
//require_once('w_init.php');

function add_row($id,$p,$uid){
	global $newId;
	global $r;
	
	switch($id){
	case "Appraisal types":
		$sql = 	"INSERT INTO appraisal_type(Appraisal_Type,ActiveInd,CreateBy,CreateDt) VALUES ('".$_GET["c0"]."',1,".$uid.",'".date("Y-m-d H:i:s")."')";
		break;
?>
