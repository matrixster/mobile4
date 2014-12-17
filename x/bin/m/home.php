<?php
session_start();
require_once('../w_init.php');
require_once('../w_fn_limitsql.php');

$oVIP->selfurl = 'home.php';
$oVIP->selfname = 'Personal home';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

// INITIALISE
//if ($oVIP->id==0) $oVIP->EndMessage('!','Please login to view this page',$_SESSION[QT]['skin_dir'],0);
//if ( !$oVIP->CanAccess($oVIP->selfurl) ) $oVIP->EndMessage('!','Access denied for this page',$_SESSION[QT]['skin_dir'],0);

$_SESSION[QT]['topics_per_page'] = 20;

$strGroup = 'all';
$strOrder = 'Relation';
$strDirec = 'ASC';
$intLimit = 0;
$intPage = 1;

// security check 1
if ( isset($_GET['group']) ) $strGroup = strip_tags($_GET['group']);
if ( isset($_GET['order']) ) $strOrder = strip_tags($_GET['order']);
if ( isset($_GET['dir']) ) $strDirec = strip_tags($_GET['dir']);
if ( isset($_GET['page']) ) $intPage = intval(strip_tags($_GET['page']));
if ( isset($_GET['view']) ) $_SESSION[QT]['viewmode'] = strip_tags($_GET['view']);

// security check 2 (no long argument)
if ( strlen($strGroup)>4 ) die('Invalid argument #group');
if ( strlen($strOrder)>12 ) die('Invalid argument #order');
if ( strlen($strDirec)>4 ) die('Invalid argument #dir');

$intLimit = ($intPage-1)*$_SESSION[QT]['topics_per_page'];

// --------
// HTML START
// --------
require_once('../../header.php');
// make groups line

$strGroups = '<td class="td_button_small" style="width:35px;">'.($strGroup=='all' ? '<b>'.$L['All'].'</b>' : '<a class="a_button" href="'.$oVIP->selfurl.'?group=all">'.$L['All'].'</a>' ).'</td>'.N;
for ($g='A';$g!='AA';$g++)
{
$strGroups .= '<td class="td_button_small" style="width:18px;">'.($strGroup==$g ? '<b>'.$g.'</b>' : '<a class="a_button" href="'.$oVIP->selfurl.'?group='.$g.'">'.$g.'</a>' ).'</td>'.N;
}
$strGroups .= '<td class="td_button_small" style="width:18px;">'.($strGroup=='0' ? '<b>#</b>' : '<a class="a_button" href="'.$oVIP->selfurl.'?group=0">#</a>' ).'</td>'.N;
$strGroups .= '<td class="td_hidden">&nbsp;</td>'.N;

  // refine query
  Switch ($strGroup)
  {
  Case 'all':   $where = ''; Break;
  Case '0':   $where = ' WHERE '.FirstCharCase('name','a-z'); Break;
  Default:   $where = ' WHERE '.FirstCharCase('name','u').'="'.$strGroup.'"'; Break;
  }
  echo $where;
  // count query


// header
echo '<table class="ta_hidden" cellspacing="0">',N;
echo '<tr class="tr_hidden">',N;
echo '<td class="td_hidden"></td>',N;
echo '<td class="td_hidden" style="width:270px;">',N;
echo '</td>',N;
echo '</tr>',N;
echo '</table>',N,N;
//-- LIMIT QUERY --

