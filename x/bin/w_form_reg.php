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
require_once('w_init.php');
if ( !$oVIP->CanAccess('V',0,true) ) $oVIP->EndMessage('!',$L['R_member'],$_SESSION[QT]['skin_dir'],0);

$emp = -1;
if (isset($_GET['id'])) $emp = intval($_GET['id']);
if (isset($_POST['id'])) $emp = intval($_POST['id']);

// INITIALISE

//include('bin/qt_lib_smtp.php');
//include($_SESSION[QT]['language'].'/qti_lang_reg.inc');

$oVIP->selfurl = 'qhr_form_reg.php';
$oVIP->selfname = 'Register User';

$strChild = '0';
if ( isset($_GET['c']) ) $strChild = $_GET['c'];
if ( isset($_POST['child']) ) $strChild = $_POST['child'];

// --------
// SUBMITTED
// --------

if ( isset($_POST['ok']) )
{
  // pre-checks
  if ( empty($_POST['mail']) ) $qti_error='Email'.S.'E_invalid';
  if ( empty($_POST['title']) ) $qti_error='Username'.S.'E_invalid';
  if ( $_SESSION[QT]['register_safe']<>'none' )
  {
  if ( trim($_POST['code'])=='' ) $qti_error = $L['Type_code'];
  if ( strlen($_POST['code'])<>6 ) $qti_error = $L['Type_code'];
  }

  // check name
  if ( empty($qti_error) )
  {
    if ( get_magic_quotes_gpc() ) $_POST['title'] = stripslashes($_POST['title']);
    $_POST['title'] = QTconv($_POST['title'],'U');
    if ( !QTislogin($_POST['title']) ) $qti_error='Username'.S.' invalid';
    if ( empty($qti_error) )
    {
    $oDB->Query('SELECT count(id) as countid FROM '.TABUSER.' WHERE name="'.$_POST['title'].'"');
    $row = $oDB->Getrow();
    if ($row['countid']!=0) $qti_error='Username'.S.' already used';
    }
  }
	
  if ( empty($qti_error) )
	{
	$oDB->Query('SELECT count(id) as countid FROM '.TABUSER.' WHERE Employer_ID='.$emp);
	$row = $oDB->Getrow();
	if ($row['countid']!=0) $qti_error='Employer'.S.' already registered';
  }
  // check mail
  if ( empty($qti_error) )
  {
    $_POST['mail'] = trim($_POST['mail']);
    if (!QTismail($_POST['mail'])) $qti_error='Email'.S.' invalid';
    if ( empty($qti_error) )
    {
    $oDB->Query('SELECT count(id) as countid FROM '.TABUSER.' WHERE mail="'.$_POST['mail'].'"');
    $row = $oDB->Getrow();
    if ($row['countid']!=0) $qti_error='Email'.S.' already used';
    }
  }

  // check parentmail
  if ( QTI_USE_COPPA ) {
  if ( empty($qti_error) ) {
  if ( $strChild!='0' ) {
    $_POST['parentmail'] = trim($_POST['parentmail']);
    if ( !QTismail($_POST['parentmail']) ) $qti_error=$L['Parent_mail'].S.$L['E_invalid'];
  }}}
  if ( !isset($_POST['parentmail']) ) $_POST['parentmail'] = '';

  // check password
  if ( empty($qti_error) && $_SESSION[QT]['register_mode']=='direct' )
  {
    if ( get_magic_quotes_gpc() ) $_POST['pwd'] = stripslashes($_POST['pwd']);
    $_POST['pwd'] = QTconv($_POST['pwd'],'U');
    if ( !QTispassword($_POST['pwd']) ) $qti_error = $L['Password'].S.$L['E_invalid'];

    if ( get_magic_quotes_gpc() ) $_POST['conpwd'] = stripslashes($_POST['conpwd']);
    $_POST['conpwd'] = QTconv($_POST['conpwd'],'U');
    if ( !QTispassword($_POST['conpwd']) ) $qti_error = $L['Password'].S.$L['E_invalid'];
  }
  if ( empty($qti_error) && $_SESSION[QT]['register_mode']=='direct' )
  {
    if ( $_POST['conpwd']!=$_POST['pwd'] ) $qti_error = $L['Password'].S.$L['E_invalid'];
  }

  // check code
  if ( empty($qti_error) )
  {
    if ( $_SESSION[QT]['register_safe']<>'none' )
    {
    $strCode = strtoupper(strip_tags(trim($_POST['code'])));
    if ($strCode=='') $qti_error = $L['Type_code'];
    if ( $_SESSION['textcolor'] <> sha1($strCode) ) $qti_error = $L['Type_code'];
    }
  }

  // --------
  // register user
  // --------
  if ( empty($qti_error) )
  {
    // email code
    if ( $_SESSION[QT]['register_mode']=='email' ) $_POST['pwd'] = 'QT'.rand(0,9).rand(0,9).rand(0,9).rand(0,9);

    $id = Nextid(TABUSER);
    $oDB->Query( 'INSERT INTO '.TABUSER.' (id,name,pwd,Employer_ID,closed,role,mail,privacy,firstdate,lastdate,numpost,children,parentmail,avatar) VALUES ('.$id.',"'.$_POST['title'].'","'.sha1($_POST['pwd']).'",'.$emp.',"0","U","'.$_POST['mail'].'","1","'.Date('Ymd His').'","'.Date('Ymd His').'",0,"'.$strChild.'","'.$_POST['parentmail'].'","0")' );

    // Unregister global sys (will be recomputed on next page)
    unset($_SESSION[QT]['sys_members']);
    unset($_SESSION[QT]['sys_newuserid']);

    // send email
    $strSubject = $_SESSION[QT]['site_name'].' - Welcome';
    $strMessage = "Please find here after your login and password to access the board {$_SESSION[QT]['site_name']}.\nLogin: %s\nPassword: %s";
    $strFile = $_SESSION[QT]['language'].'/mail_registred.inc';
    if ( file_exists($strFile) ) include($strFile);
    $strMessage = sprintf($strMessage,$_POST['title'],$_POST['pwd']);
    //-----QTmail($_POST['mail'],QTconv($strSubject,'-4'),QTconv($strMessage,'-4'),QTI_HTML_CHAR);

    // parent mail
    if ( QTI_USE_COPPA ) {
    if ( $strChild!='0' ) {
      $strSubject = $_SESSION[QT]['site_name'].' - Welcome';
      $strMessage = "We inform you that your children has registered on the forum {$_SESSION[QT]['site_name']}.\nLogin: %s\nPassword: %s\nYour agreement is required to activte this account.";
      $strFile = $_SESSION[QT]['language'].'/mail_registred_coppa.inc';
      if ( file_exists($strFile) ) include($strFile);
      $strMessage = sprintf($strMessage,$_POST['title'],$_POST['pwd']);
      QTmail($_POST['parentmail'],QTconv($strSubject,'-4'),QTconv($strMessage,'-4'),QTI_HTML_CHAR);
    }}

    // END MESSAGE
    if ( $_SESSION[QT]['register_mode']=='email' )
    {
      $oVIP->exiturl = 'index.php';
      $oVIP->exitname = ObjectName('index','i',$_SESSION[QT]['index_name']);
    }
    else
    { 
      $L['Reg_mail'] = S;
      $oVIP->exiturl = 'qhr_login.php?dfltname='.urlencode($_POST['title']);
      $oVIP->exitname = $L['Login'];
    }
   // $oVIP->EndMessage(NULL,'<h2>Registration completed</h2><p>'.$L['Reg_mail'].'</p>',$_SESSION[QT]['skin_dir'],2,'350px','login_header','login');

  }
}

