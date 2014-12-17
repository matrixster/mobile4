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

$oVIP->selfurl = 'lost-password.php';
$oVIP->selfname = 'Reset your password';


$strName = '';
if ( isset($_GET['dfltname']) )
{
  $strName=$_GET['dfltname']; if ( get_magic_quotes_gpc() ) $strName = stripslashes($strName);
  $strName=QTconv($strName,'U');
}

// --------
// SUBMITTED for login
// --------

if ( isset($_POST['ok']) )
{
	
	$strName = $_POST['email']; if ( get_magic_quotes_gpc() ) $strName = stripslashes($strName);
	$strName = QTconv($strName,'U');
	
	$oDB->Query('SELECT * FROM user U
	LEFT JOIN organization O ON U.Org_ID = O.Org_ID
	LEFT JOIN contact C ON O.Contact_ID = C.Contact_ID
	WHERE C.Email="'.$strName.'"');
    $row = $oDB->Getrow();
	
  // EXECUTE
      // end message
	if ($row) {
		$strT = "Wavuh Password reset\r\n";
		$body = "Dear ".$row['User']."\r\n\r\nYou have requested to reset your password for your Wavuh Account. Click on the link below in order to reset the password.\r\n\r\n";
		$body .='http://www.wavuh.com/bin/m/reset.php?lng='.sha1($row['User_ID']);
		$body .="\r\n\r\nIn the case of any other issue you can contact us through <a href='mailto:sales@wavuh.com'>sales@wavuh.com</a>.\r\n\r\nRegards\r\nThe Wavuh Team\r\n";
		QTmail($strName,QTconv($strT,'-4'),QTconv($body,'-4'),QTI_HTML_CHAR);
		
			//leave the page to the login page
		unset($_SESSION['qtiGoto']);
		
		$oVIP->selfurl = "";
		$oVIP->selfname = 'Reset password';
		$oVIP->exiturl = "#";
	
		$oVIP->exitname ="";
		$oVIP->EndMessage(NULL,'The reset link has been sent to your email',$_SESSION[QT]['skin_dir'],2,'350px','','');
	} else {
		$oVIP->selfname = 'Reset password';
		$oVIP->exiturl = "lost-password.php";
	
		$oVIP->exitname = ObjectName('index','i',$_SESSION[QT]['index_name']);
		$oVIP->EndMessage(NULL,'We did not find a user by that email.',$_SESSION[QT]['skin_dir'],2,'350px','login_header','login');
	}

}


// --------
// HTML START
// --------

//include('../../header_old.php');
include('../../header_old.php');
$oVIP->selfname = 'Reset password';

?>
<div id="container">
  <div class="rows">
	  <div class="row">
		  <div class="column w-100-percent">
		  		<div class="row">
					<div class="column w-100-percent"><p>
<h4 align="center"> Kindly enter your email address below to send you a password reset link </h4>
</p></div>
				
		  <div class="column w-100-percent">
		  		<?php 
				HtmlMsg(0,'270px','login_header',$oVIP->selfname,'login');
				
				if ( !empty($qti_error) ) echo '<span class="error">',$qti_error,'</span>&nbsp;';
				?>
				<p>
				<form method="post" action="<?php $oVIP->selfurl; ?>" onSubmit="return ValidateForm(this);">
				<p style="text-align:right"><label for="title">Email</label>&nbsp;<input type="text" id="email" name="email" size="20" maxlength="60" value="<?php echo $strName; ?>"/>&nbsp;</p>
				<p style="text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" id="ok" name="ok" value="Send me reset link"/><br />
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
  </div>
</div>
<?php
// HTML END

$strFooterAddScript = 'document.getElementById("title").focus();
if ( document.getElementById("title").value.length>1 ) { document.getElementById("pwd").focus(); }';

include('../../footer_old.php');

?>
