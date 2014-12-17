<?php
		session_start();
		require_once('../p/config.php');
		$uid=1;
	  	if(isset($_GET['inf'])){ $_SESSION['data']=$_GET['inf'];}
		$_SESSION['type']=$type;
		$data=$_SESSION['data'];
		$fielddata=explode(",",$data);		//FECTCHING THE FIELD VALUE AND REMOVING THE UNWANTED DATA
		for($j=0; $j<(sizeof($fielddata)); $j++)
			{
			  $fieldvalue=explode('":"',$fielddata[$j]);
			  $fieldvaluef=str_replace('"','',$fieldvalue[1]); 
			  $fieldvaluef=str_replace('{','',$fieldvaluef);
			  $fieldvaluef=str_replace('}','',$fieldvaluef); 
			  $fieldvaluefinal[$j]=$fieldvaluef;
			}
			 $supplier=$fieldvaluefinal[0];
			 $contact_person=$fieldvaluefinal[1];
			 $phone= $fieldvaluefinal[2];
			 $email=$fieldvaluefinal[3];
			 $comments=$fieldvaluefinal[4];

		if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
			$did=$_GET['delid'];
			$sqldl='UPDATE  supplier  SET 
						ActiveInd=0,
						ModBy='.$uid.',
						ModDt="'.date('Y-m-d H:i:s').'"
						WHERE  Supplier_ID='.$did;
						$resdl = mysql_query ($sqldl);
		}
		  $type=$_GET['type'];
		 if($type==-1)
			{
				$sqlx='INSERT INTO contact (Tel_1,Email) VALUES("'.addslashes($phone).'", "'.addslashes($email).'")';
				$resx = mysql_query ($sqlx);
				$sqlv='SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1';
				$resv = mysql_query ($sqlv);
				$rowv=mysql_fetch_array($resv);
				$contact_id=$rowv['Contact_ID'];
				$sqlc='INSERT INTO supplier (Supplier_Name,Contact_Person,Comments,Contact_ID,ActiveInd,CreateBy, CreateDt, ModBy, ModDt) VALUES ( "'.addslashes($supplier).'","'.addslashes($contact_person).'","'.addslashes($comments).'",'.intval($contact_id).',1,'.$uid.',"'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
				$resc = mysql_query ($sqlc);
		}
		if($type!=-1)
		{
				$sqlu='UPDATE  supplier  SET 
				Supplier_Name="'.addslashes($supplier).'",
				Contact_Person="'.addslashes($contact_person).'",
				Comments="'.addslashes($comments).'",
				ActiveInd=1,
				ModBy='.$uid.',
				ModDt="'.date('Y-m-d H:i:s').'"
				WHERE Supplier_ID='.$type;
				$resu = mysql_query ($sqlu);
				$sqlus='SELECT Contact_ID from supplier WHERE  Supplier_ID='.$type;
				$resus = mysql_query ($sqlus);
				$rowus=mysql_fetch_array($resus);
				$contact_idn=$rowus['Contact_ID'];
				$sqla='UPDATE contact SET  
				Tel_1="'.addslashes($phone).'",
				Email="'.addslashes($email).'",
				ModBy='.$uid.',
				ModDt="'.date('Y-m-d H:i:s').'"
				WHERE Contact_ID='.$contact_idn;
				$resa = mysql_query ($sqla);
		}
			//XML DATA STARTS HERE	
			error_reporting(E_ALL ^ E_NOTICE);
			//include XML Header (as response will be in xml format)
			header("Content-type: text/xml");
			//encoding may be different in your case
			echo('<?xml version="1.0" encoding="utf-8"?>'); 
			//output data from DB as XML
			$sql = "SELECT Supplier_ID, Supplier_Name, S.Contact_Person,S.Comments, C.Tel_1, C.Email, P.Payterm FROM supplier S 
			LEFT JOIN contact C ON S.Contact_ID = C.Contact_ID
			LEFT JOIN payterm P ON S.Payterm_ID = P.Payterm_ID
			LEFT JOIN `user` U ON S.CreateBy = U.User_ID
			WHERE S.ActiveInd=1  ORDER BY Supplier_ID DESC LIMIT 0,20 ";
			$res = mysql_query ($sql);
			echo '<data>';
			if($res){
				while($row=mysql_fetch_array($res)){
					echo '<item id="'.$row['Supplier_ID'].'">';
					echo' <supplier>'.htmlentities($row['Supplier_Name']).'</supplier>';
					echo' <cperson>'.$row['Contact_Person'].'</cperson>';
					echo' <tel> '.$row['Tel_1'].'</tel>';
					echo' <email> '.$row['Email'].'</email>';
					echo' <comments> '.$row['Comments'].'</comments>';
					echo' <other> '.$sqlu.'</other>';
					echo' </item> '; 
				}
			}else{
				echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
			}
			echo '</data>';
?>
