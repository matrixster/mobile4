<?php
session_start();

require_once('../../bin/w_init.php');

$oVIP->selfurl = 'items.php';
$oVIP->selfname = 'Item List';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

require_once('../../header_old.php');
// INITIALISE

$id = -1;
if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_POST['id'])) $id = $_POST['id'];

include('../../bin/w_fn_limitsql.php');

$strState = 'SELECT * FROM organization WHERE Org_ID='.$id;
$oDB->Query($strState);
$row = $oDB->Getrow();

$strQ = 'SELECT * FROM item WHERE CreateBy IN (SELECT User_ID FROM `user` WHERE Org_ID='.$id.') LIMIT 0, 10';
$oDC->Query($strQ);

echo '<table class="ta ta_t" cellspacing="0">',N;

echo '<tr class="tr_t">',N;
echo '<th class="th_t th_t_tit" width="27%" style="">Company</th>',N;
echo '</tr>',N;
   
echo '<tr>'.N;
echo '<td class="td_t td_t_tit',$strAlt,'">',$row['Name'],'</td>',N;
echo '</tr>',N;
echo '<tr>'.N;
echo '<td class="td_t td_t_tit',$strAlt,'">',$row['Description'],'</td>',N;
echo '</tr>',N;
echo '<tr>'.N;
echo '<td class="td_t td_t_tit',$strAlt,'">',$row['Location'],', ',$row['Industry_ID'],'</td>',N;
echo '</tr>',N;
echo '</table>';

echo '<table class="ta ta_t" cellspacing="0">',N;

echo '<tr class="tr_t">',N;
echo '<th class="th_t th_t_tit" colspan="2" style="">Items</th>',N;
echo '</tr>',N;

For ($i=0;$i<999;$i++)
{
    $row1 = $oDC->Getrow();

    if ( !$row1 ) break;
    
	echo '<tr>'.N;
	echo '<td class="td_t td_t_tit',$strAlt,'">',$row1['Description'],'</td>',N;
	echo '<td class="td_t td_t_tit',$strAlt,'">',number_format($row1['Price'],2),'</td>',N;
	echo '</tr>',N;

    if ( $strAlt=='1' ) { $strAlt='2'; } else { $strAlt='1'; }

}
echo '</table>';
echo '<table class="ta ta_t" cellspacing="0">',N;

echo '<tr class="tr_t">',N;
echo '<th class="th_t th_t_tit" width="27%" style="">Contact Us</th>',N;
echo '</tr>',N;
   
echo '<tr>'.N;
echo '<td class="th_o th_o_first" width="50%">Write to us</td>',N;
echo '<td class="td_o"><textarea name="hreason" cols="32" rows="5" id="hreason"></textarea></td>',N;
echo '</tr>',N;
echo '</table>';

require_once('../../footer.php');
?>
