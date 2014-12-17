<?php
		function getQuery($id){
		switch($id){
			
			
			
			
				case "itemcategories":
	
	$sql="SELECT Item_Category_ID AS ID, Item_Category  AS field1 ,Item_Category  AS field2 FROM 
			item_category I
			LEFT JOIN item_group G ON I.Item_Group_ID = G.Item_Group_ID
			LEFT JOIN `user` U ON I.CreateBy = U.User_ID
			WHERE I.ActiveInd=1 ORDER BY Item_Category_ID DESC ";
			return $sql;
	break;
			
			
			case "stores":
			$sql="SELECT Store_ID AS ID, Store_Name AS field1, Store_Manager, Capacity, Comments FROM `store` S
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
WHERE S.ActiveInd=1";
			
			return $sql;
			
			break;
				case "agents":
	
				$sql = "SELECT A.`Agent_Id` AS ID,A.`Agent_Name` AS field1,A.`Agent_Contacts`,A.`Employee_ID`,E.`Surname`,E.`Other_Name` 
			FROM `crm_agent` A LEFT JOIN `employee` E ON E.`Employee_ID`=A.`Employee_ID`
			WHERE A.ActiveInd=1 ";
			
				break;
				case "customers":
				$sql = "SELECT A.CAccount_ID AS ID,A.`CName` AS field1,C.Tel_1 AS field2,A.`Title` from crm_account A
				LEFT JOIN contact C ON A.Contact_ID = C.Contact_ID
				LEFT JOIN `user` U ON A.CreateBy = U.User_ID
				WHERE A.ActiveInd=1 ORDER BY CAccount_ID DESC LIMIT 1,5";
				return $sql;
			break;
			
			case "paymentplans":
			$sql="SELECT `Plan_ID` AS ID,`Plan_name` AS field1 from crm_paymentplan A
LEFT JOIN `user` U ON A.CreateBy = U.User_ID
WHERE A.ActiveInd=1";
			
			break;
			
			case "employees":
				$sql = "SELECT E.Employee_ID AS ID,E.Employee_Code AS field1, CONCAT(IFNULL(E.Other_Name,''),' ',IFNULL(E.Surname,'')) AS field2
				From employee E 
				LEFT JOIN `post` P ON E.Post_ID = P.Post_ID
				LEFT JOIN `dept` D ON E.Dept_ID = D.Dept_ID
				LEFT JOIN `section` S ON E.Station_ID = S.Section_ID
				LEFT JOIN contract_type CT ON CT.`Contract_TypeID`=E.`Contract_TypeID`
				LEFT JOIN `user` U ON E.CreateBy = U.User_ID 
				WHERE E.ActiveInd=1 ORDER BY E.Employee_ID  DESC";
				return $sql;
			break;
			
			case "recruitment":
				$sql = "SELECT I.Interview_ID AS ID, P.Post AS field1 , I.Interview_Date AS field2  FROM interview I
				LEFT JOIN `post` P ON I.Post_ID = P.Post_ID
				LEFT JOIN `user` U ON I.CreateBy = U.User_ID
				WHERE I.ActiveInd=1 ORDER BY Interview_Date DESC";
				return $sql;
			break;
			
			case "leave":
				$sql = "SELECT Leave_ID AS ID,CONCAT(IFNULL(E.Other_Name,''),' ',IFNULL(E.Surname,'')) AS field1, L.Start_Date AS field2, L.End_Date, L.Status from `leave` L
	INNER JOIN `employee` E ON L.Employee_ID = E.Employee_ID
	LEFT JOIN `leave_type` T ON T.Leave_TypeID = L.Leave_TypeID
	LEFT JOIN `user` U ON L.CreateBy = U.User_ID
	WHERE L.ActiveInd=1 ORDER BY Leave_ID DESC";
				return $sql;
			   break;
			   
			   
			   	case "casuals":
					$sql = "SELECT A.Casual_ID AS ID,CONCAT(IFNULL(A.Other_Name,''),' ',IFNULL(A.Surname,'')) AS field1,R.Type_Work AS field2, A.Contact_ID as ContactID, A.Rate_ID AS RID, A.Bank_ID AS BankID FROM casual A 
LEFT JOIN contact C ON C.Contact_ID = A.Contact_ID 
LEFT JOIN casual_rate R ON R.Rate_ID = A.Rate_ID
LEFT JOIN bank B ON A.Bank_ID = B.Bank_ID";
				return $sql;
			   break;
			
			case "timesheet":
					$sql = "SELECT DISTINCT Attend_Date AS ID,  Attend_Date AS field1 FROM `casual_attend` S
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
  WHERE DATE_FORMAT(Attend_Date,'%w')=1 ORDER BY S.Attend_Date DESC ";
				return $sql;
			   break;
			
			case "campaigns":
					$sql = "SELECT C.Campaign_ID AS ID,C.Campaign_Name AS field1,C.Start_Date AS field2,CT.Type As CampType FROM crm_campaign C
 LEFT JOIN `campaign_type` CT ON C.Type = CT.Type_ID
 LEFT JOIN `user` U ON C.CreateBy = U.User_ID
 WHERE C.ActiveInd=1 ORDER BY  C.Campaign_ID DESC";
				return $sql;
			   break;
			   
			   case "leads":
			$sql = "SELECT L.Lead_ID AS ID, L.Title,CONCAT(IFNULL(L.First_Name,''),' ',IFNULL(L.Last_Name,'')) AS field1 ,C.Campaign_Name AS field2, L.Industry, L.DOB, L.Type,  A.Agent_Name, Tel_1, Email, L.CAccount_ID
			FROM crm_lead L
			LEFT JOIN crm_campaign C ON L.Campaign_ID = C.Campaign_ID
			LEFT JOIN crm_agent A ON L.Assigned_To = A.Agent_ID
			LEFT JOIN contact C1 ON L.Contact_ID = C1.Contact_ID
			LEFT JOIN `user` U ON U.User_ID = L.CreateBy
			WHERE L.ActiveInd=1 ORDER BY L.Lead_ID DESC ";
	return $sql;
	break;
	
	
	  case "products":
			$sql = "SELECT DISTINCT  C.Property_ID AS ID,C.Property_No AS field1, L.Location, P.Project, C.Size, FORMAT(IFNULL(A.Price,'0.00'),2)  AS field2, C.Status, C.Descr,C.leaseNo
FROM crm_property C 
LEFT JOIN project P ON P.Project_ID = C.Project_ID
LEFT JOIN location L ON P.Location_ID = L.Location_ID
LEFT JOIN crm_propertyallocation A ON A.`Property_ID`=C.`Property_ID`
LEFT JOIN `user` U ON U.User_ID = C.CreateBy 
WHERE C.ActiveInd=1";
	return $sql;
	break;
	
	
	case "allocations":
			$sql = "SELECT C.`CAccount_ID` AS ID, A.`Price` As APrice,C.`CCode`,C.`CName` AS field1,CN.`Tel_1`,CN.`Email`,A.`AllocDt`, A.`Status` AS STATUS,P.Property_No AS field2,SUM(T.`Amount`) AS Amount_Paid,IFNULL(PP.`p_disc`,0) AS discount ,IFNULL(PP.`p_int`,0) AS interest, A.Alloc_ID AS ALLID,A.AllocDt,C.`Agent`,AG.`Agent_Name`,CM.`Campaign_Name`,L.Location FROM `crm_propertyallocation` A 
LEFT JOIN crm_propertypayment T ON T.`Alloc_ID`=A.`Alloc_ID`
LEFT JOIN crm_paymentplan PP ON A.`Plan_ID`=PP.`Plan_ID`
LEFT JOIN crm_account C ON C.`CAccount_ID`=A.`CAccount_ID`
LEFT JOIN contact CN ON C.Contact_ID = CN.Contact_ID
LEFT JOIN crm_property P ON P.`Property_ID`=A.`Property_ID`
LEFT JOIN `crm_agent`AG ON AG.`Agent_Id`=C.`Agent`
LEFT JOIN `crm_campaign`CM ON CM.`Campaign_ID`=C.`Campaign_ID`
LEFT JOIN project PJ ON PJ.Project_ID = P.Project_ID
LEFT JOIN location L ON PJ.Location_ID = L.Location_ID

WHERE A.`ActiveInd`=1  GROUP BY A.`Alloc_ID` ORDER BY A.AllocDt DESC";

	return $sql;
	break;
	
	case "lettersofoffer":
	
	$sql="SELECT Q.Quote_ID AS ID, Q.Quote_Code AS field1, Q.Quote_Date AS field2, Q.Amount, A.CName, Q.Closed from crm_quote Q
LEFT JOIN crm_account A ON Q.CAccount_ID = A.CAccount_ID
LEFT JOIN `user` U ON Q.CreateBy = U.User_ID
WHERE Q.ActiveInd=1"; 
	
	
	return $sql;
	break;
	
	
	
	case "productspayments":
	
	$sql="SELECT C.CAccount_ID AS ID,CAST(Y.Receipt_No AS UNSIGNED)  AS field1,A.Alloc_ID,A.AllocDt,C.CName,P.Property_No,J.Project, A.Price, FORMAT(SUM(Y.Amount),2) AS field2, N.p_int, N.p_disc  
FROM crm_propertyallocation A
LEFT JOIN crm_paymentplan N ON A.Plan_ID = N.Plan_ID
LEFT JOIN crm_propertypayment Y ON A.Alloc_ID = Y.Alloc_ID 
LEFT JOIN crm_account C ON A.CAccount_ID = C.CAccount_ID 
LEFT JOIN crm_property P ON A.Property_ID = P.Property_ID
LEFT JOIN project J ON J.Project_ID = P.Project_ID
LEFT JOIN `user` U ON Y.CreateBy = U.User_ID
WHERE Y.ActiveInd=1 AND Pay_Type='P'
GROUP BY A.Alloc_ID,A.AllocDt,C.CName,P.Property_No,J.Project, P.Price
ORDER BY CAST(Y.Receipt_No AS UNSIGNED) ASC";

 return $sql;
	break;
	
	
	case "items":
	
	$sql="SELECT I.Item_ID AS ID,Item_Code,Description AS field1,Item_Category,ReOrder_Level,ReOrder_Units,IFNULL(Items,0) AS field2 FROM item I
LEFT JOIN item_category C ON I.Item_Category_ID = C.Item_Category_ID
LEFT JOIN
(
SELECT Item_ID, sum(Qty) AS Items FROM stock_item GROUP BY Item_ID
) T ON T.Item_ID = I.Item_ID
LEFT JOIN `user` U ON U.User_ID = I.CreateBy
WHERE I.ActiveInd=1 AND Item_Type!='S' LIMIT 1,100";

 return $sql;
	break;
	case "itemrequisitions":
	$sql = "SELECT Requisition_ID AS ID, Requisition_Code AS field1, Requisition_Date, R.Status AS field2, Surname, Other_Name, T.Task, P.Project, C.Project_Category 
	FROM requisition R
	LEFT JOIN `employee` E ON R.Employee_ID = E.Employee_ID
	LEFT JOIN project_task T ON R.Task_ID = T.Task_ID
	LEFT JOIN project P ON T.Project_ID = P.Project_ID
	LEFT JOIN project_category C ON T.Project_Category_ID = C.Project_Category_ID
	LEFT JOIN `user` U ON U.User_ID = R.CreateBy
	WHERE R.ActiveInd=1  ORDER BY Requisition_Date DESC";
	
	 return $sql;
	break;
	
	case "issues":
	$sql = "SELECT Issue_ID AS ID, Issue_Code AS field1, Issue_Date, I.Status, Surname, Other_Name, T.Task AS field2, P.Project, C.Project_Category FROM issue I
LEFT JOIN Employee E ON I.Employee_ID = E.Employee_ID 
LEFT JOIN project_task T ON I.Task_ID = T.Task_ID
LEFT JOIN project P ON T.Project_ID = P.Project_ID
LEFT JOIN project_category C ON T.Project_Category_ID = C.Project_Category_ID
LEFT JOIN `user` U ON U.User_ID = I.CreateBy
WHERE I.ActiveInd=1 ORDER BY I.CreateDt DESC ";

 return $sql;
	break;
	
	case "stockcount":
	$sql = "SELECT Stock_Count_ID AS ID, Stock_Count_Date AS field1, S.Status AS field2  FROM stock_count S
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
WHERE S.ActiveInd = 1";

return $sql;
	break;
	
	case "goodsreceived":
	$sql = "SELECT GRN_ID AS ID, GRN_Code AS field1, GRN_Date, Delivery_No, GRN_Ref, Supplier_Name AS field2, Status from grn G
LEFT JOIN `supplier` S ON S.Supplier_ID = G.Supplier_ID
LEFT JOIN `user` U ON G.CreateBy = U.User_ID
WHERE G.ActiveInd=1  ORDER BY G.CreateDt DESC";

return $sql;
	break;
	
	case "adjustments":
	$sql = "SELECT A.Adjust_ID AS ID, CONCAT(IFNULL(I.Item_Code,''),'-',IFNULL(I.Description,'')) AS field1, A.Adjust_Date,  CONCAT(IFNULL(A.Adjust_Ind,''),'-',IFNULL(A.Qty,'')) AS field2, A.Reason, A.Status from adjust A
LEFT JOIN item I ON A.Item_ID = I.Item_ID
LEFT JOIN store S ON S.Store_ID = A.Store_ID
LEFT JOIN `user` U ON A.CreateBy = U.User_ID
WHERE A.ActiveInd=1";

return $sql;
	break;
	
	case "activity":
	$sql="SELECT Activity_ID AS ID, CONCAT('Customer - ',CName) AS RelateTo, A.Subject AS field2, A.Type, A.Start_Date, A.End_Date, A.Status, AG.Agent_Name AS `user` AS field1,A.Descr from crm_activity A 
LEFT JOIN crm_account C ON A.Related = C.CAccount_ID
LEFT JOIN `crm_agent` AG ON AG.`Agent_Id` = A.Assigned_To
WHERE  A.ActiveInd=1 
";
return $sql;
	
	break;
	
	case "employeedetails":
	
	$sql = "SELECT DISTINCT E.Employee_ID AS ID, Employee_Code, CONCAT(IFNULL(E.Other_Name,''),' ',IFNULL(E.Surname,'')) AS field1, Payroll, FORMAT(Basic,2) AS field2, Bank, BR.Branch AS myBranch, P.Account_No,PM.Paymode FROM employee E
LEFT JOIN emp_payroll P ON P.Employee_ID = E.Employee_ID
LEFT JOIN bank B ON P.Bank_ID = B.Bank_ID
LEFT JOIN  branch BR ON  BR.Branch_ID=P.Branch_ID
LEFT JOIN payroll L ON P.Payroll_ID = L.Payroll_ID 
LEFT JOIN paymode PM ON PM.Paymode_ID=P.Paymode_ID
WHERE E.ActiveInd=1  AND E.`Left`=0";
	return $sql;
	break;

case "casualsdetails":

$sql="SELECT DISTINCT C.Casual_ID AS ID, CONCAT(IFNULL(C.Other_Name,''),' ',IFNULL(C.Surname,'')) AS field1,Payroll, Paymode, Gender AS field2 FROM casual C
LEFT JOIN casual_payroll P ON P.Casual_ID = C.Casual_ID
LEFT JOIN payroll L ON P.Payroll_ID = L.Payroll_ID 
LEFT JOIN `user` U ON C.CreateBy = U.User_ID
LEFT JOIN paymode M ON P.Paymode_ID = M.Paymode_ID 
WHERE C.ActiveInd=1";

return $sql;
break;
case "loans":

$sql = "SELECT L.Loan_ID AS ID, Employee_Code, CONCAT(IFNULL(E.Other_Name,''),' ',IFNULL(E.Surname,'')) AS field1,Pcode,FORMAT( L.Amount,2) AS field2, L.Start_Date, L.Status FROM loan L 
LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
LEFT JOIN pcode P ON L.Pcode_ID = P.Pcode_ID
LEFT JOIN `user` U ON L.CreateBy = U.User_ID
WHERE L.ActiveInd=1";

return $sql;
break;
case "processpay":
$sql="SELECT P.Period_ID AS ID, Payroll AS field1, DATE_FORMAT(R.Start_Date,'%M-%Y') AS field2, Process_Date, P.PProcess_ID, D.Amount, N.Amount AS Net, P.Status
FROM pprocess P
LEFT JOIN
(
	SELECT PProcess_ID, SUM(Amount) AS Amount FROM pprocess_dtl WHERE PCode_ID=3 GROUP BY PProcess_ID
)
D ON P.PProcess_ID = D.PProcess_ID
LEFT JOIN
(
	SELECT PProcess_ID, SUM(Amount) AS Amount FROM pprocess_dtl WHERE PCode_ID=9 GROUP BY PProcess_ID
)
N ON P.PProcess_ID = N.PProcess_ID
LEFT JOIN period R ON P.Period_ID = R.Period_ID
LEFT JOIN payroll Y ON P.Payroll_ID = Y.Payroll_ID
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
WHERE P.ActiveInd=1  ORDER BY R.Start_Date DESC";


return $sql;

break;


case "casualspay":
$sql="SELECT StartDt AS ID,DATE_FORMAT( StartDt,'%d-%M-%Y') AS field1,DATE_FORMAT( EndDt,'%d-%M-%Y') AS field2, Status, SUM(Amount) AS Amount 
FROM casual_pay GROUP BY StartDt, EndDt, Status ORDER BY StartDt DESC";


return $sql;
break;

case "banks":
$sql="SELECT Bank_ID AS ID, Bank_Code, Bank AS field1 FROM bank B
LEFT JOIN `user` U ON B.CreateBy = U.User_ID
WHERE B.ActiveInd=1";

return $sql;

case "branches":
$sql="SELECT Branch_ID AS ID, Branch_Code,  CONCAT(IFNULL(Bank,''),'---',IFNULL(Branch,'')) AS field1 , Bank_Code FROM branch R
LEFT JOIN bank B ON R.Bank_ID = B.Bank_ID
LEFT JOIN `user` U ON R.CreateBy = U.User_ID
WHERE R.ActiveInd=1 ORDER BY Bank ASC ";

return $sql;
break;



case "payrolls":

$sql="SELECT `Payroll_ID` AS ID,`Payroll` AS field1 FROM `payroll` WHERE `ActiveInd`=1";
return $sql;
break;

case "paycodes":
$sql="SELECT P.Pcode_ID AS ID,CONCAT(IFNULL(P.Description,''),' (',IFNULL(P.Pcode,''),')') AS field1,PC.Description AS PCODE_PARENT FROM pcode P
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
LEFT JOIN pcode PC ON PC.Pcode_ID=P.Parent_ID
WHERE P.ActiveInd=1";
return $sql;
break;
	//fobareh@softcall.co.ke
	
	
	case "suppliers":
	$sql="SELECT Supplier_ID AS ID, Supplier_Name AS field1, S.Contact_Person, C.Tel_1 AS field2, C.Email, P.Payterm FROM supplier S 
LEFT JOIN contact C ON S.Contact_ID = C.Contact_ID
LEFT JOIN payterm P ON S.Payterm_ID = P.Payterm_ID
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
WHERE S.ActiveInd=1";
	
	return $sql;
	break;
	
	case "purchaseorders":
	$sql="SELECT P.`PO_ID` AS ID,P.`PO_Code` AS field1,S.Supplier_Name AS field2 FROM `po` P
LEFT JOIN supplier S ON P.`Supplier_ID`=S.`Supplier_ID`
WHERE P.`ActiveInd`=1";
	
	
	return $sql;
	break;

	case "directorders":
	
	$sql="SELECT P.`PO_ID` AS ID,P.`PO_Code` AS field1,S.Supplier_Name AS field2 FROM `po` P
LEFT JOIN supplier S ON P.`Supplier_ID`=S.`Supplier_ID`
WHERE P.`ActiveInd`=1 AND P.Direct=1";
	
	
	return $sql;
	break;
	
	case "consumables":
	
	$sql="SELECT I.Item_ID AS ID, I.Item_Code, I.Description AS field1, count(Quotation_ID) AS field2
FROM item I
LEFT JOIN quotation Q ON Q.Item_ID = I.Item_ID AND Q.ActiveInd=1
LEFT JOIN `user` U ON I.CreateBy = U.User_ID
WHERE I.ActiveInd=1
GROUP BY I.Item_ID, I.Item_Code, I.Description ORDER BY count(Quotation_ID) DESC";
	
	return $sql;
	break;
	
	case "assetcategories":
	
	$sql="SELECT Asset_Category_ID AS ID, Asset_Category AS field1 ,Abbrev AS field2
FROM asset_category C
LEFT JOIN `user` U ON C.CreateBy = U.User_ID
WHERE C.ActiveInd=1";
	
	return $sql;
	break;
	
	case "assets":
	$sql="SELECT Asset_ID AS ID, Asset_Code, Asset_Category AS field1, CONCAT(IFNULL(A.AssetModel,''),'  (',IFNULL(FORMAT(A.AssetPrice,2),''),')')  AS field2,  AssetSerial, AssetPrice, YearOfPurchase,Status from assets A 
LEFT JOIN asset_category C ON C.Asset_Category_ID = A.Category_ID
WHERE A.ActiveInd=1 ";
	
	return $sql;
	break;
	
	
	case "assetrequisitions":
	
	$sql="SELECT `ARequisition_ID` AS ID,`Description` AS field1,CONCAT(IFNULL(`Qty`,''),'  (',IFNULL(Status,''),')')  AS field2 FROM `asset_requisition` WHERE `ActiveInd`=1";
	return $sql;
	break;
	
	case "purchaserequests":
	
	$sql="SELECT Prequisition_ID AS ID, Item_Code, I.Description AS field1, Qty, P.Ref, Date_format(P.CreateDt, '%d-%m-%Y') AS field2
FROM prequisition P
LEFT JOIN item I ON I.Item_ID = P.Item_ID 
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
WHERE P.ActiveInd=1 AND Item_Code <>'' AND PO=0 ORDER BY P.CreateDt DESC";
	return $sql;
	break;
	
	case "assetissues":
	
	$sql="	SELECT Assignment_ID AS ID,  CONCAT(IFNULL(Make,''),' ',IFNULL(AssetModel,'')) AS field1  ,  CONCAT(IFNULL(U.User,''),'  (',IFNULL(Qty_Out,''),')')  AS field2 , S.Description, StartDate, EndDate, S.Status FROM assignments S
LEFT JOIN assets A ON S.Asset_ID = A.Asset_ID
LEFT JOIN user U ON U.User_ID = S.User_ID
WHERE S.ActiveInd=1";
	return $sql;
	break;
	case "disposals":
	
	$sql="SELECT  A.Asset_ID,A.Asset_Code,CONCAT(IFNULL(A.Make,''),' ',IFNULL(A.AssetModel,'')) AS field1 ,DATE_FORMAT(A.Disposal_Date,'%d-%m-%Y') AS field2 FROM assets A 
LEFT JOIN `user` U ON A.CreateBy = U.User_ID
WHERE 
A.ActiveInd=1 AND Disposal_Date <>'' AND Disposal_Type<>''
";

case "receipts":

$sql="SELECT R.`Receipt_ID` AS ID, C.`CName` AS field1,CONCAT(IFNULL(R.`Receipt_Date`,''),'  (',IFNULL(FORMAT(R.`Amount`,2),''),')')  AS field2 FROM `receipt` R
LEFT JOIN crm_account C ON C.`CAccount_ID`=R.`CAccount_ID`
WHERE R.`ActiveInd`=1";

return $sql;
break;

 case "payments":
 $sql="SELECT P.Payment_ID AS ID, CONCAT(IFNULL(Payee,''),'  ',IFNULL(S.Supplier_Name,''),' ',IFNULL(C.CName,''))  AS field1,CONCAT(IFNULL(P.Payment_Date,''),'  (',IFNULL(FORMAT(Amt,2),''),')')  AS field2 FROM payment P 
LEFT JOIN (
SELECT Payment_ID, IFNULL(SUM(Amount),0) AS Amt 
FROM payment_dtl WHERE ActiveInd=1 GROUP BY Payment_ID
) D ON P. Payment_ID = D.Payment_ID
LEFT JOIN supplier S ON S.Supplier_ID = P.Supplier_ID
LEFT JOIN crm_account C ON P.CAccount_ID = C.CAccount_ID
WHERE P.`ActiveInd`=1

";
 
 return $sql;
 break;

	case "journals":
	
	$sql="SELECT Journal_ID AS ID, Journal_No AS field1, CONCAT(IFNULL(DATE_FORMAT(Journal_Date,'%d-%m-%Y'),''),'  (',IFNULL(FORMAT(Amount,2),''),')')  AS field2, Memo, A.Chart AS CR, B.Chart AS DR,J.Posted
FROM acc_journal J
LEFT JOIN acc_chart A ON J.CR_Chart_ID = A.Chart_ID
LEFT JOIN acc_chart B ON J.DR_Chart_ID = B.Chart_ID
LEFT JOIN `user` U ON J.CreateBy = U.User_ID
WHERE J.ActiveInd=1  ORDER BY Journal_Date DESC";


	return $sql;
	break;
	
	case "banktransfers":
	$sql="SELECT T.Transfer_ID AS ID, Transfer_Date, T.Amount, A.Account_Name AS field1, B.Account_Name AS field2, T.Posted, T.Memo, T.Ref, T.Voucher_No 
FROM acc_transfer T
LEFT JOIN bank_account A ON A.Account_ID = T.Transfer_From
LEFT JOIN bank_account B ON B.Account_ID = T.Transfer_To
LEFT JOIN `user` U ON T.CreateBy = U.User_ID
WHERE T.ActiveInd=1 ORDER BY Transfer_Date DESC";
	
	
	return $sql;
	break;
	case "reconciliation":
	$sql="SELECT  Recon_ID AS ID,  DATE_FORMAT(Recon_Date,'%d-%m-%Y') AS field1,FORMAT(Adjust_Amount,2) AS field2,  CONCAT(IFNULL(A.Chart,''),'  (',IFNULL(DATE_FORMAT(R.Recon_Date,'%d-%m-%Y'),''),')')  AS fieldx,
CONCAT(IFNULL(B.Chart,''),'  (',IFNULL(Adjust_Amount,''),')')  AS fieldy
FROM bank_recon R
LEFT JOIN acc_chart A ON A.Chart_ID = R.CR
LEFT JOIN acc_chart B ON B.Chart_ID = R.DR 
LEFT JOIN `user` U ON R.CreateBy = U.User_ID
WHERE R.ActiveInd=1";

	return $sql;
	break;
	
	case "locations":
	$sql="SELECT P.Project_ID AS ID, Project AS field1,Description, SD AS Start_Date, ED AS End_Date, Status, Location AS field2, Completion FROM project P

LEFT JOIN location L ON P.Location_ID = L.Location_ID
LEFT JOIN 
(
SELECT Project_ID, MIN(Start_Date) AS SD, MAX(End_Date) AS ED FROM project_task GROUP BY Project_ID
) X ON X.Project_ID = P.Project_ID
LEFT JOIN user X ON X.User_ID = P.CreateBy
WHERE P.ActiveInd=1 ORDER BY Location, Project, SD ASC";
	
	return $sql;
	break;
	
	case "projects":
	
	$sql="SELECT `Milestone_ID` AS ID,`Milestone` AS field1,DATE_FORMAT(`CreateDt`,'%d-%M-%Y') AS field2 FROM `milestone` WHERE `ActiveInd`=1";
	
	return $sql;
	break;
	
	case "tasks":
	
	$sql="SELECT `Task_ID` AS ID,`Task` AS field1, DATE_FORMAT(`Start_Date`,'%d-%M-%Y') AS field2 FROM `project_task` WHERE `ActiveInd`=1";
	return $sql;
	break;
	
	
	case "projectbudget":
	
	$sql="SELECT 
	T.Task_ID AS ID, 
	T.Task AS field1,
	T.Memo, 
	T.Start_Date, 
	T.End_Date, 
	T.Completion, 
	FORMAT((SELECT SUM(Amount) FROM project_budget WHERE ActiveInd=1 AND Task_ID=T.Task_ID AND Period BETWEEN CONCAT(DATE_FORMAT(T.Start_Date,'%Y-%m'),'-01') AND T.End_Date),2) AS field2,
	T.Actual_Cost, 
	Location, 
	Project_Category
FROM project_task T
INNER JOIN project P ON P.Project_ID = T.Project_ID AND P.ActiveInd=1
LEFT JOIN project_category C ON T.Project_Category_ID = C.Project_Category_ID 
LEFT JOIN location L ON P.Location_ID = L.Location_ID
LEFT JOIN 
(
SELECT SUM(Amount) AS Budget , Task_ID, MAX(Period) AS Period FROM project_budget P WHERE P.ActiveInd=1 GROUP BY Task_ID
) B ON B.Task_ID = T.Task_ID AND Period BETWEEN T.Start_Date AND T.End_Date
LEFT JOIN user X ON X.User_ID = T.CreateBy
WHERE T.ActiveInd=1  ORDER BY Location,Project,Task";
	
	return $sql;
	break;
	
	
	case "phases":
	
	$sql="SELECT Location_ID AS ID, Location AS field1, Milestone AS field2 FROM 
	`location` L
	LEFT JOIN milestone M ON L.Milestone_ID = M.Milestone_ID
	LEFT JOIN `user` U ON L.CreateBy = U.User_ID
	WHERE L.ActiveInd=1";

	return $sql;
	break;
	
	case "projectdepartments":
	
	$sql="SELECT Dept_ID AS ID, Dept AS field1,Post AS field2 FROM dept D
LEFT JOIN post P ON D.Head_Post_ID = P.Post_ID
LEFT JOIN `user` U ON D.CreateBy = U.User_ID
WHERE D.ActiveInd=1";

	return $sql;
	break;
	
	case "currencies":
	$sql="SELECT Currency_ID AS ID, Currency AS field1, Symbol, Rate 
		FROM currency C 
		LEFT JOIN `user` U ON C.CreateBy = U.User_ID
		WHERE C.ActiveInd=1 ORDER BY Currency_ID DESC";
		return $sql;
		break;
		
		case "paymentmodes":
	$sql="SELECT Paymode_ID AS ID, Paymode AS field1 FROM paymode P 
				LEFT JOIN `user` U ON P.CreateBy = U.User_ID
				WHERE P.ActiveInd=1";
		return $sql;
		break;
		
		case "paymentterms":
	$sql="SELECT Payterm_ID AS ID, Payterm AS field1 FROM payterm P
		LEFT JOIN `user` U ON P.CreateBy = U.User_ID
		WHERE P.ActiveInd=1 ORDER BY Payterm_ID  DESC";
		return $sql;
		break;
		
		case "accountperiods":
	$sql="SELECT Year_ID AS ID, CONCAT('From :',IFNULL(DATE_FORMAT(Year_Start,'%d-%m-%Y'),''),' To :  ',IFNULL(DATE_FORMAT(Year_End,'%d-%m-%Y'),'')) AS field1, Open from fiscalyear F
LEFT JOIN `user` U ON F.CreateBy = U.User_ID
WHERE F.ActiveInd=1";
		return $sql;
		break; 
		
		case "bankaccounts":
		$sql="SELECT Account_ID AS ID, Account_Name AS field1, Chart, Bank, Symbol, Account_Number, A.`Type`, `Default`
FROM bank_account A
LEFT JOIN bank B ON A.Bank_ID = B.Bank_ID
LEFT JOIN acc_chart C ON A.Chart_ID = C.Chart_ID 
LEFT JOIN currency R ON A.Currency_ID = R.Currency_ID
LEFT JOIN `user` U ON A.CreateBy = U.User_ID
WHERE A.ActiveInd=1";
		
		return $sql;
		break;
	case "paycodegl":
	$sql="SELECT PCode_ID AS ID, PCode, P.Description AS field1, A.Chart, `Group`, C.Chart AS `Parent` FROM pcode P
LEFT JOIN acc_chart A ON P.Chart_ID = A.Chart_ID
LEFT JOIN acc_chart C ON A.Parent_ID = C.Chart_ID
LEFT JOIN acc_group G ON G.Group_ID = A.Group_ID
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
WHERE P.Editable=1 AND P.ActiveInd=1";
	return $sql;
	break;
	
	case "accountgroups":
	
	$sql="SELECT Group_ID AS ID, `Group` AS field1, `Section`
FROM acc_group G 
LEFT JOIN acc_section S ON S.Section_ID = G.Section_ID
LEFT JOIN `user` U ON G.CreateBy = U.User_ID
WHERE G.ActiveInd=1";
	return $sql;
	break;
	
	case "chartofaccounts":
	$sql="SELECT C.Chart_ID AS ID, C.Chart_Code, C.Chart AS field1, C.`Type`, Symbol, `Group`, A.Chart AS Parent
from acc_chart C
LEFT JOIN currency R ON C.Currency_ID = R.Currency_ID
LEFT JOIN acc_group G ON C.Group_ID = G.Group_ID 
LEFT JOIN acc_chart A ON C.Parent_ID = A.Chart_ID
LEFT JOIN `user` U ON C.CreateBy = U.User_ID
WHERE 
C.ActiveInd=1";
	return $sql;
	break; 
	
	case "openingbalances":
	$sql="SELECT B.Chart_ID AS ID, Chart_Code, Parent, Chart, CONCAT(IFNULL(B.Opening_CR,''),'', IFNULL(B.Opening_DR,'')) AS field1, Section_ID
FROM `acc_bal` B
INNER JOIN acc_chart A ON A.Chart_ID = B.Chart_ID AND A.CreateBy IN (SELECT User_ID FROM `user` WHERE Org_ID='.$oVIP->orgid.')
LEFT JOIN acc_group G ON A.Group_ID = G.Group_ID
LEFT JOIN (
	SELECT Chart_ID,`Chart` AS Parent FROM acc_chart
) G ON G.Chart_ID = A.Parent_ID";
	return $sql;
	break; 
	
	
	case "departmentgl":
	$sql="SELECT Project_Category_ID AS ID, Project_Category AS field1, CONCAT(A.Chart,' - ',GA.`Chart`) As Materials, CONCAT(B.Chart,' - ',GB.`Chart`) AS Labor, CONCAT(C.Chart,' - ',GC.`Chart`) as Fuel FROM project_category P
LEFT JOIN acc_chart A ON P.Materials = A.Chart_ID
LEFT JOIN acc_chart GA ON A.Parent_ID = GA.Chart_ID
LEFT JOIN acc_chart B ON P.Labor = B.Chart_ID
LEFT JOIN acc_chart GB ON B.Parent_ID = GB.Chart_ID
LEFT JOIN acc_chart C ON P.Fuel = C.Chart_ID
LEFT JOIN acc_chart GC ON C.Parent_ID = GC.Chart_ID
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
WHERE P.ActiveInd=1";
	return $sql;
	break;  
	
	
	
	case "tabsetup":
	$sql="SELECT PCTab_ID AS ID, PCTab AS field1, FORMAT(TabLimit,2) AS field2, Chart from pctab P
LEFT JOIN acc_chart A ON A.Chart_ID = P.PCChart_ID
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
WHERE P.ActiveInd=1";
	return $sql;
	break;  
	
	case "expensesetup":
	$sql="SELECT Expense_ID AS ID, Expense_Code, Expense AS field1, E.Descr, Chart AS field2 from pcexpense E
LEFT JOIN acc_chart A ON A.Chart_ID = E.EChart_ID
WHERE E.ActiveInd=1";

	return $sql;
	break;  

case "assigncashtotab":
	$sql="SELECT Assign_ID AS ID, Assign_Date, FORMAT(Amount,2) AS field2, Descr, PCTab AS field1,Account_Name from pcassign A
LEFT JOIN pctab P ON A.PCTab_ID = P.PCTab_ID
LEFT JOIN bank_account B ON A.Account_ID = B.Account_ID
LEFT JOIN `user` U ON A.CreateBy = U.User_ID
WHERE A.ActiveInd=1";

	return $sql;
	break;
	
	
case "claimexpenses":
	$sql="SELECT Claim_ID AS ID, FORMAT(Amount,2) AS field2 , C.Descr, PCTab, Expense,CONCAT(IFNULL( Expense_To,''), IFNULL(Supplier_Name,''),IFNULL(Surname,''),' ',IFNULL(Other_Name,'')) AS field1, `User`, C.Status from pcclaim C
LEFT JOIN pctab P ON C.PCTab_ID = P.PCTab_ID
LEFT JOIN pcexpense E ON C.Expense_ID = E.Expense_ID
LEFT JOIN employee Y ON C.Employee_ID = Y.Employee_ID
LEFT JOIN supplier S ON S.Supplier_ID = C.Supplier_ID  
LEFT JOIN `user` U ON C.CreateBy = U.User_ID
WHERE C.ActiveInd=1 ";

	return $sql;
	break;  
  case "debitnotes":
	$sql="SELECT C.Note_ID AS ID, C.Note_Code , C.Note_Date, FORMAT(C.Amount,2) AS field2, S.Supplier_Name AS field1, C.Status
FROM credit_note C
LEFT JOIN supplier S ON C.Supplier_ID = S.Supplier_ID
LEFT JOIN invoice I ON C.Invoice_ID = I.Invoice_ID
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
WHERE C.ActiveInd=1 AND C.`Type`='D'";

	return $sql;
	break;  
	case "purchaseinvoices":
	$sql="SELECT Invoice_ID AS ID, Invoice_No, Invoice_Date,FORMAT(I.Amount,2) AS field2, Supplier_Name AS field1, Discount, Tax, I.Status, I.Paid,
IFNULL((SELECT SUM(D.Amount) FROM `payment_dtl` D INNER JOIN `payment` P ON D.Payment_ID = P.Payment_ID AND Posted=1 AND P.ActiveInd=1 WHERE D.Invoice_ID=I.Invoice_ID),0) Payment
FROM invoice I
LEFT JOIN supplier S ON S.Supplier_ID = I.Supplier_ID
LEFT JOIN `user` U ON I.CreateBy = U.User_ID
WHERE I.ActiveInd=1";
	return $sql;
	break;
	
	
	case "salesorders":
	
	$sql="SELECT S.SO_ID AS ID, S.SO_Code, S.SO_Date, FORMAT(S.Amount,2) AS field2, A.CName AS field1, S.Status, P.Payterm from crm_so S
LEFT JOIN crm_account A ON A.CAccount_ID = S.CAccount_ID
LEFT JOIN payterm P ON S.Payterm_ID = P.Payterm_ID
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
WHERE S.ActiveInd=1";
	
	return $sql;
	break;
	
	case "salesinvoices":
	$sql="SELECT Invoice_ID AS ID, Invoice_Code, Invoice_Date, FORMAT(I.Amount,2) AS field2, A.CName AS field1, I.Status 
FROM crm_invoice I
LEFT JOIN crm_account A ON A.CAccount_ID = I.CAccount_ID
LEFT JOIN `user` U ON I.CreateBy = U.User_ID
WHERE I.ActiveInd=1";
	
	return $sql;
	break;
	
	case "creditnotes":
	$sql="SELECT C.Note_ID AS ID, C.Note_Code, C.Note_Date, FORMAT(C.Amount,2) AS field2, A.CName AS field1, C.Status
FROM credit_note C
LEFT JOIN crm_account A ON C.CAccount_ID = A.CAccount_ID
LEFT JOIN invoice I ON C.Invoice_ID = I.Invoice_ID
LEFT JOIN `user` U ON C.CreateBy = U.User_ID
WHERE C.ActiveInd=1 AND C.`Type`='C' ";
return $sql;
break;
	
	
	case "supplierbalances":
	$sql="SELECT Supplier_ID AS ID, Supplier_Name AS field1, FORMAT(S.Open_Bal,2) AS field2
FROM supplier S
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
WHERE S.ActiveInd=1 AND U.Org_ID=1";
return $sql;
break;
	
	
	case "cheques":
	$sql="SELECT * FROM
(
	(
	SELECT CONCAT('P',P.Payment_ID)  AS ID, 'Payment' AS `Type`,CONCAT(IFNULL(Payee,''),'',IFNULL(Supplier_Name,''),'',IFNULL(CName,'')) AS field1, Account_Name, CONCAT(IFNULL(FORMAT(P.Amount,2),''),' ( ',IFNULL(DATE_FORMAT(Payment_Date,'%d-%m-%Y'),''),' )') AS field2, P.Ref, P.Paid
	FROM payment P 
	LEFT JOIN supplier S ON S.Supplier_ID = P.Supplier_ID
	LEFT JOIN crm_account C ON P.CAccount_ID = C.CAccount_ID
	LEFT JOIN bank_account A ON P.Account_ID = A.Account_ID
	LEFT JOIN `user` U ON P.CreateBy = U.User_ID
	WHERE P.ActiveInd=1 AND P.Posted=1  AND A.Account_ID=1  AND P.REf IS NOT NULL ORDER BY P.Ref ASC
	)
	UNION
	(
	SELECT CONCAT('R',R.Receipt_ID) AS ID, 'Receipt' AS `Type`,CName AS field1, Account_Name,CONCAT(IFNULL(FORMAT(R.Amount,2),''),' ( ',IFNULL(DATE_FORMAT(Receipt_Date,'%d-%m-%Y'),''),' )') AS field2, R.Ref, R.Paid
	FROM receipt R 
	LEFT JOIN crm_account C ON R.CAccount_ID = C.CAccount_ID
	LEFT JOIN bank_account A ON R.DR = A.Chart_ID
	LEFT JOIN `user` U ON R.CreateBy = U.User_ID
	WHERE R.ActiveInd=1 AND R.Posted=1 AND A.Account_ID=1  AND R.Ref IS NOT NULL ORDER BY R.Ref ASC
	)
	
) AS T";
return $sql;
break;

case"consumablesquotations":

$sql="SELECT I.Item_ID AS ID, CONCAT(IFNULL( I.Item_Code,''),' (',IFNULL(count(Quotation_ID),''),')') AS field2, I.Description AS field1
FROM item I
LEFT JOIN quotation Q ON Q.Item_ID = I.Item_ID AND Q.ActiveInd=1
LEFT JOIN `user` U ON I.CreateBy = U.User_ID
WHERE I.ActiveInd=1 
GROUP BY I.Item_ID, I.Item_Code, I.Description ORDER BY count(Quotation_ID) DESC";
return $sql;
break;

case"assetquotations":

$sql="SELECT C.Asset_Category_ID AS ID, Asset_Category AS field1, count(AQuotation_ID) AS field2
FROM asset_category C
LEFT JOIN asset_quotation Q ON C.Asset_Category_ID = Q.Asset_Category_ID
LEFT JOIN `user` U ON C.CreateBy = U.User_ID
WHERE C.ActiveInd=1 
GROUP BY C.Asset_Category_ID, Asset_Category ORDER BY count(AQuotation_ID) DESC";
return $sql;
break;
	
case"processconsumableorders":

$sql="SELECT DISTINCT S.Supplier_ID AS ID, Supplier_Name FROM prequisition P
LEFT JOIN item I ON P.Item_ID = I.Item_ID
INNER JOIN quotation Q ON Q.Item_ID = I.Item_ID
LEFT JOIN supplier S ON Q.Supplier_ID = S.Supplier_ID
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
WHERE Q.Selected = 1 AND P.ActiveInd=1 AND P.PO=0 ";
return $sql;
break;

case"processassetorders":
$sql="SELECT DISTINCT S.Supplier_ID AS ID, Supplier_Name AS field1 FROM frequisition F
INNER JOIN asset_quotation Q ON F.Asset_Category_ID = Q.Asset_Category_ID
LEFT JOIN supplier S ON Q.Supplier_ID = S.Supplier_ID
LEFT JOIN `user` U ON F.CreateBy = U.User_ID
WHERE Q.Selected = 1 AND F.PO=0 ";
return $sql;
break;
case"appraisaltypes":
$sql="SELECT `Appraisal_TypeID`  AS ID,`Appraisal_Type` AS field1 from appraisal_type A
LEFT JOIN `user` U ON A.CreateBy = U.User_ID
WHERE A.ActiveInd=1";
return $sql;
break;


case"contracttypes":
$sql="SELECT R.`Contract_TypeID` AS ID,R.`Contract_Type` AS field1,R.`confirmation_days`,R.`contract_days` FROM `contract_type` R  
LEFT JOIN `user` U ON R.CreateBy = U.User_ID
WHERE R.ActiveInd=1";
return $sql;
break;

case"departments":
$sql="SELECT Dept_ID AS ID, Dept AS field1,Post FROM dept D
LEFT JOIN post P ON D.Head_Post_ID = P.Post_ID
LEFT JOIN `user` U ON D.CreateBy = U.User_ID
WHERE D.ActiveInd=1";
return $sql;
break;

case"endreasons":
$sql="SELECT End_ReasonID AS ID, End_Reason AS field1 FROM 
end_reason E
LEFT JOIN `user` U ON E.CreateBy = U.User_ID
WHERE E.ActiveInd=1";
return $sql;
break;

case "holidays":
$sql="SELECT `Holiday_ID` AS ID,`Holiday` AS field1 FROM `holiday` WHERE  `ActiveInd`=1";
return $sql;
break;

case "leavetypes":
$sql="SELECT `Leave_TypeID` AS ID,`Leave_Type` AS field1 from leave_type L
LEFT JOIN `user` U ON L.CreateBy = U.User_ID
WHERE L.ActiveInd=1";
return $sql;
break; 
case "posts":

$sql="SELECT P.Post_ID AS ID, P.Post AS field1, P.Descr, P.Section_ID, P.QType_ID, P.No_Posts, P.Experience, QType, S.Section, P1.Post AS Supervisor
FROM post P
LEFT JOIN section S ON P.Section_ID = S.Section_ID
LEFT JOIN qtype Q ON Q.QType_ID = P.QType_ID
LEFT JOIN `user` U ON P.CreateBy = U.User_ID
LEFT JOIN post P1 ON P.Supervisor = P1.Post_ID
WHERE P.ActiveInd=1 ";
return $sql;
break;
 
case "sections":
$sql="SELECT S.Section_ID AS ID, Section AS field1, Post, Dept FROM section S 
LEFT JOIN dept D ON S.Dept_ID = D.Dept_ID
LEFT JOIN post P ON S.Head_Post_ID = P.Post_ID
LEFT JOIN `user` U ON S.CreateBy = U.User_ID
WHERE S.ActiveInd=1 ";
return $sql;
break; 


case "relationtypes":
$sql="SELECT `Relation_TypeID` AS ID,`Relation_Type` AS field1 from relation_type R
LEFT JOIN `user` U ON R.CreateBy = U.User_ID
WHERE R.ActiveInd=1";
return $sql;
break; 

case "qualificationtypes":
$sql="SELECT `QType_ID` AS ID,`QType` AS field1 from qtype Q
LEFT JOIN `user` U ON Q.CreateBy = U.User_ID
WHERE Q.ActiveInd=1";
return $sql;
break;

case "casualrates":
$sql="SELECT Rate_ID AS ID, CONCAT(IFNULL(Type_Work,''),' (',IFNULL(`Rate`,''),' )') AS field1,  Comments, `Daily` 
FROM casual_rate C 
LEFT JOIN `user` U ON C.CreateBy = U.User_ID
WHERE C.ActiveInd=1";
return $sql;
break;

	default:
	$sql="SELECT `Org_ID` AS ID,`Name` AS field1,`Contact_Person` AS field2 FROM `organization`";
	
	return $sql;
	break;
	
	
//}
		
		}
		
		}
			
?>
