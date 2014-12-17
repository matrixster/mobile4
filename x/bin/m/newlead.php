<style type="text/css">
td { font-family:Verdana, Arial, sans-serif; font-size:9pt; text-decoration:none; }
a { color:#0000FF; background-color:inherit; text-decoration:none; }
</style>

<?php
require_once('../w_init.php');

$api = -1;
if (isset($_GET['api'])) $api = intval($_GET['api']);
if (isset($_POST['api'])) $api = intval($_POST['api']);



if ( isset($_POST['Save']) )
{
  // check form
  	  $strTl = "";//trim($_POST['title']);
	  $strF = trim($_POST['fname']); if ( get_magic_quotes_gpc() ) $strF = stripslashes($strF);
	  $strL = trim($_POST['lname']); if ( get_magic_quotes_gpc() ) $strL = stripslashes($strL);
  	  $strS = "Call Me Form";//trim($_POST['source']); if ( get_magic_quotes_gpc() ) $strS = stripslashes($strS);
	  $strD = "";//trim($_POST['dob']); if ( get_magic_quotes_gpc() ) $strD = stripslashes($strD);
	  $strDt = "";//trim($_POST['dept']); if ( get_magic_quotes_gpc() ) $strDt = stripslashes($strDt);
	  $strB = "";//trim($_POST['biz']); if ( get_magic_quotes_gpc() ) $strB = stripslashes($strB);
	  $strN = "";//trim($_POST['name']); if ( get_magic_quotes_gpc() ) $strN = stripslashes($strN);
	  $strI = "";//trim($_POST['industry']); if ( get_magic_quotes_gpc() ) $strI = stripslashes($strI);
	  $strR = "";//trim($_POST['revenue']); if ( get_magic_quotes_gpc() ) $strR = stripslashes($strR);
	  $strTy = "";//trim($_POST['type']); if ( get_magic_quotes_gpc() ) $strTy = stripslashes($strTy);
	  $strM = 1;//intval($_POST['employees']);
	  $strPd = "";//trim($_POST['pad']); if ( get_magic_quotes_gpc() ) $strPd = stripslashes($strPd);
  	  $strCd = "";//trim($_POST['cad']); if ( get_magic_quotes_gpc() ) $strCd = stripslashes($strCd);
	  $strT = trim($_POST['tel']); if ( get_magic_quotes_gpc() ) $strT = stripslashes($strT);
	  $strF1 = "";//trim($_POST['city']); if ( get_magic_quotes_gpc() ) $strF = stripslashes($strF);
	  $strCnt = trim($_POST['contact']); if ( get_magic_quotes_gpc() ) $strCnt = stripslashes($strCnt);
	  $strE = trim($_POST['email']); if ( get_magic_quotes_gpc() ) $strE = stripslashes($strE);
	  $strW = "";//trim($_POST['website']); if ( get_magic_quotes_gpc() ) $strW = stripslashes($strW);
	  $strAs = intval($api);
	  $strS = "Open";
	  $strCmt = "";//trim($_POST['comment']); if ( get_magic_quotes_gpc() ) $strCmt = stripslashes($strCmt);
	  if ( $_POST['active'] == TRUE ) {$strA = '1'; } ELSE { $strA = '0'; }
	  
	  if ( empty($qti_error) )
	  {
	  	
		$oDB->Query('INSERT INTO contact (Address_1, Address_2,  Email, Tel_1, City, Website) VALUES("'.addslashes($strPd).'", "'.addslashes($strCd).'", "'.addslashes($strE).'", "'.addslashes($strT).'" , "'.addslashes($strF1).'", "'.addslashes($strW).'")');
		$oDB->Query('SELECT Contact_ID from contact ORDER BY Contact_ID DESC LIMIT 0, 1');
		$row = $oDB->Getrow();
		$oDB->Query('INSERT INTO crm_lead (Title, First_Name, Last_Name, DOB, Dept, Biz, Contact_ID, Lead_Source, Industry, Type, Revenue, Employees, Status, Assigned_To, Descr, ActiveInd, CreateBy, CreateDt, ModBy, ModDt) VALUES (
			"'.addslashes($strTl).'", "'.addslashes($strF).'", "'.addslashes($strL).'", "'.addslashes($strD).'", "'.addslashes($strDt).'", "'.addslashes($strB).'", '.intval($row['Contact_ID']).', "'.addslashes($strS).'", "'.addslashes($strI).'", "'.addslashes($strTy).'", '.floatval($strR).', '.intval($strM).', "'.$strS.'", '.intval($strAs).', "'.addslashes($strCmt).'", 1,'.$api.', "'.date('Y-m-d H:i:s').'", '.$api.', "'.date('Y-m-d H:i:s').'")');
		// exit
	
		unset($_SESSION['qtiGoto']);
		$oVIP->exiturl = "#";
		$oVIP->selfname = 'Contact us';
		$oVIP->exitname = '';
		$oVIP->EndMessage(NULL,"Thank you for getting in touch. Someone will call you shortly.",$_SESSION[QT]['skin_dir'],2);
  }
}
?>
<form id="form1" name="form1" method="post" action="" >
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td colspan="2">Kindly fill in your details and we'll get back to you </td>
    </tr>
    <tr>
      <td width="28%">First Name</td>
      <td width="72%"><input name="fname" type="text" id="fname" value="<?php echo $row['First_Name']; ?>" /></td>
    </tr>
    <tr>
      <td>Last Name </td>
      <td><input name="lname" type="text" id="lname" value="<?php echo $row['Last_Name']; ?>" /></td>
    </tr>
    <tr>
      <td>Telephone</td>
      <td><input name="tel" type="text" id="tel" value="<?php echo $row['Tel_1']; ?>" /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input name="email" type="text" id="email" value="<?php echo $row['Email']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp; </td>
      <td>
      <input type="hidden" name="contact" value="<?php echo $row['ContactID'];?>"/>
	  <?php //if ($oVIP->CanSave($oVIP->selfurl)==true) {?>
	  <input type="submit" name="Save" value="Contact me">
	  <?php 
	  if ($id!=-1 && $row){
	  	echo '<input type="submit" name="Convert" value="Convert to Account">';
	  }
	  ?>	  </td>
    </tr>
  </table>
</form>
