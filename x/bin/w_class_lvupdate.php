<?php

class cLv
{

function cLv(){
		global $oDB; global $oDC; global $oDD;
		$oDB->Query('TRUNCATE TABLE `emp_leave`');
		
		$oDB->Query('Update `leave` L
		SET L.Leave_TypeID = 9
		WHERE Leave_TypeID in (5,8)');		
		
		$oDB->Query('INSERT INTO emp_leave( Employee_ID, Leave_TypeID, Leave_Days, CreateBy, CreateDt, ModBy, ModDt )
		SELECT Employee_ID, L.Leave_TypeID, T.Days - sum( Days_Applied ) , 9999, "2009-04-22 12:20:56", 9999, "2009-04-22 12:10:56"
		FROM `leave` L
		LEFT JOIN leave_type T ON L.Leave_TypeID = T.Leave_TypeID
		WHERE Leave_Status = "Approved" AND L.ActiveInd = 1
		AND L.Leave_TypeID <>9 AND L.Half_Day = 0
		GROUP BY Employee_ID, L.Leave_TypeID
		ORDER BY Employee_ID');
		
		$oDB->Query('INSERT INTO emp_leave (Employee_ID, Leave_TypeID, Leave_Days, CreateBy, CreateDt, ModBy, ModDt)
		SELECT L.Employee_ID, L.Leave_TypeID, E.Leave_Days - sum(Days_Applied), 9999, "2009-04-22 08:20:56", 9999, "2009-04-22 08:20:56"
		FROM `leave` L
		LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
		WHERE Leave_Status = "Approved" AND L.ActiveInd = 1
		AND L.Leave_TypeID = 9 AND L.Half_Day = 0
		GROUP BY L.Employee_ID, L.Leave_TypeID
		ORDER BY Employee_ID') ;//AND E.Leave_Days <> 0
				
		$oDB->Query('SELECT L.Employee_ID, L.Leave_TypeID, (sum(Days_Applied)/2) AS F, E.Leave_Days - (sum(Days_Applied)/2) AS Days
		FROM `leave` L
		LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
		WHERE Leave_Status = "Approved" AND L.ActiveInd = 1
		AND L.Leave_TypeID <> 9 AND L.Half_Day = 1
		GROUP BY L.Employee_ID, L.Leave_TypeID');
		
		$row_d = $oDB->Getrow();
		//
		
		do
		{
			if (!$row_d) break;
			
			$oDC->Query('SELECT * FROM emp_leave WHERE Leave_TypeID = '.$row_d['Leave_TypeID'].' AND Employee_ID='.$row_d['Employee_ID']);
			//echo 'SELECT * FROM emp_leave WHERE Leave_TypeID = '.$row_d['Leave_TypeID'].' AND Employee_ID='.$row_d['Employee_ID'];

			$row_d1 = $oDC->Getrow();
			//if (!$row_d1) break;
			
			if (!$row_d1)  {
				$oDD->Query('INSERT INTO emp_leave (Employee_ID, Leave_TypeID, Leave_Days, CreateBy, CreateDt, ModBy, ModDt) VALUES
				('.$row_d['Employee_ID'].', '.$row_d['Leave_TypeID'].', '.$row_d['Days'].', 9999, "2009-04-22 08:20:56", 9999, "2009-04-22 08:20:56")') ;
				/*echo 'INSERT INTO emp_leave (Employee_ID, Leave_TypeID, Leave_Days, CreateBy, CreateDt, ModBy, ModDt) VALUES
				('.$row_d['Employee_ID'].', '.$row_d['Leave_TypeID'].', '.$row_d['Days'].', 9999, "2009-04-22 08:20:56", 9999, "2009-04-22 08:20:56")';*/
			} else {			
				$oDD->Query('UPDATE emp_leave SET Leave_Days = Leave_Days - '.$row_d['F'].' WHERE Employee_ID = '.$row_d['Employee_ID'].' AND Leave_TypeID ='.$row_d['Leave_TypeID']);
				//echo $row_d1['Employee_ID'];
			}

		}while ($row_d = $oDB->Getrow());
				
		
		$oDB->Query('SELECT L.Employee_ID, L.Leave_TypeID, (sum(Days_Applied)/2) AS F, E.Leave_Days - (sum(Days_Applied)/2) AS Days
		FROM `leave` L
		LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
		WHERE Leave_Status = "Approved" AND L.ActiveInd = 1
		AND L.Leave_TypeID = 9 AND E.Leave_Days <> 0 AND L.Half_Day = 1
		GROUP BY L.Employee_ID, L.Leave_TypeID');

		$row_e = $oDB->Getrow();
		
		do
		{
			if (!$row_e) break;
			
			$oDC->Query('SELECT * FROM emp_leave WHERE Leave_TypeID = 9 AND Employee_ID='.$row_e['Employee_ID']);
			//echo 'SELECT * FROM emp_leave WHERE Leave_TypeID = 9 AND Employee_ID='.$row_e['Employee_ID'];

			$row_e1 = $oDC->Getrow();
			//if (!$row_e1) break;
		
			if (!$row_e1['Employee_ID']) {
				$oDD->Query('INSERT INTO emp_leave (Employee_ID, Leave_TypeID, Leave_Days, CreateBy, CreateDt, ModBy, ModDt) VALUES
				('.$row_e['Employee_ID'].', 9, '.$row_e['Days'].', 9999, "2009-04-22 08:20:56", 9999, "2009-04-22 08:20:56")');
				/*echo 'INSERT INTO emp_leave (Employee_ID, Leave_TypeID, Leave_Days, CreateBy, CreateDt, ModBy, ModDt) VALUES
				('.$row_e['Employee_ID'].', 9, '.$row_e['Days'].', 9999, "2009-04-22 08:20:56", 9999, "2009-04-22 08:20:56")';
				*/
			} else {
				$oDD->Query('UPDATE emp_leave SET Leave_Days = Leave_Days - '.$row_e['F'].' WHERE Employee_ID = '.$row_e['Employee_ID'].' AND Leave_TypeID =9');
			}

		}while ( $row_e = $oDC->Getrow() );/**/
	}
	
	function dLv(){
			global $oDB; global $oDC; global $oDD;
			$oDB->Query('SELECT * FROM `leave` L WHERE L.Leave_TypeID = 9 AND L.ActiveInd = 1');// AND L.Employee_ID <>0
			$row_a = $oDB->Getrow();
			
			do {
				if (!$row_a) break;
				//remember to specify the leave type depending on the choice above
				$oDC->Query('SELECT * FROM `leave` L 
				LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
				LEFT JOIN leave_type T ON T.Leave_TypeID = L.Leave_TypeID
				WHERE L.Leave_TypeID = 9 AND L.Employee_ID ='.$row_a['Employee_ID'].' AND L.ActiveInd = 1 ORDER BY L.CreateDt ASC');

				$row_l = $oDC->Getrow();
				$x = round($row_l['Leave_Days']);
				
				do {
					if ($row_l['Half_Day']==1){
						$b = $x - ($row_l['Days_Applied']/2);
					} else {
						$b = $x - $row_l['Days_Applied'];
					}
	
					$oDD->Query('UPDATE `leave` SET Days_Available='.$x.', Days_Balance='.$b.', Moddt = "'.date("Y-m-d").'" WHERE Leave_ID='.$row_l['Leave_ID']);
					//echo '',N;
					if ($row_l['Leave_Status']=='Approved'){
						$x = $b;
					}
						
				} while($row_l = $oDC->Getrow());
				
			} while($row_a = $oDB->Getrow());
	}
}

?>