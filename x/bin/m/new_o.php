<?php
session_start();
require_once('../../bin/w_init.php');

$id = -1;
if (isset($_GET['id'])) $id = intval($_GET['id']);
if (isset($_POST['id'])) $id = intval($_POST['id']);

$oVIP->selfurl = 'new_o.php';
$oVIP->selfname = 'Profile Management';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

/*$oDB->Query('SELECT *, O.Contact_ID AS ContactID, I.Industry_ID AS IndustryID FROM organization O 
LEFT JOIN contact C ON O.Contact_ID = C.Contact_ID
LEFT JOIN industry I ON O.Industry_ID = I.Industry_ID
LEFT JOIN user U ON O.Contact_User = U.User_ID 
WHERE O.Org_ID='.$oVIP->orgid);
$row = $oDB->Getrow();*/

if ( isset($_POST['Save']) )
{
  // check form
	  $strN = trim($_POST['name']); if ( get_magic_quotes_gpc() ) $strN = stripslashes($strN);
	  $strI = intval($_POST['industry']);
	  $strD = trim($_POST['ind']); if ( get_magic_quotes_gpc() ) $strD = stripslashes($strD);
	  $strE = trim($_POST['email']); if ( get_magic_quotes_gpc() ) $strE = stripslashes($strE);
	  $strW = trim($_POST['website']); if ( get_magic_quotes_gpc() ) $strW = stripslashes($strW);
	  $strAs = trim($_POST['contact']); if ( get_magic_quotes_gpc() ) $strAs = stripslashes($strAs);
	  $strCmt = trim($_POST['comment']); if ( get_magic_quotes_gpc() ) $strCmt = stripslashes($strCmt);
	  if ( $_POST['active'] == TRUE ) {$strA = '1'; } ELSE { $strA = '0'; }
	  
	  if ( empty($qti_error) )
	  {
		$oDB->Query('INSERT INTO contact (Address_1, Address_2,  Email, Tel_1, City, Website) VALUES("'.addslashes($strPd).'", "'.addslashes($strCd).'", "'.addslashes($strE).'", "'.addslashes($strT).'" , "'.addslashes($strF).'", "'.addslashes($strW).'")');
		$oDB->Query('SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$contact = $row['Contact_ID'];
		$oDB->Query('INSERT INTO user (User, Pwd,  Org_ID, Closed, Profile_ID=2, Role, CreateBy, CreateDt, ModBy, ModDt) VALUES("'.addslashes($strPd).'", "'.addslashes($strCd).'", "'.addslashes($strE).'", "'.addslashes($strT).'" , "'.addslashes($strF).'", "'.addslashes($strW).'")');
		$oDB->Query('SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$contact = $row['Contact_ID'];
		$oDB->Query('INSERT INTO organization (Name, Contact_ID, Industry_ID, Industry_, Contact_User, Description, ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
			"'.addslashes($strN).'", '.intval($contact).', '.intval($strI).', "'.addslashes($strD).'", '.intval($strR).', "'.$strCmt.'", 1,'.$oVIP->id.', "'.date('Y-m-d H:i:s').'", '.$oVIP->id.', "'.date('Y-m-d H:i:s').'")');	
		// exit
	
		unset($_SESSION['qtiGoto']);
		$oVIP->exiturl = "org.php";
		$oVIP->exitname = '';
		$oVIP->EndMessage(NULL,"Profile details saved",$_SESSION[QT]['skin_dir'],2);
  }
}
require_once('../../header.php');
?>
<form id="form1" name="form1" method="post" action="" >
  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="ta ta_o">
    <tr>
      <td width="20%"  class="th_o th_o_first">*Organization Name </td>
      <td width="30%" class="td_o"><input name="name" size="50" type="text" id="name" validation="required" /></td>
    </tr>
	<tr>
      <td class="th_o th_o_first">*Industry</td>
      <td class="td_o"><select name="industry" id="industry" validation="required">
          <option value="<?php echo $row['IndustryID'];?>"><?php echo $row['Industry'];?></option>
          <?php 
				$oDB->Query('SELECT * FROM industry WHERE ActiveInd=1');
				$row2 = $oDB->Getrow();
				do
				{
					if ($row['IndustryID'] != $row2['Industry_ID']){
						echo '<option value=',$row2['Industry_ID'].'>',$row2['Industry'],'</option>',N;
					}
				}while ( $row2 = $oDB->Getrow() );
				?>
      </select>&nbsp;<input name="ind" type="text" id="ind" value="<?php echo $row['Industry_']; ?>" /></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Email</td>
      <td class="td_o"><input name="email" type="text" id="email" validation="required"/></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Contact Person Username</td>
      <td class="td_o" colspan="3"><input name="email" type="text" id="username" validation="email"/></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Password</td>
      <td class="td_o" colspan="3"><input name="email" type="password" id="password" validation="required"/></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Confirm Password</td>
      <td class="td_o" colspan="3"><input name="email" type="password" id="cpassword" validation="required"/></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">&nbsp; </td>
      <td class="td_o" colspan="3">
	  <?php //if ($oVIP->CanSave($oVIP->selfurl)==true) {?>
	  <input type="submit" name="Save" value="Save Details"></td>
	  <?php //}?>
	  <input name="con" type="hidden" id="con" value="<?php echo $row['ContactID']; ?>"></td>
    </tr>
  </table>
</form>

<?php 
require_once('../../footer.php');
?>