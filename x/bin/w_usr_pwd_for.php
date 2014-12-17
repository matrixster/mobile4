<?php

/*
 * PHP versions 4 and 5
 *
 * @package    QHR
 * @author     Patrick Muteti <pmuteti@sharaworld.com>
 * @copyright  2008-2012 The PHP Group
 * @license    http://www.php.net/license  PHP License 3.0
 * @version    1.1.0.1 build:20090101
 * @since      File available since Release 1.0.0
 *
 */

session_start();
require_once('bin/qti_init.php');
if ( !$oVIP->CanAccess('V',0,true) ) die($L['E_access']);

// INITIALISE

include('bin/qt_lib_smtp.php');
include($_SESSION[QT]['language'].'/qti_lang_reg.inc');

$oVIP->selfurl = 'qti_usr_pwd_for.php';
$oVIP->selfname = $L['Forgotten_pwd'];
$oVIP->exiturl = 'qti_index.php';
$oVIP->exitname = $L['Section'];

$strTitle = '';
$strMail = '';

// --------
// SUBMITTED
// --------

if ( isset($_POST['ok']) )
{
  // check value

  $strTitle = trim(strip_tags($_POST['title'])); if ( get_magic_quotes_gpc() ) $strTitle = stripslashes($strTitle);
  $strTitle = QTconv($strTitle,'U');
  if (!QTislogin($strTitle,2)) $qti_error=$L['Username'].S.$L['E_invalid'];

  $strMail = trim(strip_tags($_POST['mail']));
  if (!QTismail($strMail)) $qti_error=$L['Email'].S.$L['E_invalid'];

  if ( empty($qti_error) )
  {
    // check login exists
    $oDB->Query('SELECT count(id) as countid FROM '.TABUSER.' WHERE name="'.$strTitle.'" and mail="'.$strMail.'"');
    $row = $oDB->Getrow();
    if ($row['countid']!=1) $qti_error=$L['Username'].'/'.$L['Email'].S.$L['E_invalid'];

    // read user info
    $oDB->Query('SELECT parentmail,children FROM '.TABUSER.' WHERE name="'.$strTitle.'" AND mail="'.$strMail.'"');
    $row = $oDB->Getrow();
    $strParentmail = $row['parentmail'];
    $strChildren = $row['children'];

    // execute
    if ( empty($qti_error) )
    {
      $newpwd = 'qt'.rand(0,9).rand(0,9).rand(0,9).rand(0,9);
      $oDB->Query('UPDATE '.TABUSER.' SET pwd="'.sha1($newpwd).'" WHERE name="'.$strTitle.'" AND mail="'.$strMail.'"');

      // send email
      $strSubject = $_SESSION[QT]['site_name'].' - New password';
      $strMessage="Please find here after a new password to access the board {$_SESSION[QT]['site_name']}.\nLogin: %s\nPassword: %s";
      $strFile = $_SESSION[QT]['language'].'/mail_pwd.inc';
      if ( file_exists($strFile) ) include($strFile);
      $strMessage = sprintf($strMessage,$strTitle,$newpwd);
      QTmail($strMail,QTconv($strSubject,'-4'),QTconv($strMessage,'-4'),QTI_HTML_CHAR);
      $strEndmessage = str_replace("\n",'<br/>',$strMessage);

      // send parent email (if coppa)
      if ( QTI_USE_COPPA && $strChildren!='0' )
      {
        $strSubject = $_SESSION[QT]['site_name'].' - New password';
        $strMessage="Here is then new password of your children.\nLogin: %s\nPassword: %s";
        $strFile = $_SESSION[QT]['language'].'/mail_pwd_coppa.inc';
        if ( file_exists($strFile) ) { include($strFile); }
        $strMessage = sprintf($strMessage, $strTitle,$newpwd);
        QTmail($_POST['parentmail'],QTconv($strSubject,'-4'),QTconv($strMessage,'-4'),QTI_HTML_CHAR);
      }

      // exit
      if ( $_SESSION[QT]['register_mode']!='direct' ) $strEndmessage='';
      $oVIP->EndMessage(NULL,$L['S_update'].'<br/><br/>'.$strEndmessage,$_SESSION[QT]['skin_dir'],0);
    }
  }
}

// --------
// HTML START
// --------

include('qti_p_header.php');

echo '
<script type="text/javascript">
<!--
function ValidateForm(theForm)
{
  if (theForm.title.value.length==0) { alert(html_entity_decode("',$L['E_mandatory'],': ',$L['Username'],'")); return false; }
  if (theForm.mail.value.length==0) { alert(html_entity_decode("',$L['E_mandatory'],': ',$L['Email'],'")); return false; }
  return null;
}
-->
</script>
';

HtmlMsg(0,'350px','login_header',$oVIP->selfname);
echo '
<form method="post" action="',$oVIP->selfurl,'" onsubmit="return ValidateForm(this);">
<p>',$L['Reg_pass'],'</p>
<p style="text-align:right">',$L['Username'],'&nbsp;<input type="text" id="title" name="title" size="24" maxlength="24" value="',$strTitle,'"/></p>
<p style="text-align:right">',$L['Email'],'&nbsp;<input type="text" id="mail" name="mail" size="24" maxlength="64" value="',$strMail,'" onKeyUp="handle_keypress(event,\'ok\')"/></p>
<p style="text-align:right">',(!empty($qti_error) ? '<span class="error">'.$qti_error.'</span> ' : ''),'
<input type="submit" id="ok" name="ok" value="',$L['Ok'],'"/></p>
</form>
';
HtmlMsg(1);

// HTML END

include('qti_p_footer.php');

?>