// --------
// HTML START
// --------

$arrCss = array('qhr_register.css');

$strHeaderAddScript = '
<script type="text/javascript" src="qhr_jquery.js"></script>
<script type="text/javascript">
<!--
function ValidateForm(theForm)
{
  if (theForm.title.value.length==0) { alert(html_entity_decode("E_mandatory: Choose_name")); return false; }
  if (theForm.mail.value.length==0) { alert(html_entity_decode("Mandatory: Your_mail")); return false; }
  if (theForm.code.value.length==0) { alert(html_entity_decode("Mandatory: Security")); return false; }
  if (theForm.code.value=="QT") { alert(html_entity_decode("Mandatory: Security")); return false; }
  return null;
}
function MinChar(strField,strValue)
{
  if ( strValue.length>0 && strValue.length<4 )
  {
  document.getElementById(strField+"_err").innerHTML="<br/>'.$L['E_min_4_char'].'";
  return null;
  }
  else
  {
  document.getElementById(strField+"_err").innerHTML="";
  return null;
  }
}
$(function() {
  $("#title").blur(function() {
    $.post("qti_j_exists.php",
       {f:"name",v:$("#title").val(),e1:"'.$L['E_min_4_char'].'",e2:"'.$L['E_already_used'].'"},
       function(data) { if ( data.length>0 ) document.getElementById("title_err").innerHTML=data; });
  });
});
-->
</script>
';

