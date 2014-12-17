<?php
	session_start();
	require_once('config.php');
	
			//XML DATA STARTS HERE	
			error_reporting(E_ALL ^ E_NOTICE);
			//include db connection settings
			//change this setting according to your environment
			//include XML Header (as response will be in xml format)
			header("Content-type: text/xml");
			//encoding may be different in your case
			echo('<?xml version="1.0" encoding="utf-8"?>'); 
			//start output of data
			//output data from DB as XML
			$sql = "SELECT E.Employee_ID, E.Surname, E.Other_Name, E.Gender, P.`Post`, D.Dept, E.`Left`,Section,CT.Contract_Type,E.Employee_Code,CT.confirmation_days,	CT.contract_days,E.Start_Date from employee E 
			LEFT JOIN `post` P ON E.Post_ID = P.Post_ID
			LEFT JOIN `dept` D ON E.Dept_ID = D.Dept_ID
			LEFT JOIN `section` S ON E.Station_ID = S.Section_ID
			LEFT JOIN contract_type CT ON CT.`Contract_TypeID`=E.`Contract_TypeID`
			LEFT JOIN `user` U ON E.CreateBy = U.User_ID 
			WHERE E.ActiveInd=1";
			$res = mysql_query ($sql);
			echo '<data>';
			if($res){
			 while($row=mysql_fetch_array($res)){
			   echo '<item id="'.$row['Employee_ID'].'">';
			   echo' <field1>'.$row['Employee_Code'].'</field1>';
			   echo' <field2>'.$row['Other_Name']." ".$row['Surname'].'</field2>';
			   echo' </item> '; 
				}
			}else{
				echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
			}
			
			echo '</data>';
?>
