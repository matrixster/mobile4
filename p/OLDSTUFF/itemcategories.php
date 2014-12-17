<?php
		session_start();
		require_once('config.php');
		$uid=1;
		 if(isset($_GET['inf'])){$_SESSION['data']=$_GET['inf'];}
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
			$itemcategory=$fieldvaluefinal[0];
				if(isset($_GET['delid'])){ //GETTING THE DATA FROM THE CLIENT SIDE
				$did=$_GET['delid'];
				$sqldl='UPDATE item_category SET
							ActiveInd=0,
							ModBy='.$uid.',
							ModDt="'.date('Y-m-d H:i:s').'"
							WHERE  Item_Category_ID='.$did;
							$resdl = mysql_query ($sqldl);
		}
		 $type=$_GET['type'];
			  if($type==-1)
				{ 
					$sqlc='INSERT INTO item_category  (Item_Category,ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
								"'.addslashes($itemcategory).'",1, '.$uid.', "'.date('Y-m-d H:i:s').'", '.$uid.', "'.date('Y-m-d H:i:s').'")';
					$resc = mysql_query ($sqlc);
				}
			
		 if($type!=-1)
			{
					$sqlu='UPDATE  item_category SET 
					Item_Category="'.addslashes($itemcategory).'",
					ActiveInd=1,
					ModBy='.$uid.',
					ModDt="'.date('Y-m-d H:i:s').'"
					WHERE Item_Category_ID='.$type;
					$resu = mysql_query ($sqlu);
		}
				
			//XML DATA STARTS HERE	
			error_reporting(E_ALL ^ E_NOTICE);
			//include XML Header (as response will be in xml format)
			header("Content-type: text/xml");
			//encoding may be different in your case
			echo('<?xml version="1.0" encoding="utf-8"?>'); 
			
			//output data from DB as XML
			$sql = "SELECT Item_Category_ID, Item_Category FROM 
			item_category I
			LEFT JOIN item_group G ON I.Item_Group_ID = G.Item_Group_ID
			LEFT JOIN `user` U ON I.CreateBy = U.User_ID
			WHERE I.ActiveInd=1 ORDER BY Item_Category_ID DESC";
			$res = mysql_query ($sql);
			
			echo '<data>';
				//$i=1;	
			if($res){
				while($row=mysql_fetch_array($res)){
					echo '<item id="'.$row['Item_Category_ID'].'">';
					echo' <category>'.htmlentities($row['Item_Category']).'</category>';
					echo' </item> '; 
				}
			}else{
				echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
			}
			echo '</data>';
?>