include('../header.php');

// DEFAULT VALUE RECOVERY (na)

if ( !isset($_POST['title']) ) $_POST['title']='';
if ( !isset($_POST['pwd']) ) $_POST['pwd']='';
if ( !isset($_POST['conpwd']) ) $_POST['conpwd']='';
if ( !isset($_POST['mail']) ) $_POST['mail']='';
if ( !isset($_POST['parentmail']) ) $_POST['parentmail']='';

if ( $_SESSION[QT]['register_safe']=='text' )
{
  $keycode = 'QT'.rand(0,9).rand(0,9).rand(0,9).rand(0,9);
  $_SESSION['textcolor'] = sha1($keycode);
}

// --------
// CONTENT
// --------

if ( QTI_USE_COPPA &&  $strChild!='0' )
{
  echo '<div class="scrollmessage">';
  $strFile = '../admin/sys_rules_coppa.txt';
  if ( file_exists($strFile) ) { include($strFile); } else { echo 'Missing file:<br/>',$strFile; }
  echo '</div>';
}

HtmlMsg(0,'620px','login_header',$oVIP->selfname);

echo '
<form method="post" action="',$oVIP->selfurl,'" onsubmit="return ValidateForm(this);">
<table class="ta_hidden" cellspacing="0">
<tr class="tr_hidden">
<td class="td_hidden" style="width: 370px;">
<div id="login">
<fieldset class="fs_register">
<legend>Username</legend>
<span class="small">Choose username</span>&nbsp;
<input type="text" id="title" name="title" size="20" maxlength="24" value="',$_POST['title'],'" onfocus="document.getElementById(\'title_err\').innerHTML=\'\';"/><br/><span id="title_err" class="error"></span><br/>
';
if ( $_SESSION[QT]['register_mode']=='direct' )
{
echo '<span class="small">Choose password</span>&nbsp;<input type="password" id="pwd" name="pwd" size="20" maxlength="24" value="',$_POST['pwd'],'" onblur="MinChar(this.name,this.value)"/><span id="pwd_err" class="error"></span><br/>';
echo '<span class="small">Confirm password</span>&nbsp;<input type="password" id="conpwd" name="conpwd" size="20" maxlength="24" value="',$_POST['conpwd'],'" onblur="MinChar(this.name,this.value)"/><span id="conpwd_err" class="error"></span><br/>';
}
else
{
echo '<span class="small">Password by mail</span><br/>';
}
echo '
</fieldset>
<fieldset class="fs_register">
<legend>Email</legend>
<span class="small">Your_mail</span>&nbsp;<input type="text" id="mail" name="mail" size="32" maxlength="64" value="',$_POST['mail'],'"/><span id="mail_err" class="error"></span><br/>
';
if ( QTI_USE_COPPA && $strChild!='0' ) echo ' <span class="small">',$L['Parent_mail'],'</span>&nbsp;<input type="text" id="parentmail" name="parentmail" size="32" maxlength="64" value="',$_POST['parentmail'],'"/><br/>';
echo '
</fieldset>
<fieldset class="fs_register">
<legend>Security</legend>
';
if ( $_SESSION[QT]['register_safe']=='image' ) echo '<img width="100" height="35" src="../admin/qti_icode.php" alt="security" style="text-align:right"/> <input type="text" name="code" size="8" maxlength="8" value="QT"/><br/><span class="small">Type code</span>';
if ( $_SESSION[QT]['register_safe']=='text' ) echo $keycode,'&nbsp;<input type="text" id="code" name="code" size="8" maxlength="8" value="QT"/><br/><span class="small">Type code</span>';
echo '
</fieldset>
<input type="hidden" name="child" value="',$strChild,'"/>
',(!empty($qti_error) ? '<p class="error">'.$qti_error.'</p>' : ''),'<input type="submit" name="ok" value="Register"/>
</div>
</td>
<td class="td_hidden" style="width:20px;">&nbsp;</td>
<td class="td_hidden"><span class="small">&nbsp;</span></td>
</tr>
</table>
</form>
';

HtmlMsg(1);

// HTML END

include('../footer.php');

?>