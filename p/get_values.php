<?php
		session_start();
		require_once('config.php');
		//require_once('w_init.php');
		if(isset($_POST['type'])){	$type=$_POST['type'];	}
		
		if(isset($_POST['dt'])){
			$dt=$_POST['dt'];
		
			switch($type){
				case 'Purchasesdate':
				$sql='SELECT P.`PO_Date` AS VAL FROM `po` P WHERE P.`PO_ID`='.$dt;
				break;
				case 'Productprice':
				$sql='SELECT `Price`  AS VAL  FROM `item` WHERE Item_ID='.$dt;
				break;
				case 'Salesdate':
				$sql='SELECT S.`SO_Date` AS VAL FROM `crm_so` S WHERE S.`SO_ID`='.$dt;
				break;
				
				
			}
			
			$res=mysql_query($sql);
			$row=mysql_fetch_array($res);
			echo $row[0];
		
		}
?>
