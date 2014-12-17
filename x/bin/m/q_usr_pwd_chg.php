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

$id = -1;
$id = $oVIP->id;
if ( $id<0 ) die('Missing parameters');

$s = -1;
if (isset($_GET['s'])) $s = intval($_GET['s']);
if (isset($_POST['s'])) $s = intval($_POST['s']);

if ($s!='new'){
$oVIP->selfurl = 'q_usr_pwd_chg.php';
}$oVIP->selfname = 'Change Password';

$oVIP->exiturl = '../../bin/m/home.php';
$oVIP->exitname = 'Password changed';
// --------
// SUBMITTED
// --------

if ( isset($_POST['ok']) )
{
  // CHECK VALUE
  $_POST['title'] = trim($_POST['title']); if ( get_magic_quotes_gpc() ) $_POST['title'] = stripslashes($_POST['title']);
  $_POST['title'] = QTconv($_POST['title'],'U');
  $_POST['newpwd'] = trim($_POST['newpwd']); if ( get_magic_quotes_gpc() ) $_POST['newpwd'] = stripslashes($_POST['newpwd']);
  $_POST['newpwd'] = QTconv($_POST['newpwd'],'U');
  $_POST['conpwd'] = trim($_POST['conpwd']); if ( get_magic_quotes_gpc() ) $_POST['conpwd'] = stripslashes($_POST['conpwd']);
  $_POST['conpwd'] = QTconv($_POST['conpwd'],'U');
  //if ( !QTispassword($_POST['title']) ) $qti_error=$L['Old_password'].S.$L['E_invalid'];
 // if ( !QTispassword($_POST['newpwd']) ) $qti_error=$L['New_password'].S.$L['E_invalid'];
 // if ( !QTispassword($_POST['conpwd']) ) $qti_error=$L['Confirm_password'].S.$L['E_invalid'];
  if ( $_POST['title']==$_POST['newpwd'] ) $qti_error=$L['New_password'].S.$L['E_invalid'];
  if ( $_POST['conpwd']!=$_POST['newpwd'] ) $qti_error=$L['Confirm_password'].S.$L['E_invalid'];

  // CHECK OLD PWD

  if ( empty($qti_error) )
  {
    $oDB->Query('SELECT count(User_ID) as countid FROM '.TABUSER.' WHERE User_ID='.$id.' AND pwd="'.sha1($_POST['title']).'"');
    $row = $oDB->Getrow();
    if ($row['countid']==0) $qti_error='Old password invalid';
  }

  // EXECUTE

  if ( empty($qti_error) )
  {
    // save new password
    $oDB->Query('UPDATE '.TABUSER.' SET pwd="'.sha1($_POST['newpwd']).'" WHERE User_ID='.$id);

    // exit
    $oVIP->exiturl = '../../bin/m/home.php';
    $oVIP->exitname = $L['Profile'];
    $oVIP->EndMessage(NULL,'Password changed successfully',$_SESSION[QT]['skin_dir'],2);
  }
}

// --------
// HTML START
// --------

include('../../header.php');

// CHECK ACCESS RIGHT

if ( ( $oVIP->role!='A' ) && ($oVIP->id!=$id) ) die($L['R_member']);

// QUERY

$oDB->Query('SELECT User, children FROM '.TABUSER.' WHERE User_ID='.$id);
$row = $oDB->Getrow();

// DISPLAY

echo '
<table class="ta_hidden" cellspacing="0">
<tr class="tr_hidden">
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
<p style="text-align:right">Old password&nbsp;<input type="password" id="title" name="title" size="20" maxlength="24"/></p>
<p style="text-align:right">New password&nbsp;<input type="password" id="newpwd" name="newpwd" size="20" maxlength="24"/></p>
<p style="text-align:right">Confirm password&nbsp;<input type="password" id="conpwd" name="conpwd" size="20" maxlength="24" onKeyUp="handle_keypress(event,\'ok\')"/></p>
<p style="text-align:right">';
if ( !empty($qti_error) ) echo '<span class="error">',$qti_error,' </span>';
echo '<input type="submit" id="ok" name="ok" value="Save"/></p>
<input type="hidden" name="id" value="',$id,'"/>
<input type="hidden" name="name" value="',$row['User'],'"/>
<input type="hidden" name="mail" value="',$row['mail'],'"/>
<input type="hidden" name="child" value="',$row['children'],'"/>
<input type="hidden" name="parentmail" value="',$row['parentmail'],'"/>
</form>
<p><a href="',$oVIP->exiturl,'?id=',$id,'">',$oVIP->exitname,'</a></p>
';
HtmlMsg(1);

echo '
</td>
</tr>
</table>
';

// HTML END

$strFooterAddScript = 'document.getElementById("title").focus();';

include('../../footer.php');

?>