<?php
				session_start();
				require_once('config.php');
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
				$payterm=$fieldvaluefinal[0];
				if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
				$did=$_GET['delid'];
				$sqldl='UPDATE payterm SET
							ActiveInd=0,
							ModBy='.$uid.',
							ModDt="'.date('Y-m-d H:i:s').'"
							WHERE  Payterm_ID='.$did;
							$resdl = mysql_query ($sqldl);
		}
			$type=$_GET['type'];
			if($type==-1)//"SELECT Payterm_ID, Payterm FROM payterm 
				{ 
				$sqlc='INSERT INTO payterm  (Payterm,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
							"'.addslashes($payterm).'",1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
				$resc = mysql_query ($sqlc);
				}
			
		if($type!=-1)
			{
					$sqlu='UPDATE  payterm SET 
					Payterm="'.addslashes($payterm).'",
					ActiveInd=1,
					ModBy='.$uid.',
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE Payterm_ID='.$type;
					$resu = mysql_query ($sqlu);
		}
				$res = mysql_query ($sql);		
		//XML DATA STARTS HERE	
		error_reporting(E_ALL ^ E_NOTICE);
		//include XML Header (as response will be in xml format)
		header("Content-type: text/xml");
		//encoding may be different in your case
		echo('<?xml version="1.0" encoding="utf-8"?>'); 
		$sql = "SELECT Payterm_ID, Payterm FROM payterm P
		LEFT JOIN `user` U ON P.CreateBy = U.User_ID
		WHERE P.ActiveInd=1 ORDER BY Payterm_ID  DESC";
		$res = mysql_query ($sql);
		echo '<data>';
		if($res){
		while($row=mysql_fetch_array($res)){
		echo '<item id="'.$row['Payterm_ID'].'">';
		echo' <payterms>'.htmlentities($row['Payterm']).'</payterms>';
		echo' </item> '; 
		}
			}else{
		echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
		}
		echo '</data>';

?>
