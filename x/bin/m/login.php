<?php
session_start();
/*
 * PHP versions 4 and 5
 *
 * @package    Wavuh ERP
 * @author     Patrick Muteti <pmuteti@wavuh.com>
 * @copyright  2008-2012 The PHP Group
 * @license    http://www.php.net/license  PHP License 3.0
 * @version    1.1.0.1 build:20090101
 * @since      File available since Release 1.0.0
 *
 */

require_once('../w_init.php');

// INITIALISE

$oVIP->selfurl = 'login.php';
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
        if ( $oVIP->id<2 || $oVIP->role=='X')
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
       $oDB->Query( 'SELECT createdt FROM user WHERE User_ID='.$oVIP->id);
        $row = $oDB->Getrow();
        if ( $row['createdt']=='0' ) $row['lastdate']='20000101';
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
		  $oVIP->exiturl = "";
          $oVIP->EndMessage(NULL,"<h2>$strName ".strtolower($L['Is_banned'])."</h2><p>Access Denied. Please contact us for more details. </p>",$_SESSION[QT]['skin_dir'],0,'350px','login_header','login');
        }
		
		
      }
      // end message
	  if ($oVIP->carego==1){
		$oVIP->indent();
	  }
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

  unset($_SESSION['qtiGoto']);
  $oVIP->selfurl = 'login.php?a=out';
  $oVIP->selfname = 'Logout';
  $oVIP->exiturl = "login.php";
  $oVIP->exitname = 'Logout';
  $oVIP->EndMessage(NULL,"You have been logged off",$_SESSION[QT]['skin_dir'],2,'350px','login_header','login');
}}

// --------
// HTML START
// --------

//include('../../header_old.php');
include('../../header_old.php');
$oVIP->selfname = 'Login';

?>
<div id="container">
  <div class="rows">
	  <div class="row">
		  <div class="column w-60-percent">
		  		<div class="row">
					<div class="column w-100-percent"><p>
<h1> ERP made simple, affordable </h1>
</p></div>
					<div class="column w-100-percent"><img src="../../img/customer.gif" /><div style="height:51px;width:85%; float:right;"><b>CRM</b><br>understand and manage your customers at a glance</div></div>
					<div class="column w-100-percent"><img src="../../img/thumb.gif" /><div style="height:51px;width:85%; text-align:left; float:right;"><b>HR</b> <br/>manage and pay your staffers efficiently through payroll & HRM</div></div>
					<div class="column w-100-percent"><img src="../../img/finance.gif" /><div style="height:51px;width:85%; float:right;"><b>Financials</b> <br/>comprehensive accounting and statistics for your business</div></div>
					<div class="column w-100-percent"><img src="../../img/asset.gif" /><div style="height:51px;width:85%; float:right;"><b>Supply chain</b> <br/>take control of your assets, inventory &amp; procurement processes</div></div>
				</div>
		  </div>
		  <div class="column w-40-percent">
		  		<?php 
				HtmlMsg(0,'270px','login_header',$oVIP->selfname,'login');
				
				if ( !empty($qti_error) ) echo '<span class="error">',$qti_error,'</span>&nbsp;';
				?>
				<p>
				<form method="post" action="<?php $oVIP->selfurl; ?>" onsubmit="return ValidateForm(this);">
				<p style="text-align:right"><label for="title">Username</label>&nbsp;<input type="text" id="title" name="title" size="20" maxlength="24" value="<?php echo $strName; ?>"/>&nbsp;</p>
				<p style="text-align:right"><label for="pwd">Password</label>&nbsp;<input type="password" id="pwd" name="pwd" size="20" maxlength="24" onKeyUp="handle_keypress(event,\'ok\')"/>&nbsp;</p>
				<p style="text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" id="ok" name="ok" value="Sign in"/></br>
				<a href="lost-password.php">Forgot your password?</a>
				</p>
				<p>&nbsp;</p>
				</form>
				</p>
				<?php
				HtmlMsg(1);
				?>
		  </div>
		  <div class="clear-row">&nbsp;</div>
      </div>
      <div class="row">
          <div class="column w-60-percent"><p>Don't have a Wavuh Account? <a href="account.php">Get one here</a></p></div>
		  <div class="column w-40-percent">&nbsp;</div>
		  <div class="clear-row">&nbsp;</div>
      </div>
	  <div class="row">
          <div class="column w-60-percent"><hr style="height:1px;"><span style="vertical-align:top">Talk to us:</span> <a target="_blank" href="http://twitter.com/wavuh"><img src="../../img/twitter.jpg"></a> <a target="_blank" href="http://facebook.com/wavuh"><img src="../../img/fb.jpg"></a></div>
		  <div class="column w-40-percent">&nbsp;</div>
		  <div class="clear-row">&nbsp;</div>
      </div>
  </div>
</div>
<?php
// HTML END

$strFooterAddScript = 'document.getElementById("title").focus();
if ( document.getElementById("title").value.length>1 ) { document.getElementById("pwd").focus(); }';

include('../../footer_old.php');

?>
