<?php
session_start();
		require_once('config.php');
		$uid=1;
		$sql = "SELECT S.`SO_ID`,S.`CAccount_ID`,S.`SO_Date`,A.`CName`,S.`Amount` FROM `crm_so` S
		 LEFT JOIN `crm_account` A ON A.`CAccount_ID`=S.`CAccount_ID` 
		WHERE S.`ActiveInd` =1 ORDER BY S.`SO_ID` DESC  ";
		$res = mysql_query ($sql);
		$no=mysql_num_rows($res);
		echo '[';
		if($res){
			$i=1;
			while($row=mysql_fetch_array($res)){
				echo '{ id:1, sales:20, year:"02"}';
				if($no!=$i){echo ',';}
			}
		}else{
		}
		echo ']';
?>