if ($oVIP->CanAccess("lindex.php")) {
	if ($oVIP->role=='H'){
	$strState = ' L.Leave_ID, L.Start_Date AS StartDate, L.End_Date AS EndDate, L.Leave_Status, T.Leave_Type, E.Surname, E.Other_Name FROM `leave` L 
	LEFT JOIN leave_type T ON T.Leave_TypeID = L.Leave_TypeID
	LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
	LEFT JOIN dept D ON E.Dept_ID = D.Dept_ID
	WHERE L.ActiveInd = 1 AND L.Leave_Status = "Pending" AND D.Head_Post_ID='.$oVIP->empid;
	} else {
	$strState = '*, L.Start_Date AS StartDate, L.End_Date AS EndDate FROM `leave` L
	LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
	LEFT JOIN leave_type T ON T.Leave_TypeID = L.Leave_TypeID
	WHERE L.ActiveInd = 1 AND L.Employee_ID='.$oVIP->empid;
	}
	$strQ = LimitSQL($strState.' AND L.CreateBy IN (SELECT User_ID FROM `user` WHERE Org_ID='.$oVIP->orgid.')','Surname ASC',0,1000);
	$oDB->Query($strQ);
	// --------
	
	echo '<table class="ta ta_t" cellspacing="0">',N;
	echo '<tr class="tr_t">',N;
	  echo '<th colspan=5 class="th_t th_t_ref" style=""><b>Leave Records</b></th>',N;
	  echo '</tr>',N;
	$oDB->Query($strQ);
	echo '<tr class="tr_t">',N;
	  echo '<th class="th_t th_t_sta" style="">Leave Type</th>',N;
	  echo '<th class="th_t th_t_sta" style="">Start Date</th>',N;
	  echo '<th class="th_t th_t_sta" style="">End Date</th>',N;
	  echo '<th class="th_t th_t_sta" style="">Days</th>',N;
	  echo '<th class="th_t th_t_sta" style="">Status</th>',N;
	  echo '</tr>',N;
	
	$strAlt='1';
	
	For ($i=0;$i<99;$i++)
	  {
	    $row = $oDB->Getrow();
	
	    if ( !$row ) break;
	    echo '<tr>'.N;
		if ($oVIP->role=='H') {
	    echo '<td class="td_t td_t_sta',$strAlt,'"><a href="../../hr/leave/lv_app.php?id=',$row['Leave_ID'],'">',$row['Other_Name'],' ',$row['Surname'],' - ',$row['Leave_Type'],'</a></td>',N;
		} else {
			if ($row['Leave_Status']=='Pending'){
				echo '<td class="td_t td_t_sta',$strAlt,'"><a href="../../hr/leave/lv_app.php?id=',$row['Leave_ID'],'">',$row['Leave_Type'],'</a></td>',N;
			} else {
				echo '<td class="td_t td_t_sta',$strAlt,'">',$row['Leave_Type'],'</td>',N;	
			}
		}
	    echo '<td class="td_t td_t_ref',$strAlt,'">'.$row['StartDate'].'</td>',N;
		echo '<td class="td_t td_t_ref',$strAlt,'">'.$row['EndDate'].'</td>',N;
		if ($row['Half_Day']==1) {
			echo '<td class="td_t td_t_ref',$strAlt,'">',$row['Days_Applied']/2,'</td>',N;
		} else {
			echo '<td class="td_t td_t_ref',$strAlt,'">',$row['Days_Applied'],'</td>',N;
		}
		echo '<td class="td_t td_t_ref',$strAlt,'">'.$row['Leave_Status'].'</td>',N;
	    echo '</tr>',N;
	
	    if ( $strAlt=='1' ) { $strAlt='2'; } else { $strAlt='1'; }
	
	}
	echo '</table>',N,N;
}

if ($oVIP->CanAccess("leave.php")) {
	if ($oVIP->role=='H'){
		$strState = '*, L.Start_Date AS StartDate, L.End_Date AS EndDate FROM `leave` L 
		LEFT JOIN employee E ON L.Employee_ID = E.Employee_ID
		LEFT JOIN leave_type T ON T.Leave_TypeID = L.Leave_TypeID
		WHERE L.Leave_Status = "Approved" AND Resume_Date>="'.date('Y-m-d').'" AND Resume_Date <= "'.date('Y-m-d', strtotime('+ 2 days')).'" AND E.Dept_ID='.$oVIP->deptid;
		$strQ = LimitSQL($strState.' AND L.CreateBy IN (SELECT User_ID FROM `user` WHERE Org_ID='.$oVIP->orgid.')','Surname ASC',0,100);
		$oDB->Query($strQ);
		
		
		$oDB->Query($strQ);
		
		echo '</table><table class="ta ta_t" cellspacing="0">',N;
		echo '<tr class="tr_t">',N;
		echo '<th colspan=3 class="th_t th_t_ref" style="">Leave resumption in 2 days</th>',N;
		echo '</tr>',N;
		$oDB->Query($strQ);
		echo '<tr class="tr_t">',N;
		echo '<th class="th_t th_t_sta" style="">Employee</th>',N;
		echo '<th class="th_t th_t_sta" style="">Start Date</th>',N;
		echo '<th class="th_t th_t_sta" style="">Resumption Date</th>',N;
		echo '<th class="th_t th_t_sta" style="">Days</th>',N;
		echo '</tr>',N;
	
		$strAlt='1';
	
		For ($i=0;$i<99;$i++)
	  	{
	    $row = $oDB->Getrow();
	
	    if ( !$row ) break;
	
	    if ( !$row ) break;
	    echo '<tr>'.N;
	    echo '<td class="td_t td_t_sta',$strAlt,'"><a href="../../hr/leave/lv_setup.php?id=',$row['Leave_ID'],'">',$row['Other_Name'],'&nbsp;',$row['Surname'],' - ',$row['Leave_Type'],'</a></td>',N;
	    echo '<td class="td_t td_t_ref',$strAlt,'">',$row['StartDate'],'</td>',N;
		echo '<td class="td_t td_t_ref',$strAlt,'">',$row['Resume_Date'],'</td>',N;
		if ($row['Half_Day']==1) {
			echo '<td class="td_t td_t_ref',$strAlt,'">',$row['Days_Applied']/2,'</td>',N;
		} else {
			echo '<td class="td_t td_t_ref',$strAlt,'">',$row['Days_Applied'],'</td>',N;
		}
	    echo '</tr>',N;
		echo '</table>',N;
	    if ( $strAlt=='1' ) { $strAlt='2'; } else { $strAlt='1'; }
		}
	
	}
	$strState = '* FROM `requisition` WHERE Employee_ID='.$oVIP->empid;
	$strQ = LimitSQL($strState.' AND CreateBy IN (SELECT User_ID FROM `user` WHERE Org_ID='.$oVIP->orgid.')','Requisition_Date DESC',0,100);
	$oDB->Query($strQ);
	
	
	$oDB->Query($strQ);

	echo '</table>';
}	

