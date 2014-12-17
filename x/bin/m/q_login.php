<?php
session_start();
/*
 * PHP versions 4 and 5
 *
 * @package    QHR
 * @author     Patrick Muteti <pmuteti@wavuh.com>
 * @copyright  2008-2012 The PHP Group
 * @license    http://www.php.net/license  PHP License 3.0
 * @version    1.1.0.1 build:20090101
 * @since      File available since Release 1.0.0
 *
 */

require_once('../w_init.php');

// INITIALISE

$oVIP->selfurl = 'q_login.php';
$oVIP->selfname = 'your complete ERP';
$_SESSION[QS]['site_name'] = $oVIP->selfname;


$strName = '';
if ( isset($_GET['dfltname']) )
{
  $strName=$_GET['dfltname']; if ( get_magic_quotes_gpc() ) $strName = stripslashes($strName);
  $strName=QTconv($strName,'U');
}

//user already logged in
if ($oVIP->username !='Guest' && !isset($_GET['a'])) {
	unset($_SESSION['qtiGoto']);
	$oVIP->selfname = 'User logged in';
	$oVIP->exiturl = "home.php";
    $oVIP->EndMessage(NULL,"You are already logged in.",$_SESSION[QT]['skin_dir'],2);
}

if (date('Y-m-d')=='2011-07-01'){
	$oDB->Query('UPDATE organization SET Suspended=1');
}
// --------
// SUBMITTED for login
// --------

if ( isset($_POST['ok']) )
{
	
	$strName = $_POST['title']; if ( get_magic_quotes_gpc() ) $strName = stripslashes($strName);
	$strName = QTconv($strName,'U');
	if ( !QTislogin($strName) ) $qti_error = 'Username not invalid';
	
	$strPwd = $_POST['pwd']; if ( get_magic_quotes_gpc() ) $strPwd = stripslashes($strPwd);
	$strPwd = QTconv($strPwd,'U');
	if ( !QTispassword($strPwd) ) $qti_error = 'Password not invalid';
	
  // EXECUTE

  if ( empty($qti_error) )//&& (count($results[0]) > 0)
  {
    $arrLog = $oVIP->Login($strName,$strPwd,isset($_POST['remember']));

    if ( $oVIP->auth )
    {

      // check banned
      if ( $arrLog['closed']>0 )
      {
        // protection against hacking of admin/moderator
        if ( $oVIP->id<2 || $oVIP->role=='A' || $oVIP->role=='M')
        {
        $oDB->Query('UPDATE user SET closed="0" WHERE User_ID='.$oVIP->id);
        $oVIP->exiturl = 'q_login.php?dfltname='.$strName;
        $oVIP->exitname = 'Login';
        $oVIP->EndMessage(NULL,'<p>You were banned...<br/>As you are admin/moderator or a new member (without post), the protection system has re-opened your account.<br/>Re-try login now...</p>',$_SESSION[QT]['skin_dir'],0);
        }
        // normal process
        $intDays = 1;
        if ( $arrLog['closed']==2 ) $intDays = 10;
        if ( $arrLog['closed']==3 ) $intDays = 20;
        if ( $arrLog['closed']==4 ) $intDays = 30;
        $oDB->Query( 'SELECT lastdate FROM user WHERE User_ID='.$oVIP->id);
        $row = $oDB->Getrow();
        if ( $row['lastdate']=='0' ) $row['lastdate']='20000101';
        $endban = DateAdd($row['lastdate'],$intDays,'day');
        if ( date('Ymd')>$endban )
        {
          $oDB->Query('UPDATE user SET closed="0" WHERE User_ID='.$oVIP->id);
          $oVIP->exiturl = 'qhr_usr_login.php?dfltname='.$strName;
          $oVIP->exitname = $L['Login'];
          $oVIP->EndMessage(NULL,'<p>'.$L['Is_banned_nomore'].'</p>',$_SESSION[QT]['skin_dir'],0,'350px','login_header','login');
        }
        else
        {
          $oVIP->auth=false;
          $_SESSION[QT.'_usr_auth']='no';
          $oVIP->EndMessage(NULL,"<h2>$strName ".strtolower($L['Is_banned'])."</h2><p>{'Access Denied'}</p><p>{'Retry tomorrow'}</p>",$_SESSION[QT]['skin_dir'],0,'350px','login_header','login');
        }
      }
      // end message

	  $oVIP->selfname = 'Personal Home page';
	  $oVIP->exiturl = "../../bin/m/home.php";

	  $oVIP->exitname = ObjectName('index','i',$_SESSION[QT]['index_name']);
      $oVIP->EndMessage(NULL,'<h2>'.$L['Welcome'].' '.$strName.'</h2><br/><br/>',$_SESSION[QT]['skin_dir'],2,'350px','login_header','login');
    }
    else
    {	
      $qti_error = $L['E_access'];
    }

  }

}

