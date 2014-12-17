<?php
			 session_start();
			 require_once('config.php');
			 $uid=1;
		 	 if(isset($_GET['inf'])){ 	$_SESSION['data']=$_GET['inf'];}
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
				 $currency=$fieldvaluefinal[0];
				 $symbol=$fieldvaluefinal[1];
				 $rate=$fieldvaluefinal[2];
				if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
					$did=$_GET['delid'];
					$sqldl='UPDATE currency SET
								ActiveInd=0,
								ModBy='.$uid.',
								ModDt="'.date('Y-m-d H:i:s').'"
								WHERE  Currency_ID='.$did;
								$resdl = mysql_query ($sqldl);
					}
			
			$type=$_GET['type'];
			if($type==-1)
				{ 
				$sqlc='INSERT INTO  currency (Currency,Symbol,Rate,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
							"'.addslashes($currency).'","'.addslashes($symbol).'",'.intval($rate).',1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
				$resc = mysql_query ($sqlc);
				}
				
			if($type!=-1)
				{
						$sqlu='UPDATE  currency SET
						Currency="'.addslashes($currency).'",
						Symbol="'.addslashes($symbol).'", 
						Rate='.intval($rate).',
						ActiveInd=1,
						ModBy='.$uid.',
						ModDt="'.date('Y-m-d H:i:s').'"
						WHERE Currency_ID='.$type;
						$resu = mysql_query ($sqlu);
			}
			$res = mysql_query ($sql);		
		//XML DATA STARTS HERE	
		error_reporting(E_ALL ^ E_NOTICE);
		//include XML Header (as response will be in xml format)
		header("Content-type: text/xml");
		//encoding may be different in your case
		echo('<?xml version="1.0" encoding="utf-8"?>'); 
		//start output of data
		//output data from DB as XML
		$sql =" SELECT Currency_ID, Currency, Symbol, Rate 
		FROM currency C 
		LEFT JOIN `user` U ON C.CreateBy = U.User_ID
		WHERE C.ActiveInd=1 ORDER BY Currency_ID DESC ";
		$res = mysql_query ($sql);
		
		echo '<data>';
			//$i=1;	
		if($res){
			while($row=mysql_fetch_array($res)){
		 echo '<item id="'.$row['Currency_ID'].'">';
		 echo' <currency>'.htmlentities($row['Currency']).'</currency>';
		 echo' <symbol> '.$row['Symbol'].'</symbol>';
		 echo'<rate> '.$row['Rate'].'</rate>';
		 echo' </item> '; 
			}
		}else{
			echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
		}
		echo '</data>';
?>
