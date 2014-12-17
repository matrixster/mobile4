<?php
			require_once('config.php');
			/****************CATEGORY DATA**********************/
			session_start();
			$itemcategory=array();
			$sqlcat = "SELECT `Item_Category_ID`,`Item_Category` FROM `item_category` WHERE ActiveInd=1 LIMIT 1,4 ";
			$rescat = mysql_query($sqlcat);
			if($rescat){
				$i=0;
					$i=0;
					while($rowcat=mysql_fetch_array($rescat)){
						
						
					$itemcategory[$i]['value']=$rowcat['Item_Category_ID'];
					$itemcategory[$i]['label']=$rowcat['Item_Category'];
					$i++;
					
				}
			}
			
			/****************CUSTOMER DATA**********************/
			
			$custid=array();
			$custname=array();
			$sqlcust = "SELECT `CAccount_ID`,`CName` FROM `crm_account` WHERE ActiveInd=1  ";
			$rescust = mysql_query($sqlcust);
			if($rescust){
					$j=0;
					while($rowcust=mysql_fetch_array($rescust)){
					$custid[$j]='C|'.$rowcust['CAccount_ID'];
					$custname[$j]=$rowcust['CName'];
					$j++;
				}
			}

			
			/********************ITEM DATA***********************/
			$itemid=array();
			$itemname=array();
			$sqlitem = "SELECT `Item_ID`,`Description` FROM `item` WHERE ActiveInd=1 ";
			$resitem = mysql_query($sqlitem);
			if($resitem){
					$i=0;
					while($rowitem=mysql_fetch_array($resitem)){
					$itemid[$i]='I|'.$rowitem['Item_ID'];
					$itemname[$i]=htmlentities($rowitem['Description']);
					$salesitemid[$i]='SI|'.$rowitem['Item_ID'];
				$i++;
				}
			}
			
			

			/********************SUPPLIER DATA***********************/
			$suppid=array();
			$suppname=array();
			$sqlsupp = "SELECT `Supplier_ID`,Supplier_Name,Contact_Person FROM `supplier` WHERE `ActiveInd`=1 ";
			$ressupp = mysql_query($sqlsupp);
			if($ressupp){
					$i=0;
					while($rowsupp=mysql_fetch_array($ressupp)){
					$suppid[$i]='SP|'.$rowsupp['Supplier_ID'];
					$suppname[$i]=htmlentities($rowsupp['Contact_Person'],ENT_COMPAT|ENT_QUOTES, "UTF-8");
					$i++;
				}
			}
			
			
			
			
			/********************SUPPLIER DATA***********************/
			$industryid=array();
			$industry=array();
			$sqlind = "SELECT `Industry_ID`,`Industry` FROM `industry` WHERE `ActiveInd`=1";
			$resind = mysql_query($sqlind);
			if($resind){
					$i=0;
					while($rowind=mysql_fetch_array($resind)){
					$industryid[$i]='SP|'.$rowind['Industry_ID'];
					$industry[$i]=htmlentities($rowind['Industry'],ENT_COMPAT|ENT_QUOTES, "UTF-8");
					$i++;
				}
			}
			
			
			
			
			
																	/*$mysize=sizeof($catid);
																	if($mysize>0)
																	{ for($p=0; $p<$mysize; $p++)
																		{
																		 echo '{ value:"'.$catid[$p].'", label:"'.$catname[$p].'" },';
																		}
																}*/
																
			
			//echo  $itemcategory['value'];												
	$jsonval= json_encode($itemcategory);
	$jsonval=str_replace('"value":"','value:',$jsonval);
	$jsonval=str_replace('","label"',',label',$jsonval);
	$jsonval = substr($jsonval, 1, -1);
	$itemcategories=$jsonval;

			

?>	