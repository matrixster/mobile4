<?php
session_start();
require_once('../../bin/w_init.php');

$oVIP->selfurl = 'account.php';
$oVIP->selfname = 'sign up';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

$_SESSION[QT]['admin_email'] = "support@wavuh.com";
$strIN = "";

if ( isset($_POST['Save']) )
{
  // check form
	  $strN = trim($_POST['name']); if ( get_magic_quotes_gpc() ) $strN = stripslashes($strN);
	  $strI = intval($_POST['industry']);
	  $strD = trim($_POST['ind']); if ( get_magic_quotes_gpc() ) $strD = stripslashes($strD);
	  $strU = trim($_POST['username']); if ( get_magic_quotes_gpc() ) $strU = stripslashes($strU);
  	  $strP = trim($_POST['password']); if ( get_magic_quotes_gpc() ) $strP = stripslashes($strP);
	  $strC = trim($_POST['cpassword']); if ( get_magic_quotes_gpc() ) $strC = stripslashes($strC);
	  $strE = trim($_POST['email']); if ( get_magic_quotes_gpc() ) $strE = stripslashes($strE);
	  $strAs = trim($_POST['contact']); if ( get_magic_quotes_gpc() ) $strAs = stripslashes($strAs);
	  if (empty($strN) || empty($strP) || empty($strU) || empty($strC) ) { $qti_error="Please enter all the required details"; }
	  
	  if (isset($_POST['email']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',
		$_POST['email'])) {
		$strE = $_GET['email'];
	  } else {
	  	$qti_error="Please enter a valid email address.";
	  }
	  
	  $oDB->Query('SELECT * from `user` WHERE Closed=0 AND User = "'.$strU.'"');
	  $row1 = $oDB->Getrow();
	  if ($row1) { $qti_error = "Username already taken - please select another one. "; }
	  
	  
	  $oDB->Query('SELECT * from `user` U 
	  LEFT JOIN organization O ON O.Org_ID = U.Org_ID 
	  LEFT JOIN contact C ON O.Contact_ID = C.Contact_ID 
	  WHERE Closed=0 AND Email = "'.$strE.'"');
	  $row1 = $oDB->Getrow();
	  if ($row1) { $qti_error = $qti_error."The email already has an associated account."; }
	  
	  $oDB->Query('SELECT Industry from `industry` WHERE Industry_ID = '.$strI);
	  $row11 = $oDB->Getrow(); $strIN = $row11['Industry'];
	  
	  if ( empty($qti_error) )
	  {
	  
	  	/**/$oDB->Query('INSERT INTO contact (Email) VALUES("'.addslashes($strE).'")');
		$oDB->Query('SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
	  	$contact = $row['Contact_ID'];
		$oDB->Query('INSERT INTO organization (Name, Industry_ID, Industry, Contact_ID, CreateBy, CreateDt) VALUES("'.addslashes($strN).'", '.intval($strI).', "'.addslashes($strD).'", '.intval($contact).', 999, "'.date('Y-m-d H:i:s').'")');
		$oDB->Query('SELECT Org_ID from organization ORDER BY Org_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$oDB->Query('INSERT INTO user (User, Pwd, Org_ID, Closed, CreateBy, CreateDt) VALUES("'.addslashes($strU).'", "'.sha1($strP).'", '.$row['Org_ID'].', 0, 999,  "'.date('Y-m-d H:i:s').'")');
		$oDB->Query('SELECT User_ID from user ORDER BY User_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$user = $row['User_ID'];
		$oDB->Query('INSERT INTO profile (Profile, ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES("Sys Admin", 1, '.$user.', "'.date('Y-m-d H:i:s').'", '.$user.' ,"'.date('Y-m-d H:i:s').'")');
		$oDB->Query('SELECT Profile_ID from profile ORDER BY Profile_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$profile = $row['Profile_ID'];
		$oDB->Query('UPDATE user SET Profile_ID='.$profile.' WHERE User_ID='.$user);
		
		$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',7)');
		$oDB->Query('INSERT INTO `form_rights`(Form_ID, Profile_ID, `View`, `Save`, `Delete`, `Review`, `Approve`) VALUES (39, '.$profile.', 1, 1, 1, 1, 1)');
		$oDB->Query('INSERT INTO `form_rights`(Form_ID, Profile_ID, `View`, `Save`, `Delete`, `Review`, `Approve`) VALUES (41, '.$profile.', 1, 1, 1, 1, 1)');
		
		$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',9)');
		$oDB->Query('INSERT INTO `form_rights`(Form_ID, Profile_ID, `View`, `Save`, `Delete`, `Review`, `Approve`) VALUES (117, '.$profile.', 1, 1, 1, 1, 1)');/**/
		
		if ($_POST['hr'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID) VALUES('.$profile.',1)');
			$oVIP->addFormRights(1, $profile);
		}
		if ($_POST['crm'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',10)');
			$oVIP->addFormRights(10, $profile);
		}
		if ($_POST['payroll'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',8)');
			$oVIP->addFormRights(8, $profile);
		}
		if ($_POST['asset'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',4)');
			$oVIP->addFormRights(4, $profile);
		}
		if ($_POST['inventory'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',2)');
			$oVIP->addFormRights(2, $profile);
		}
		if ($_POST['procurement'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',3)');
			$oVIP->addFormRights(3, $profile);
		}
		if ($_POST['accounting'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',5)');
			$oVIP->addFormRights(5, $profile);
		}
		if ($_POST['project'] == TRUE){
			$oDB->Query('INSERT INTO module_rights (Profile_ID, Module_ID)  VALUES('.$profile.',6)');
			$oVIP->addFormRights(6, $profile);
		}

		/**/
		// exit
		//notify the user of the registration
		$strT = "Wavuh Registration\r\n";
		$body = "Dear ".$strU."\r\n\r\nYou have successfully registered to use Wavuh ERP. This account is on a trial basis for 15 days after which you shall be required to purchase full account access. You can contact us via sales@wavuh.com to have that setup. \r\n\r\nYour feedback on how to make Wavuh better will also be greatly appreciated.\r\n\r\nRegards\r\nThe Wavuh Team\r\n";
		QTmail($strE,QTconv($strT,'-4'),QTconv($body,'-4'),QTI_HTML_CHAR);
	
		//leave the page to the login page
		unset($_SESSION['qtiGoto']);
		$oVIP->exiturl = "http://wavuh.com";
		$oVIP->exitname = '';
		$oVIP->EndMessage(NULL,"Account details registered. Proceed to login.",$_SESSION[QT]['skin_dir'],2);
  }
}
include("../../header_old.php");
?>
<form id="form1" name="form1" method="post" action="" >
  <table width="100%" border="0" cellspacing="2" cellpadding="4" class="ta ta_o">
    <?php echo (!empty($qti_error) ?  '<tr><td class="error" colspan=4>'.$qti_error.'</td></tr>' : '') ?>
    <tr>
      <td colspan="2"><strong>KINDLY FILL IN ALL DETAILS TO REGISTER </strong></td>
    </tr>
    <tr>
      <td width="41%"><div align="right">Organization Name </div></td>
      <td width="59%"><input name="name" class="required" size="50" type="text" id="name" value="<?php echo $strN; ?>" /></td>
    </tr>
    <tr>
      <td><div align="right">Industry</div></td>
      <td><select name="industry" id="industry" class="required">
          <option value="<?php echo $strI;?>"><?php echo $strIN;?></option>
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
      <td><div align="right">Email</div></td>
      <td><input name="email" type="text" class="email" value="<?php echo  $strE; ?>" size="50" /></td>
    </tr>
    <tr>
      <td><div align="right">Contact Username </div></td>
      <td><label>
        <input name="username" type="text" class="required" id="username" value="<?php echo $strU; ?>" size="50"/>
      </label></td>
    </tr>
    <tr>
      <td valign="top"><div align="right">Password</div></td>
      <td valign="top"><label>
        <input name="password" type="password" class="required" id="password" value="<?php echo $strP; ?>" size="50"/>
      </label></td>
    </tr>
    <tr>
      <td><div align="right">Confirm password </div></td>
      <td><label>
        <input name="cpassword" type="password" class="required" id="cpassword" value="<?php echo $strC; ?>" size="50"/>
        </label>      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><div align="left"><strong>KINDLY SELECT THE MODULES YOU ARE INTERESTED IN </strong></div></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
	    <table width="736" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td width="209"><span style="text-align:left">
              <input type="checkbox" name="hr" <?php if ($_POST['hr']==true) echo "checked='checked'";?> />
HR</span></td>
            <td width="189"><span style="text-align:left">
              <input type="checkbox" name="crm" <?php if ($_POST['crm']==true) echo "checked='checked'";?> />
CRM</span></td>
            <td width="169"><span style="text-align:left">
              <input type="checkbox" name="payroll" <?php if ($_POST['payroll']==true) echo "checked='checked'";?> /> 
              Payroll
</span></td>
            <td width="180"><span style="text-align:left">
              <label>
              <input type="checkbox" name="inventory" <?php if ($_POST['inventory']==true) echo "checked='checked'";?> />
Inventory</label>
              <label> </label>
            </span></td>
          </tr>
          <tr>
            <td><span style="text-align:left">
              <input type="checkbox" name="procurement" <?php if ($_POST['procurement']==true) echo "checked='checked'";?> />
Procurement</span></td>
            <td><span style="text-align:left">
              <input type="checkbox" name="asset" <?php if ($_POST['asset']==true) echo "checked='checked'";?> />
Asset Management</span></td>
            <td><span style="text-align:left">
              <label>
              <input type="checkbox" name="accounting" <?php if ($_POST['accounting']==true) echo "checked='checked'";?> />
Accounting</label>
              <label> </label>
            </span></td>
            <td><span style="text-align:left">
              <label>
              <input type="checkbox" name="project" <?php if ($_POST['project']==true) echo "checked='checked'";?> />
Project Management</label>
            </span></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        By clicking the Register button below I imply that I have read and agreed to the<a target="_blank" href="terms-of-service.php"> terms of service </a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php //if ($oVIP->CanSave($oVIP->selfurl)==true) {?>
          <input type="submit" name="Save" value="Register" /></td>
      <?php //}?>
    </tr>
	 <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  
</form>
<?php include("../../footer_old.php"); ?>