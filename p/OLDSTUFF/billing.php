<?php
		session_start();
		require_once('config.php');
		//require_once('w_init.php');
		$uid=1;
		  if(isset($_GET['inf'])){ //GETTING THE DATA FROM THE CLIENT SIDE
			$_SESSION['data']=$_GET['inf'];
		}
			$_SESSION['type']=$type;
			$data=$_SESSION['data'];
			$fielddata=explode('","',$data);		//FECTCHING THE FIELD VALUE AND REMOVING THE UNWANTED DATA
			for($j=0; $j<(sizeof($fielddata)); $j++)
			{
				  $fieldvalue=explode(":",$fielddata[$j]);
				//echo $fieldvalue[1].'<BR/>';
				  $fieldvaluef=str_replace('"','',$fieldvalue[1]); 
				  $fieldvaluef=str_replace('{','',$fieldvaluef);
				  $fieldvaluef=str_replace('}','',$fieldvaluef); 
					//echo $fieldvaluef.'</BR>';
				 $fieldvaluefinal[$j]=$fieldvaluef;
			}
			$customer=$fieldvaluefinal[0];
			$customerinit=$fieldvaluefinal[0];
			$customerarray=explode("|",$customerinit);
			$customer=$customerarray[1];
		
			
			
			$iteminit=$fieldvaluefinal[1];
			$itemarray=explode("|",$iteminit);
			$item=$itemarray[1];
			
			
			//OPPORTUNITY TABLE
			$price=$fieldvaluefinal[2];
			$mydate= $fieldvaluefinal[3];
			$status= $fieldvaluefinal[4];
			
			
		if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
				$did=$_GET['delid'];
				$sqldl='UPDATE   crm_opportunity SET
							ActiveInd=0,
							ModBy='.$uid.',
							ModDt="'.date('Y-m-d H:i:s').'"
							WHERE  Opportunity_ID='.$did;
							$resdl = mysql_query ($sqldl);
			
		}
			$type=$_GET['type'];
			if($type==-1)
				{
				/*$sqlx='INSERT INTO contact (Tel_1,Email) VALUES("'.addslashes($phone).'", "'.addslashes($email).'")';
				$resx = mysql_query ($sqlx);
				
				$sqlv='SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1';
				$resv = mysql_query ($sqlv);
				$rowv=mysql_fetch_array($resv);
				$contact_id=$rowv['Contact_ID'];*/
				//Item_Code,Price,Commission
				$sqlc='INSERT INTO crm_opportunity  (CAccount_ID, Item_ID, Amount,Close_Date,Status,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
							'.intval($customer).', '.intval($item).', '.floatval($price).', "'.$mydate.'","'.addslashes($status).'", 1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
				$resc = mysql_query ($sqlc);
				}
			
		if($type!=-1)
			{
					$sqlu='UPDATE  crm_opportunity SET 
					CAccount_ID='.intval($customer).',
					Item_ID='.intval($item).',
					Amount='.floatval($price).',
					Close_Date="'.$mydate.'",
					Status="'.addslashes($status).'",
					ActiveInd=1,
					ModBy='.$uid.',
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE Opportunity_ID='.$type;
					$resu = mysql_query ($sqlu);
					
				/*	$sqlus='SELECT Contact_ID from supplier WHERE  Supplier_ID='.$type;
					$resus = mysql_query ($sqlus);
					$rowus=mysql_fetch_array($resus);
					$contact_idn=$rowus['Contact_ID'];
					
					$sqla='UPDATE contact SET  
					Tel_1="'.addslashes($phone).'",
					Email="'.addslashes($email).'",
					ModBy="'.date('Y-m-d H:i:s').'",
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE Contact_ID='.$contact_idn;
					$resa = mysql_query ($sqla);*/
					
			
		}
		$res = mysql_query ($sql);
		//XML DATA STARTS HERE	
		
		error_reporting(E_ALL ^ E_NOTICE);
		//include db connection settings
		//change this setting according to your environment
		//include XML Header (as response will be in xml format)
		header("Content-type: text/xml");
		//encoding may be different in your case
		echo('<?xml version="1.0" encoding="utf-8"?>'); 
		
		//start output of data
		//echo '<rows id="0">';
		//output data from DB as XML
		$sql = "SELECT O.CAccount_ID, O.Item_ID,O.Opportunity_ID,A.CName, I.Description, O.Type, O.Close_Date, O.Status, O.Amount 
		FROM crm_opportunity O
		LEFT JOIN crm_account A ON A.CAccount_ID = O.CAccount_ID
		LEFT JOIN item I ON I.Item_ID = O.Item_ID
		LEFT JOIN `user` U ON O.CreateBy = U.User_ID
		WHERE O.ActiveInd=1";
		$res = mysql_query ($sql);
		
		echo '<data>';
			//$i=1;	
		if($res){
			while($row=mysql_fetch_array($res)){
		 echo '<item id="'.$row['Opportunity_ID'].'">';
		  echo' <billingcustid>C|'.$row['CAccount_ID'].'</billingcustid>';
		   echo' <billingprodid>I|'.$row['Item_ID'].'</billingprodid>';
		  echo' <customer>'.htmlentities($row['CName']).'</customer>';
		  echo' <description>'.$row['Description'].'</description>';
		   echo' <close_date> '.$row['Close_Date'].'</close_date>';
		   echo' <amount> '.number_format($row['Amount'],2).'</amount>';
		  echo' <status> '.$row['Status'].'</status>';
		
		echo' </item> '; 
			}
		}else{
		//error occurs
			echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
		}
		echo '</data>';
		//echo '</rows>';
		
		
		?>
