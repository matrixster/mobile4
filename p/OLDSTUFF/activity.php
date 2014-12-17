<?php
		session_start();
		require_once('config.php');
		//require_once('w_init.php');
		$uid=1;
		  if(isset($_GET['dt'])){$dt=$_GET['dt'];
		  $mydt=date("Y-m-d",strtotime(substr($dt,4,11)));
		  }else
		  {
			$mydt= date("Y-m-d"); 
		  }
		 
	
		//XML DATA STARTS HERE	
		error_reporting(E_ALL ^ E_NOTICE);
		//include db connection settings
		//change this setting according to your environment
		//require_once('config.php');
		//include XML Header (as response will be in xml format)
		header("Content-type: text/xml");
		//encoding may be different in your case
		echo('<?xml version="1.0" encoding="utf-8"?>'); 
		$pactname=array();
		$pactamount=array();
		$pactdate=array();
		$pact=array();
		$sact=array();
		$sactname=array();
		$sactamount=array();
		$sactdate=array();
		//AND P.`PO_Date`='.$mydt.'
		$purchsql ='SELECT S.`Supplier_Name`,P.`Supplier_ID`,P.`PO_ID`,P.`PO_Date`,P.`Amount` FROM `po` P
		LEFT JOIN supplier S ON S.`Supplier_ID`=P.`Supplier_ID`
		WHERE P.`ActiveInd`=1 AND P.`PO_Date`="'.$mydt.'" ORDER BY P.`PO_ID` DESC LIMIT 0,20';
		$purchres = mysql_query ($purchsql);
		$i=0;
		if($purchres){
			while($purchrow=mysql_fetch_array($purchres)){
				$pactname[$i]=$purchrow['Supplier_Name'];
				$pactamount[$i]=$purchrow['Amount'];
				$pactdate[$i]=$purchrow['PO_Date'];
				$pact[$i]='Purchase';
				$i++;
			}
		}//AND S.`SO_Date`='.$mydt.' 
		$salesql = 'SELECT S.`SO_ID`,S.`CAccount_ID`,S.`SO_Date`,A.`CName`,S.`Amount` FROM `crm_so` S
		 LEFT JOIN `crm_account` A ON A.`CAccount_ID`=S.`CAccount_ID` 
		WHERE S.`ActiveInd` =1 AND S.`SO_Date`="'.$mydt.'" ORDER BY S.`SO_ID` DESC';
		$saleres = mysql_query ($salesql);
		if($saleres){
			while($salerow=mysql_fetch_array($saleres)){
				$sactname[$i]=$salerow['CName'];
				$sactamount[$i]=$salerow['Amount'];
				$sactdate[$i]=$salerow['SO_Date'];
				$sact[$i]='Sale';
				$i++;
			}
		}
		
			$actname=array();
			$actamount=array();
			$actdate=array();
			$act=array();
			$activity=array();
			$actname=array_merge($pactname,$sactname);
			$actamount=array_merge($pactamount,$sactamount);
			$actdate=array_merge($pactdate,$sactdate);
			$act=array_merge($pact,$sact);
		
			$arraysize=sizeof($actdate);
			for($j=0; $j<$arraysize; $j++)
			{
				$activity[0][$j]=$actname[$j];
				$activity[1][$j]=$actamount[$j];
				$activity[2][$j]=$actdate[$j];
				$activity[3][$j]=$act[$j];
				
			}
			
			array_multisort($activity[0],SORT_ASC, SORT_STRING);
			
			
		echo '<data>';
		$n=0;
		//echo $purchsql.'  '.$salesql; 
	
	
			while($n<$arraysize){
			  echo '<item id="'.$n.'">';
			   echo' <actagent>'.htmlentities($activity[0][$n]).'</actagent>';
			   echo' <actamount>'.number_format($activity[1][$n],2).'</actamount>';
			   echo' <actdate> '.$activity[2][$n].'</actdate>';
			   echo' <acttype>'.$activity[3][$n].'</acttype>';
			   echo' </item> '; 
			   $n++;
			}
		echo '</data>';
?>
