<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

//include db connection settings
//change this setting according to your environment
$id=0;
if(isset($_GET['id'])){$id=$_GET['id'];}

//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="ISO-8859-1" ?>'); 
//start output of data
echo '<data>';
require_once('../p/config.php');
//require_once('../x/bin/w_init.php');

$profile=2;
if ($oVIP->sme!=true) {
	//output data from DB as XML
	$sql = "SELECT DISTINCT F.Module_ID, Module FROM form_rights R 
	LEFT JOIN `form` F ON R.Form_ID = F.Form_ID
	LEFT JOIN modules M ON F.Module_ID = M.Module_ID
	WHERE M.ActiveInd=1 AND F.ActiveInd=1 AND F.Module_ID=$id AND F.Menu=1 AND R.Profile_ID=".$profile." ORDER By M.Panga";
	$res = mysql_query($sql);
			
	if($res){
		while($row=mysql_fetch_array($res)){
			$r='';
			$det = '';
			$res1 = mysql_query('SELECT DISTINCT Parent_ID FROM `form` F INNER JOIN form_rights R ON R.Form_ID = F.Form_ID 
					WHERE ActiveInd=1 AND Parent_ID<>0 AND Module_ID='.$row['Module_ID'].' AND Profile_ID='.$profile);
			while($row1=mysql_fetch_array($res1)){
				$r = $r.",".$row1['Parent_ID'];
			}
			$r = substr($r,1,strlen($r)-1);
			if ($r!=""){
				$det = "AND F.Form_ID NOT IN (".$r.")";
			}
			//create xml tag for grid's row//Profile_ID<>0 AND
			//print('<item text="'.$row['Module'].'" id="'.$row['Module_ID'].'|'.$row['Module'].'">');
			$sql3 = "SELECT DISTINCT F.Form_ID, Description AS Form, Alias FROM `form` F
				INNER JOIN form_rights R ON R.Form_ID = F.Form_ID  
				WHERE F.ActiveInd=1 AND Parent_ID=0 AND Profile_ID=".$profile." AND Module_ID=".$row['Module_ID']." 
				".$det." ORDER BY Panga";
				
				$res3 = mysql_query($sql3);
				while($row3=mysql_fetch_array($res3)){
					//print('<item text="'.stripslashes($row3['Form']).'" id="'.$row3['Alias'].'"/>'); //MAIN ITEMS
					
					  echo '<item id="'.$row['Module_ID'].'|'.$row3['Alias'].'|mainitem">';
					   echo' <submodule>'.$row3['Alias'].'</submodule>';
					   echo' </item> '; 
					
					
				}
				$sql1 = "SELECT DISTINCT F.Form_ID, Description AS Form, Alias FROM `form` F 
				WHERE F.ActiveInd=1 AND F.Form_ID 
				IN 
					(".$r.") 
				ORDER BY Panga"; 
				
				$res1 = mysql_query ($sql1);
				while($row1=mysql_fetch_array($res1)){
					//print('<item text="'.stripslashes($row1['Form']).'" id="Z'.$row1['Alias'].'">');
					echo '<item id="'.$row['Module_ID'].'|Z#'.$row1['Alias'].'|headitem">';
					echo' <submodule>'.stripslashes($row1['Form']).'</submodule>';
					
					$sql2 = "SELECT DISTINCT F.Form_ID, Description AS Form, Alias 
						FROM form_rights R
						INNER JOIN `form` F ON R.Form_ID = F.Form_ID AND F.ActiveInd=1 AND Parent_ID=".$row1['Form_ID']."
						WHERE Profile_ID=".$profile."
						ORDER BY F.Panga";
						$res2 = mysql_query ($sql2);
						while($row2=mysql_fetch_array($res2)){
							//print('<item text="'.stripslashes($row2['Form']).'" id="'.$row2['Alias'].'"/>');
							$setpos=-1;
							$rptpos=-1;
							$itemtype="other";
							$setpos=stripos($row1['Alias'],"Setup");
							$rptpos=stripos($row1['Alias'],"Report");
							if($setpos>-1){$itemtype="Setupitem";}
							if($rptpos>-1){$itemtype="Reportitem";}
							
						echo '<item id="'.$row['Module_ID'].'|'.$row2['Alias'].'|'.$itemtype.'">';
					   echo' <submodule>'.$row2['Form'].'</submodule>';
					   echo' </item>'; 
							
						}
					echo' </item>'; 
				}
		//	print('</item>');
		}
	}else{
	//error occurs
		echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
	}
} else {

	/*$sql = "SELECT DISTINCT F.Module_ID, Module FROM form_rights R 
	LEFT JOIN `form` F ON R.Form_ID = F.Form_ID
	WHERE F.ActiveInd=1 AND F.Menu=1 AND R.Profile_ID=".$profile." ORDER By M.Panga";*/
	$sql = "SELECT DISTINCT F.Form_ID, `Form`, F.Parent_ID FROM `form` F
	WHERE F.ActiveInd=1 AND F.Module_ID=0 AND F.`Parent_ID`=0 ORDER By F.Panga";
	$res = mysql_query($sql);
			
	if($res){
		while($row=mysql_fetch_array($res)){
			$sql1 = "SELECT Form_ID FROM `form` WHERE Parent_ID=".$row['Form_ID'];
			$res1 = mysql_query($sql1);
			$row1 = mysql_fetch_array($res1);
			if ($row1) {$z='Z';}
			//print('<item text="'.$row['Form'].'" id="'.$z.$row['Form'].'">');
			$sql2 = "SELECT DISTINCT F.Form_ID, `Form`, Alias FROM `form` F
						WHERE F.ActiveInd=1 AND Parent_ID=".$row['Form_ID']." ORDER BY Panga";
						$res2 = mysql_query ($sql2);
						while($row2=mysql_fetch_array($res2)){
							//print('<item text="'.stripslashes($row2['Form']).'" id="'.$row2['Alias'].'"/>');
						}
			//print('</item>');
		}
	}
}

echo '</data>';

?>