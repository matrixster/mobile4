<?php
/****************CATEGORY DATA**********************/
session_start();
//echo getCombo('post');

function getCombo($id){
$combo=array();	

$host="44.242.2.139";
$user="wavuh_admin";
$pass="@Wavuh456";
$dbase="wavuh_456";

mysql_connect($host,$user,$pass) or die("connect failed ");
mysql_select_db($dbase) or 
die("could not connect to database");
		
switch ($id){
case "a":
	$sql="SELECT Paymode_ID AS `ID`, Paymode AS `VALUE` FROM paymode WHERE ActiveInd=1";
	break;
case "account":
	$sql="SELECT Account_ID AS `ID`, Account_Name AS `VALUE` FROM bank_account WHERE ActiveInd=1";
	break;
case "asset":
	$sql="SELECT Asset_ID AS `ID`, CONCAT(AssetModel,' - ',Make) AS `VALUE` FROM assets WHERE ActiveInd=1";
	break;
case "assetcategory":
	$sql="SELECT Asset_Category_ID AS `ID`, Asset_Category AS `VALUE` FROM asset_category WHERE ActiveInd=1";
	break;
case "batch":
	$sql="SELECT Paymode_ID AS `ID`, Paymode AS `VALUE` FROM paymode WHERE ActiveInd=1";
	break;
case "pchart":
	$sql="SELECT Chart_ID AS `ID`, Chart AS `VALUE` FROM acc_chart WHERE Parent_ID!=0 AND ActiveInd=1";
	break;
case "employee":
	$sql="SELECT Employee_ID AS `ID`, CONCAT(Surname,' ',Other_Name) AS `VALUE` FROM employee WHERE ActiveInd=1";
	break;
case "bank":
	$sql="SELECT Bank_ID AS `ID`, Bank AS `VALUE` FROM bank WHERE ActiveInd=1";
	break;
case "branch":
	$sql="SELECT `Branch_ID` AS `ID`, `Branch` AS `VALUE` FROM `branch` WHERE `Bank_ID`=".$p;
	break;
case "campaign":
	$sql="SELECT Campaign_ID AS `ID`, Campaign_Name AS `VALUE` FROM crm_campaign WHERE ActiveInd=1";
	break;
case "casual":
	$sql="SELECT Rate_ID AS `ID`, Type_Work AS `VALUE` FROM casual_rate WHERE ActiveInd=1";
	break;
case "cchart":
	$sql="SELECT C.Chart_ID AS `ID`, Chart AS `VALUE` FROM acc_chart C
	LEFT join(SELECT Chart_ID,`Chart` AS Parent FROM acc_chart) G ON G.Chart_ID = C.Parent_ID WHERE C.Type='C' AND Parent IS NOT NULL AND C.ActiveInd=1";
	break;
case "chart":
	$sql="SELECT C.Chart_ID AS `ID`, CONCAT(Chart,' - ',`Parent`) AS `VALUE` FROM acc_chart C
	LEFT join(SELECT Chart_ID,`Chart` AS Parent FROM acc_chart) G ON G.Chart_ID = C.Parent_ID WHERE Parent IS NOT NULL AND C.ActiveInd=1";
	break;
case "costcenter":
	$sql="SELECT Section_ID AS `ID`, Section AS `VALUE` FROM section WHERE ActiveInd=1";
	break;
case "currency":
	$sql="SELECT Currency_ID AS `ID`, Currency AS `VALUE` FROM currency WHERE ActiveInd=1";
	break;
case "customer":
	$sql="SELECT CAccount_ID AS `ID`, CName AS `VALUE` FROM crm_account WHERE ActiveInd=1";
	break;
case "expense":
	$sql="SELECT Expense_ID AS `ID`, Expense AS `VALUE` FROM pcexpense WHERE Expense<>'' AND ActiveInd=1 ";
	break;
case "hrpaymode":
	$sql="SELECT Paymode_ID AS `ID`, Paymode AS `VALUE` FROM paymode WHERE hrmode=1 AND  ActiveInd=1";
	break;
case "igroup":
	$sql="SELECT Item_Group_ID AS `ID`, Item_Group AS `VALUE` FROM item_group WHERE ActiveInd=1 ";
	break;
case "item":
	$sql="SELECT Item_ID AS `ID`, Description AS `VALUE` FROM item WHERE ActiveInd=1 AND Item_Type!='S'";
	break;
case "itemcategory":
	$sql="SELECT Item_Category_ID AS `ID`, Item_Category AS `VALUE` FROM item_category WHERE ActiveInd=1";
	break;
case "invoice":
	$sql="SELECT Invoice_ID AS `ID`, CONCAT(Invoice_No,'-',Amount) AS `VALUE` FROM invoice WHERE ActiveInd=1 AND Supplier_ID=".$p;
	break;
case "installment":
	$sql="SELECT setting AS `ID`, setting AS `VALUE` FROM setting WHERE param='installment'";
	break;
case "gantt":
	$sql="SELECT setting AS `ID`, setting AS `VALUE` FROM setting WHERE param='gantt'";
	break;
case "location":
	$sql="SELECT Location_ID AS `ID`, Location AS `VALUE` FROM `location` WHERE ActiveInd=1";
	break;
case "machinery":
	$sql="SELECT Asset_ID AS `ID`, AssetModel AS `VALUE` FROM assets WHERE ActiveInd=1 AND Category_ID=2";
	break;
case "payroll":
	$sql="SELECT Payroll_ID AS `ID`, `Payroll` AS `VALUE` FROM `payroll` WHERE ActiveInd=1";
	break;
case "period":
	$sql="SELECT Period_ID AS `ID`, DATE_FORMAT(`Start_Date`, '%M-%Y') AS `VALUE` FROM `period` WHERE ActiveInd=1 ";
	break;
case "parent_pcode":
	$sql="SELECT `Pcode_ID` AS `ID`,`Description` AS `VALUE` FROM `pcode` WHERE `Pcode_ID` IN(SELECT  DISTINCT `Parent_ID` FROM pcode WHERE `ActiveInd`=1)";
	break;
case "phase":
	$sql="SELECT Location_ID AS `ID`, Location AS `VALUE` FROM `location` L WHERE Parent_ID = 0 AND ActiveInd=1";
	break;
case "project":
	$sql="SELECT Milestone_ID AS `ID`, `Milestone` AS `VALUE` FROM `milestone` WHERE ActiveInd=1";
	break;
case "post":
	$sql="SELECT Post_ID AS `ID`, `Post` AS `VALUE` FROM `post` WHERE ActiveInd=1 ";
	break;
case "product":
	$sql="SELECT Item_ID AS `ID`, Description AS `VALUE` FROM item WHERE ActiveInd=1 AND Item_Type='S'";
	break;
case "projectcategory":
	$sql="SELECT Project_Category_ID AS `ID`, Project_Category AS `VALUE` FROM `project_category` WHERE ActiveInd=1";
	break;
case "scale":
	$sql="SELECT setting AS `ID`, setting AS `VALUE` FROM setting WHERE param='gantt scale'";
	break;
case "section":
	$sql="SELECT Section_ID AS `ID`, Section AS `VALUE` FROM section WHERE ActiveInd=1";
	break;
case "statutory":
	$sql="SELECT setting AS `ID`, setting AS `VALUE` FROM setting WHERE param='statutory'";
	break;
case "store":
	$sql="SELECT Store_ID AS `ID`, Store_Name AS `VALUE` FROM store WHERE ActiveInd=1";
	break;
case "supplier":
	$sql="SELECT Supplier_ID AS `ID`, Supplier_Name AS `VALUE` FROM supplier WHERE ActiveInd=1";
	break;
case "task":
	$sql="SELECT Task_ID AS `ID`, CONCAT(Task,' - ',Location,' - ',Project,' (',Project_Category,')') AS `VALUE` FROM project_task T
	INNER JOIN (SELECT Project_ID,`Project`, Location_ID, Project_Category_ID FROM project WHERE ActiveInd=1) P ON T.Project_ID = P.Project_ID
	LEFT JOIN (SELECT Location_ID,`Location` FROM location WHERE ActiveInd=1) L ON P.Location_ID = L.Location_ID
	LEFT JOIN (SELECT Project_Category_ID,`Project_Category` FROM project_category) C ON T.Project_Category_ID = C.Project_Category_ID
	WHERE T.ActiveInd=1 AND Task<>''";
	break;
case "year":
	$sql="SELECT DISTINCT DATE_FORMAT(Start_Date, '%Y')AS `ID`, DATE_FORMAT(Start_Date, '%Y') AS `VALUE` FROM `period` WHERE ActiveInd=1";
	break;
default:
	break;
}

	/*if($id=="period"){
	$sql = $sql." AND CreateBy in (SELECT User_ID FROM `user` WHERE Org_ID=".$oVIP->orgid.") ORDER BY `Start_Date` DESC";
	}else{
	$sql = $sql." AND CreateBy in (SELECT User_ID FROM `user` WHERE Org_ID=".$oVIP->orgid.") ORDER BY `Value` ASC";
	}*/

	$res = mysql_query($sql);
	if($res){
		$i=0;
			$i=0;
			while($row=mysql_fetch_array($res)){
			$combo[$i]['value']=$row['ID'];
			$combo[$i]['label']=$row['VALUE'];
			$i++;
			
		}
	}

																
			
	$jsonval= json_encode($combo);
	$jsonval=str_replace('"value":"','value:',$jsonval);
	$jsonval=str_replace('","label"',',label',$jsonval);
	$jsonval = substr($jsonval, 1, -1);
	$combostring=$jsonval;
	return $combostring;

}

?>	