// --------
// SUBMITTED for loggout
// --------

if ( isset($_GET['a']) ) {
if ( $_GET['a']=='out' ) {

  // LOGGING OUT

  $oVIP->Logout();

  // REBOOT

  GetParam(true);

  // check major parameters
  /*if ( empty($_SESSION[QT]['skin_dir']) ) $_SESSION[QT]['skin_dir']='skin/default';
  if ( empty($_SESSION[QT]['language']) ) $_SESSION[QT]['language']='language/english';
  if ( empty($_SESSION[QT]['lang_iso']) ) $_SESSION[QT]['lang_iso']='en';
  if ( substr($_SESSION[QT]['skin_dir'],0,5)!='skin/' ) $_SESSION[QT]['skin_dir'] = 'skin/'.$_SESSION[QT]['skin_dir'];
  if ( substr($_SESSION[QT]['language'],0,9)!='language/' ) $_SESSION[QT]['language'] = 'language/'.$_SESSION[QT]['language'];
*/

  $oVIP->selfurl = 'q_login.php?a=out';
  $oVIP->selfname = 'Logout';
  $oVIP->exiturl = "q_login.php";
  $oVIP->exitname = ObjectName('index','i',$_SESSION[QT]['index_name']);
  $oVIP->EndMessage(NULL,'<p>'."Goodbye".'</p>', $_SESSION[QT]['skin_dir'],2,'350px','login_header','login');
}}

// --------
// HTML START
// --------

//include('../../header_old.php');
include('../../header_old.php');
$oVIP->selfname = 'Login';

?>
<table class="tt ta_t">
<tr><td width="50%" valign="top">
<p>
<h1> ERP made simple, affordable </h1>
</p>
<h4>Your business managed comprehensively in the following areas &nbsp;</h4>

<table width="500" border="0" cellspacing="3">
  <tr>
    <td><img src="../../img/customer.gif" /></td>
    <td valign="top"><b>CRM</b> <br/>      
      understand and manage your customers at a glance</td>
  </tr>
  <tr>
    <td><img src="../../img/thumb.gif" /></td>
    <td valign="top"><b>HR</b> <br/>manage and pay your staffers efficiently through payroll & HRM</td>
  </tr>
  <tr>
    <td><img src="../../img/finance.gif" /></td>
    <td valign="top"><b>Financials</b> <br/>your accounting and statistics in a nutshell</td>
  </tr>
  <tr>
    <td><img src="../../img/asset.gif" /></td>
    <td valign="top"><b>Supply chain</b> <br/>
    take  full control of your assets, inventory &amp; procurement process </td>
  </tr>
</table>
<hr />
<p>Don't have a Wavuh Account? <a href="account.php">Create one</a></p>
</td>
<td valign="top">
<?php 
HtmlMsg(0,'270px','login_header',$oVIP->selfname,'login');

if ( !empty($qti_error) ) echo '<span class="error">',$qti_error,'</span>&nbsp;';
?>
<p>
<form method="post" action="<?php $oVIP->selfurl; ?>" onsubmit="return ValidateForm(this);">
<p style="text-align:right"><label for="title">Username</label>&nbsp;<input type="text" id="title" name="title" size="20" maxlength="24" value="<?php echo $strName; ?>"/>&nbsp;</p>
<p style="text-align:right"><label for="pwd">Password</label>&nbsp;<input type="password" id="pwd" name="pwd" size="20" maxlength="24" onKeyUp="handle_keypress(event,\'ok\')"/>&nbsp;</p>
<p style="text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
<input type="submit" id="ok" name="ok" value="Sign in"/>&nbsp;</p>
<p>&nbsp;</p>
</form>
</p>
<?php
HtmlMsg(1);
?>
</td>
</tr>
</table>
<?php
// HTML END

$strFooterAddScript = 'document.getElementById("title").focus();
if ( document.getElementById("title").value.length>1 ) { document.getElementById("pwd").focus(); }';

include('../../footer_old.php');

?>