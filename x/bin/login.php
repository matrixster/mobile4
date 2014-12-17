<?php

		session_start();
		header('Cache-Control: no-cache, must-revalidate');
		#Invalidate all session information for the user

		if(isset($_SESSION['currentUser'])){
						unset($_SESSION['currentUser']);
						unset($_SESSION['displayName']);
						unset($_SESSION['sessionKey']);
		}

	   

		if($_POST['login']){
			require_once('config_ldap.php');
			$username = $_POST['username'];
			$password = $_POST['userpass'];

			//connect to the LDAP server
			$ldap_link = ldap_connect(LDAP_SERVER, LDAP_PORT) or die('Could not contact authentication server');					

			if($ldap_link){

				//Set LDAP Protocol version

				ldap_set_option($ldap_link, LDAP_OPT_PROTOCOL_VERSION, 3);
			   
				//ldap_bind($ldap_link, LDAP_USER, LDAP_PASSWORD) or die('Failed to bind to authentication server');

				ldap_bind($ldap_link, 'STRATHMORE\\'.$_POST['username'], $_POST['userpass']) or die('Invalid username and password');                                         			  
				#Search AD using samaccountname; unique identifier
				$filter = "(samaccountname=$username)";                                        
				$ldap_data = ldap_search($ldap_link, LDAP_DC, $filter);
				$results = ldap_get_entries($ldap_link, $ldap_data);			   

				//Fetch LDAP attributs for the user

				if(count($results[0]) > 0){

					$_SESSION['currentUser']            = $username;
					//$_SESSION['displayName'] = $results[0]['displayname'][0];
					#Generate session key for the user

					$_SESSION['sessionKey'] = md5(gmmktime());
					#Redirect to home page
					header("Location: ../employee/?authToken=".$_SESSION['sessionKey']);

				}

}

}else{

?>
<title>QMS Authorization</title>
<link rel="stylesheet" type="text/css" href="css/qms.css">
<div align="center">
<form method="post" action="<?php echo $PHP_SELF; ?>">
<table width="" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="center">
<fieldset>
<Legend><font color="gray" size="1" face="Verdana,Tahoma,Arial,sans-serif">Please enter your Windows username and Password</font></Legend>
<table border="0" cellspacing="3" cellpadding="0">
<tr>
<td align="right" valign="middle">Username:</td>
<td align="center" valign="middle">
<input class="clear" type="text" size="30" name="username">
</td>
</tr>
<tr>
<td align="right" valign="middle">Password:</td>
<td align="center" valign="middle"><input class="pass" type="password" size="30"name="userpass">
</td>
</tr>
</table>
<input name="login" type="submit" class="button" id="button" value="Login">
<br>
</fieldset>
</table>
<br>
</form>
</div>

<?php } ?>