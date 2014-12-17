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
//include ('../bin/config_ldap.php');
$_SESSION[QT]['index_name'] = 'Login';

// INITIALISE

$oVIP->selfurl = 'q_login.php';
$oVIP->selfname = 'Login';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

$strName = '';
if ( isset($_GET['dfltname']) )
{
  $strName=$_GET['dfltname']; if ( get_magic_quotes_gpc() ) $strName = stripslashes($strName);
  $strName=QTconv($strName,'U');
}

/*if ($oVIP->username !='Guest' && !isset($_GET['a'])) {
	unset($_SESSION['qtiGoto']);
	if ($oVIP->role=='A' || $oVIP->role=='X') {
		$oVIP->selfname = 'Employee Management';
		$oVIP->exiturl = "../employee/";
	} else {
		$oVIP->selfname = 'Personal Home page';
		$oVIP->exiturl = "../employee/home.php";
	}
$oVIP->EndMessage(NULL,"You are already logged in.",$_SESSION[QT]['skin_dir'],2);
}*/
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

	//connect to the LDAP server
	/*$ldap_link = ldap_connect(LDAP_SERVER, LDAP_PORT) or $qti_error = 'Could not contact authentication server';					

	if($ldap_link){
	
		//Set LDAP Protocol version
	
	ldap_set_option($ldap_link, LDAP_OPT_PROTOCOL_VERSION, 3);
   
	//ldap_bind($ldap_link, LDAP_USER, LDAP_PASSWORD) or die('Failed to bind to authentication server');

	ldap_bind($ldap_link, 'STRATHMORE\\'.$strName, $strPwd) or $qti_error = 'Invalid username or password';                                         			  
	#Search AD using samaccountname; unique identifier
	$filter = "(samaccountname=$strName)";                                        
	$ldap_data = ldap_search($ldap_link, LDAP_DC, $filter);
	$results = ldap_get_entries($ldap_link, $ldap_data);			   

	//Fetch LDAP attributs for the user

		/*if(count($results[0]) > 0){
	
			$_SESSION['currentUser']            = $username;
			//$_SESSION['displayName'] = $results[0]['displayname'][0];
			#Generate session key for the user
			$_SESSION['sessionKey'] = md5(gmmktime());
			#Redirect to home page
			header("Location: ../employee/?authToken=".$_SESSION['sessionKey']);
	
		}

	}*/

	

  // EXECUTE

  if ( empty($qti_error) )//&& (count($results[0]) > 0)
  {
    $arrLog = $oVIP->Login($strName,$strPwd,isset($_POST['remember']));

    if ( $oVIP->auth )
    {
      // check registered if children and coppa active (0=Adult, 1=Kid aggreed, 2=Kid not aggreed)
      if ( QTI_USE_COPPA ) {
      if ( isset($arrLog['coppa']) ) {
      if ( $arrLog['coppa']==2 ) {
        $oVIP->auth=false;
        $_SESSION[QT.'_usr_auth']='no';
        $oVIP->exitname = ObjectName('index','i',$_SESSION[QT]['index_name']);
        $oVIP->EndMessage(NULL,'<h2>'.$L['Welcome'].' '.$strName.'</h2>'.$L['E_access'].'<br/>'.$L['E_coppa_confirm'],$_SESSION[QT]['skin_dir'],0,'350px','login_header','login');
      }}}

      // check banned
      if ( $arrLog['closed']>0 )
      {
        // protection against hacking of admin/moderator
        if ( $oVIP->id<2 || $oVIP->role=='A' || $oVIP->role=='M' || $oVIP->numpost==0 )
        {
        $oDB->Query('UPDATE user SET closed="0" WHERE id='.$oVIP->id);
        $oVIP->exiturl = 'q_login.php?dfltname='.$strName;
        $oVIP->exitname = 'Login';
        $oVIP->EndMessage(NULL,'<p>You were banned...<br/>As you are admin/moderator or a new member (without post), the protection system has re-opened your account.<br/>Re-try login now...</p>',$_SESSION[QT]['skin_dir'],0);
        }
        // normal process
        $intDays = 1;
        if ( $arrLog['closed']==2 ) $intDays = 10;
        if ( $arrLog['closed']==3 ) $intDays = 20;
        if ( $arrLog['closed']==4 ) $intDays = 30;
        $oDB->Query( 'SELECT lastdate FROM user WHERE id='.$oVIP->id);
        $row = $oDB->Getrow();
        if ( $row['lastdate']=='0' ) $row['lastdate']='20000101';
        $endban = DateAdd($row['lastdate'],$intDays,'day');
        if ( date('Ymd')>$endban )
        {
          $oDB->Query('UPDATE user SET closed="0" WHERE id='.$oVIP->id);
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
	  if ($oVIP->role=='A' || $oVIP->role=='X') {
	  	$oVIP->selfname = 'Employee Management';
	  	$oVIP->exiturl = "../hr/employee/";
      } else {
	  	$oVIP->selfname = 'Personal Home page';
	  	$oVIP->exiturl = "../hr/employee/home.php";
	  }
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

include('../header.php');

echo '
<script type="text/javascript">
<!--
function ValidateForm(theForm)
{
  if (theForm.title.value.length==0) { alert(html_entity_decode("','Mandatory',': Username")); return false; }
  //if (theForm.pwd.value.length==0) { alert(html_entity_decode("','Mandatory',': Password")); return false; }
	return null;
}
-->
</script>
';

HtmlMsg(0,'350px','login_header',$oVIP->selfname,'login');

if ( !empty($qti_error) ) echo '<span class="error">',$qti_error,'</span>&nbsp;';
echo '<form method="post" action="',$oVIP->selfurl,'" onsubmit="return ValidateForm(this);">
<p style="text-align:right"><label for="title">Username</label>&nbsp;<input type="text" id="title" name="title" size="20" maxlength="24" value="',$strName,'"/>&nbsp;</p>
<p style="text-align:right"><label for="pwd">Password</label>&nbsp;<input type="password" id="pwd" name="pwd" size="20" maxlength="24" onKeyUp="handle_keypress(event,\'ok\')"/>&nbsp;</p>
<p style="text-align:right"><input type="checkbox" id="remember" name="remember"/>&nbsp;<label for="remember">Remember</label>&nbsp;&nbsp;
<input type="submit" id="ok" name="ok" value="Ok"/>&nbsp;</p>
<p>&nbsp;</p>
</form>';

HtmlMsg(1);

// HTML END

$strFooterAddScript = 'document.getElementById("title").focus();
if ( document.getElementById("title").value.length>1 ) { document.getElementById("pwd").focus(); }';

include('../footer.php');

?>