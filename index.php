<?php 
session_start();
require_once('./x/bin/w_init.php');

$l = -1;
if (isset($_GET['l'])) $l = stripslashes($_GET['l']);

if ( isset($_POST['username']) &&  isset($_POST['username']) || isset($_POST['ok']))
{
	$strName = $_POST['username']; if ( get_magic_quotes_gpc() ) $strName = stripslashes($strName);
	//$strName = QTconv($strName,'U');
	//if ( !QTislogin($strName) ) $qti_error = 'Username not invalid';
	
	$strPwd = $_POST['password']; if ( get_magic_quotes_gpc() ) $strPwd = stripslashes($strPwd);
	//$strPwd = QTconv($strPwd,'U');
	//if ( !QTispassword($strPwd) ) $qti_error = 'Password not invalid';
	
  // EXECUTE

  if ( empty($qti_error) )//&& (count($results[0]) > 0)
  {
    $arrLog = $oVIP->Login($strName,$strPwd,isset($_POST['remember']));

    if ( $oVIP->auth )
    {
	  	$oDB->Query('INSERT INTO `logger` VALUES("Logged into Wavuh","Login",'.$oVIP->id.',"'.date('Y-m-d H:i:s').'")');
    	header("Location:./home.php");
    }
    else
    {	
      $qti_error = $L['E_access'];
    }

  }

}

/*if ( isset($_GET['a']) ) {

	if ( $_GET['a']=='out' ) {
  // LOGGING OUT
	
  	$oVIP->Logout();
  	//echo $oVIP->id;
  // REBOOT
  	//GetParam(true);
  	unset($_SESSION['qtiGoto']);
  	$oVIP->selfurl = 'login.php?a=out';
  	header("Location:index.php");
	}
}*/

if ( isset($_GET['a']) ) {
if ( $_GET['a']=='out' ) {

  // LOGGING OUT
  $oDB->Query('INSERT INTO `logger` VALUES("Logged out of Wavuh","Logout",'.$oVIP->id.',"'.date('Y-m-d H:i:s').'")');
  $oVIP->Logout();

  // REBOOT

  GetParam(true);

  unset($_SESSION['qtiGoto']);
  
  header("Location:index.php");
}}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
    <meta charset="utf-8">
    <title>Wavuh Mobile login</title>
    <meta name="description" content="Wavuh login">
    <meta name="author" content="Wavuh Limited">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="placeholder.js"></script>
    <style type="text/css">
    html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}
 
body {
    font-family:Arial, Helvetica, sans-serif;
    text-align:text-center;
    /*background-color: #323B55;*/

    /*background-image: url('./wavu.gif');*/
    background-repeat:no-repeat;
	background-attachment:fixed;
	background-position:center;
}
 
#slick-login {
    width: 80%;
    height: 250px;
    position: absolute;
    padding: 15px;
    left: 7%;
    top: 10%;
 	
 	background-color: #323B55;

}
 
#slick-login label {
    display: none;
}
 
.placeholder {
    color: #444;
}
 
#slick-login input[type="text"],#slick-login input[type="password"] {
    width: 90%;
    height: 40px;
    position: relative;
    margin-top: 7px;
    font-size: 14px;
    color: #444;
    outline: none;
    border: 1px solid rgba(0, 0, 0, .49);
 
    padding-left: 20px;
     
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding-box;
    background-clip: padding-box;
    border-radius: 6px;
    box-shadow: inset 0px 2px 0px #d9d9d9;
}
 
#slick-login input[type="text"]:focus,#slick-login input[type="password"]:focus {
    -webkit-box-shadow: inset 0px 2px 0px #a7a7a7;
    box-shadow: inset 0px 2px 0px #a7a7a7;
}
 
#slick-login input:first-child {
    margin-top: 0px;
}
 
#slick-login input[type="submit"] {
    width: 98%;
    height: 50px;
    margin-top: 7px;
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    text-shadow: 0px -1px 0px #5b6ddc;
    outline: none;
    border: 1px solid rgba(0, 0, 0, .49);

    background-clip: padding-box;
    border-radius: 6px;
 
    background-color: #5466da;
     
    -webkit-box-shadow: inset 0px 1px 0px #9ab1ec;
    box-shadow: inset 0px 1px 0px #9ab1ec;
     
    cursor: pointer;

}
 
#slick-login input[type="submit"]:hover {
    background-color: #5f73e9;
    margin-top: 10px;
}
 
#slick-login input[type="submit"]:active {
    background-color: #7588e1;
    -webkit-box-shadow: inset 0px 1px 0px #93a9e9;
    box-shadow: inset 0px 1px 0px #93a9e9;
}
    </style>
</head>
 
<body>
    <form id="slick-login" method="POST">
    	<img src="./img/logo.jpg"></br></br>
    	<?php if (!empty($qti_error)) { echo "<b><span style='color:red'>Login failed. Try again.</span></b>"; }?>
    	<?php if ($l=='demo') { echo "<b><span style='font-size: 10pt; color:white'>Demo: username: admin </br> password:@admin</span></b>"; }?>
        <label for="username">username</label><input type="text" name="username" class="placeholder" placeholder="username">
        <label for="password">password</label><input type="password" name="password" class="placeholder" placeholder="password">
        <input type="submit" name="ok" value="Log In">
    </form>
</body>
 
</html>