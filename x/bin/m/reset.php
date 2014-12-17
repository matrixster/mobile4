<?php

/*
 * PHP versions 4 and 5
 *
 * @package    Wavuh Ltd
 * @author     Patrick Muteti <patrick@wavuh.com>
 * @copyright  2008-2012 The PHP Group
 * @license    http://www.php.net/license  PHP License 3.0
 * @version    1.1.0.1 build:20090101
 * @since      File available since Release 1.0.0
 *
 */

session_start();
require_once('../w_init.php');
//if ( !$oVIP->CanAccess('MU',0,true) ) die('Not authorized');

// INITIALISE

//include('qt_lib_smtp.php');
include('../qhr_lang_reg.inc');


$s = -1;
if (isset($_GET['lng'])) $s = trim($_GET['lng']);
if (isset($_POST['lng'])) $s = trim($_POST['lng']);

$oVIP->selfname = 'Change password';
$oVIP->selfurl = 'reset.php?lng='.$s;
$_SESSION[QS]['site_name'] = $oVIP->selfname;


$oDB->Query('SELECT * FROM '.TABUSER.' WHERE sha1(User_ID)="'.$s.'"');
$row = $oDB->Getrow();


// --------
// SUBMITTED
// --------

if ( isset($_POST['ok']) )
{
  // CHECK VALUE
  $oDB->Query('SELECT * FROM '.TABUSER.' WHERE sha1(User_ID)="'.$s.'"');
  $row = $oDB->Getrow();
  
  $_POST['user'] = trim($_POST['user']); if ( get_magic_quotes_gpc() ) $_POST['user'] = stripslashes($_POST['user']);
  $_POST['user'] = QTconv($_POST['user'],'U');
  $_POST['newpwd'] = trim($_POST['newpwd']); if ( get_magic_quotes_gpc() ) $_POST['newpwd'] = stripslashes($_POST['newpwd']);
  $_POST['newpwd'] = QTconv($_POST['newpwd'],'U');
  $_POST['conpwd'] = trim($_POST['conpwd']); if ( get_magic_quotes_gpc() ) $_POST['conpwd'] = stripslashes($_POST['conpwd']);
  $_POST['conpwd'] = QTconv($_POST['conpwd'],'U');

  if ( $_POST['user']==$_POST['newpwd'] ) $qti_error="Your username cannot be your password. ";
  if ( $_POST['conpwd']!=$_POST['newpwd'] ) $qti_error=$qti_error."Your passwords do not match.";


  // EXECUTE

  if ( empty($qti_error) )
  {
    // save new password
    $oDB->Query('UPDATE '.TABUSER.' SET pwd="'.sha1($_POST['newpwd']).'" WHERE User_ID='.$row['User_ID']);

    // exit
    $oVIP->exiturl = '../../bin/m/login.php';
    $oVIP->exitname = $L['Profile'];
    $oVIP->EndMessage(NULL,'Password changed successfully',$_SESSION[QT]['skin_dir'],2);
  }
}

// --------
// HTML START
// --------

include('../../header_old.php');

// CHECK ACCESS RIGHT

if ( ( $oVIP->role!='A' ) && ($oVIP->id!=$id) ) die($L['R_member']);

// QUERY

// DISPLAY

echo '
<table class="ta_hidden" cellspacing="0">';
echo (!empty($qti_error) ?  '<tr><td class="error" colspan=4>'.$qti_error.'</td></tr>' : '');
echo'<tr class="tr_hidden">
<td class="td_hidden">
';

HtmlMsg(0,'350px','login_header',$oVIP->selfname,'login');
echo '
<script type="text/javascript">
<!--
function ValidateForm(theForm)
{
  if (theForm.title.value.length==0) { alert(html_entity_decode("Mandatory: Old password")); return false; }
  if (theForm.newpwd.value.length==0) { alert(html_entity_decode("Mandatory: New password")); return false; }
  if (theForm.conpwd.value.length==0) { alert(html_entity_decode("E_mandatory: Confirm password")); return false; }
  return null;
}
-->
</script>
';

echo '<form method="post" action="',$oVIP->selfurl,'" onsubmit="return ValidateForm(this);">
<p style="text-align:right">Username&nbsp;<input type="text" id="user" name="user" size="20" maxlength="24" value="',$row['User'],'"/></p>
<p style="text-align:right">New password&nbsp;<input type="password" id="newpwd" name="newpwd" size="20" maxlength="24"/></p>
<p style="text-align:right">Confirm password&nbsp;<input type="password" id="conpwd" name="conpwd" size="20" maxlength="24" onKeyUp="handle_keypress(event,\'ok\')"/></p>
<p style="text-align:right">
<input type="submit" id="ok" name="ok" value="Save"/></p>
</form>
';
HtmlMsg(1);

echo '
</td>
</tr>
</table>
';

// HTML END

$strFooterAddScript = 'document.getElementById("title").focus();';

include('../../footer_old.php');

?>