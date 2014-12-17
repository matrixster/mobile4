<?php
session_start();

echo '
<link rel="stylesheet" type="text/css" href="../../skin/qti_main.css"/>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
';

$oVIP->selfurl = 'register_eva.php';
$oVIP->selfname = 'EVA Account registration';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

require_once('../../bin/w_init.php');

if ( isset($_POST['Save']) )
{
  // check form
  	  $strTl = trim($_POST['title']);
	  $strF = trim($_POST['fname']); if ( get_magic_quotes_gpc() ) $strF = stripslashes($strF);
	  $strL = trim($_POST['lname']); if ( get_magic_quotes_gpc() ) $strL = stripslashes($strL);
	  $strN = trim($_POST['name']); if ( get_magic_quotes_gpc() ) $strN = stripslashes($strN);
	  $strI = intval($_POST['industry']);
	  $strD = trim($_POST['ind']); if ( get_magic_quotes_gpc() ) $strD = stripslashes($strD);
	  $strU = trim($_POST['username']); if ( get_magic_quotes_gpc() ) $strU = stripslashes($strU);
  	  $strP = trim($_POST['password']); if ( get_magic_quotes_gpc() ) $strP = stripslashes($strP);
	  $strC = trim($_POST['cpassword']); if ( get_magic_quotes_gpc() ) $strC = stripslashes($strC);
	  $strE = trim($_POST['email']); if ( get_magic_quotes_gpc() ) $strE = stripslashes($strE);
	  $strAs = trim($_POST['contact']); if ( get_magic_quotes_gpc() ) $strAs = stripslashes($strAs);
	  if (empty($strN) || empty($strP) || empty($strU) || empty($strC) ) { $qti_error="Please enter all the required details"; }
	  
	  if ( empty($qti_error) )
	  {
	  
	  	$oDB->Query('INSERT INTO contact (Email) VALUES("'.addslashes($strE).'")');
		$oDB->Query('SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
	  	$contact = $row['Contact_ID'];
		$oDB->Query('INSERT INTO organization (Name, Industry_ID, Industry, Parent_ID, Contact_ID, CreateBy, CreateDt) VALUES("'.addslashes($strN).'", '.intval($strI).', "'.addslashes($strD).'", 15, '.intval($contact).', 999, "'.date('Y-m-d H:i:s').'")');
		$oDB->Query('SELECT Org_ID from organization ORDER BY Org_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$orgid = $row['Org_ID'];
		$oDB->Query('INSERT INTO user (User, Pwd, Org_ID, Closed, Profile_ID, CreateBy, CreateDt) VALUES("'.addslashes($strU).'", "'.sha1($strP).'", '.$orgid.', 0, 8, 999,  "'.date('Y-m-d H:i:s').'")');
		$oDB->Query('SELECT User_ID from user ORDER BY User_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$userid = $row['User_ID'];
		$oDB->Query('INSERT INTO crm_lead (Title, First_Name, Last_Name, DOB, Dept, Biz, Contact_ID, Lead_Source, Industry, Type, Revenue, Employees, Status, Assigned_To, Descr, ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
			"'.addslashes($strTl).'", "'.addslashes($strF).'", "'.addslashes($strL).'", "", "", "'.addslashes($strN).'", '.intval($contact).', "", "'.addslashes($strI).'", "", 0, 1, "Open", 18, "", 1,18, "'.date('Y-m-d H:i:s').'", 18, "'.date('Y-m-d H:i:s').'")');
		$oDB->Query('SELECT Lead_ID from crm_lead ORDER BY Lead_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$oDB->Query('UPDATE organization SET Lead_ID='.$row['Lead_ID'].', CreateBy='.$userid.' WHERE Org_ID='.$orgid);
		/**/
		// exit
		
		$strT = "EVA Registration\r\n";
		$body = "Dear ".$strU."\r\n\r\nYou have successfully registered to use EVA and Wavuh ERP. Your account will be managed by EVA. You can contact us via sales@eva.co.ke for more information.\r\n\r\nRegards\r\nThe Wavuh Team\r\n";
		QTmail($strE,QTconv($strT,'-4'),QTconv($body,'-4'),QTI_HTML_CHAR);
	
		unset($_SESSION['qtiGoto']);
		$oVIP->selfurl = "";
		$oVIP->exiturl = "#";
		$oVIP->exitname = '';
		$oVIP->EndMessage(NULL,"Account registered. Proceed to login at <a target='_blank' href='http://www.wavuh.com'>www.wavuh.com</a>",$_SESSION[QT]['skin_dir'],2);
  }
}

?>
<form id="form1" name="form1" method="post" action="" >
  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="ta ta_o">
    <?php echo (!empty($qti_error) ?  '<tr><td class="error" colspan=4>'.$qti_error.'</td></tr>' : '') ?>
    <tr>
      <td colspan="2"><strong>KINDLY FILL IN ALL DETAILS TO REGISTER</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%">Organization Name </td>
      <td width="50%"><input name="name" size="50" type="text" id="name" value="<?php echo $row['Name']; ?>" /></td>
    </tr>
    <tr>
      <td>Industry</td>
      <td><select name="industry" id="industry" class="required">
          <option value="<?php echo $row['IndustryID'];?>"><?php echo $row['Industry'];?></option>
          <?php 
				$oDB->Query('SELECT * FROM industry WHERE ActiveInd=1 ORDER BY Industry ASC');
				$row2 = $oDB->Getrow();
				do
				{
					if ($row['IndustryID'] != $row2['Industry_ID']){
						echo '<option value=',$row2['Industry_ID'].'>',$row2['Industry'],'</option>',N;
					}
				}while ( $row2 = $oDB->Getrow() );
				?>
        </select>
         <!-- <input name="ind" type="text" id="ind" value="<?php echo $row['Industry_']; ?>" />--></td>
    </tr>
    <tr>
      <td>Name</td>
      <td><span class="td_o">
        <select name="title">
          <option value="<?php echo $row['Title'];?>"><?php echo $row['Title'];?></option>
          <option value="Mr">Mr</option>
          <option value="Ms">Ms</option>
          <option value="Mrs">Mrs</option>
          <option value="Dr">Dr</option>
          <option value="Prof">Prof</option>
        </select>
        <input name="fname" type="text" id="fname" value="<?php echo $row['First_Name']; ?>" size="15" />
        <input name="lname" type="text" id="lname" value="<?php echo $row['Last_Name']; ?>" size="18" />
      </span></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input name="email" type="text" id="email" value="<?php echo $row['Email']; ?>" /></td>
    </tr>
    <tr>
      <td>Contact Username </td>
      <td><label>
        <input name="username" type="text" id="username" class="required"/>
      </label></td>
    </tr>
    <tr>
      <td valign="top">Password</td>
      <td valign="top"><label>
        <input name="password" type="password" id="password" class="required"/>
      </label></td>
    </tr>
    <tr>
      <td>Confirm password </td>
      <td><label>
        <input name="cpassword" type="password" id="cpassword" class="required"/>
        </label>      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php //if ($oVIP->CanSave($oVIP->selfurl)==true) {?>
          <input type="submit" name="Save" value="Save Details" /></td>
      <?php //}?>
    </tr>
  </table>
</form>