if ($oVIP->CanAccess("mrq.php")){
	echo '<table class="ta ta_t" cellspacing="0">',N;

	$oDB->Query($strQ);
	echo '<tr class="tr_t">',N;
	echo '<th class="th_t th_t_ref" style="" colspan="4">Latest Material Requisitions</th>',N;
	echo '</tr>',N;
  	echo '<tr class="tr_t">',N;
  	echo '<th class="th_t th_t_sta" style="">Ref No</th>',N;
  	echo '<th class="th_t th_t_sta" style="">Requisition Date</th>',N;
  	echo '<th class="th_t th_t_sta" style="">Raised By</th>',N;
  	echo '<th class="th_t th_t_sta" style="">Status</th>',N;
  	echo '</tr>',N;

	$strAlt='1';
	
	For ($i=0;$i<5;$i++)
	  {
	    $row = $oDB->Getrow();
	
	    if ( !$row ) break;
	    echo '<tr>'.N;
	    echo '<td class="td_t td_t_sta',$strAlt,'"><a href="../../inventory/o/ep_requisition.php?id=',$row['Requisition_ID'],'">',$row['Requisition_Code'],'</a></td>',N;
	    echo '<td class="td_t td_t_sta',$strAlt,'"><span class="small">',$row['Requisition_Date'],'</span></td>',N;
		echo '<td class="td_t td_t_ref',$strAlt,'">',$row['Surname'],' ',$row['Other_Name'],'</td>',N;
	    echo '<td class="td_t td_t_sta',$strAlt,'"><span class="small">',$row['Status'],'</span></td>',N;
		echo '</tr>'.N;
	    if ( $strAlt=='1' ) { $strAlt='2'; } else { $strAlt='1'; }
	
		}
		echo '</table>';
}

if ($oVIP->CanAccess("requisitions.php") ){
$strState = '* FROM assignments A 
LEFT JOIN assets S ON S.Asset_ID = A.Asset_ID 
LEFT JOIN `user` U ON A.User_ID = U.User_ID
WHERE A.ActiveInd=1 AND Employee_ID='.$oVIP->empid;
$strQ = LimitSQL($strState.' AND A.CreateBy IN (SELECT User_ID FROM `user` WHERE Org_ID='.$oVIP->orgid.')','StartDate DESC',0,100);
$oDB->Query($strQ);


$oDB->Query($strQ);

	echo'<table class="ta ta_t" cellspacing="0">',N;

	$oDB->Query($strQ);
	echo '<tr class="tr_t">',N;
	echo '<th class="th_t th_t_ref" style="" colspan="3">Latest Asset Requisitions</th>',N;
	echo '</tr>',N;
  	echo '<tr class="tr_t">',N;
  	echo '<th class="th_t th_t_sta" style="">Asset</th>',N;
  	echo '<th class="th_t th_t_sta" style="">Start Date</th>',N;
  	echo '<th class="th_t th_t_sta" style="">End Date</th>',N;
  	echo '</tr>',N;

	$strAlt='1';

	For ($i=0;$i<5;$i++)
  	{
    $row = $oDB->Getrow();

    if ( !$row ) break;
       echo '<tr>'.N;
    echo '<td class="td_t td_t_ref',$strAlt,'">',$row['Asset_Code'],' - ',$row['Make'],' ',$row['AssetModel'],'</td>',N;
	echo '<td class="td_t td_t_ref',$strAlt,'">',$row['StartDate'],'</td>',N;
	echo '<td class="td_t td_t_ref',$strAlt,'">',$row['EndDate'],'</td>',N;
    echo '</tr>',N;

    if ( $strAlt=='1' ) { $strAlt='2'; } else { $strAlt='1'; }

	}
	echo '</table>';
}
// --------
// Button line and pager
// --------

// -- build pager --


// -- Display button line (if more that tpp users) and pager --

if ($_SESSION[QT]['sys_members']>$_SESSION[QT]['topics_per_page']) echo '<table class="ta_button" cellspacing="0" >',N,'<tr class="tr_button">',N,$strGroups,'</tr>',N,'</table>',N,N;

  echo '<table>',N;
  echo '<tr class="tr_t">',N;
  echo '<td class="tf_t tf_t_first"></td>',N;
  For ($i=0;$i<(count($arrFields)-2);$i++)
  {
  	echo '<td class="tf_t"></td>',N;
  }
  echo '<td class="tf_t tf_t_last"></td>',N;
  echo '</tr>';
  echo '</table>
  ';

// -- Display pager --

  if ( !empty($strPager) )
  {
  echo '<table class="ta_button" cellspacing="0"><tr class="tr_button"><td class="td_hidden" id="zone_pager_bot">',$strPager,'</td></tr>  </table>',N,N;
  }

require_once('../../footer.php');
?>
