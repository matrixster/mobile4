<?php
session_start();
include("../../header_old.php");

$oVIP->selfurl = 'contacts.php';
$oVIP->selfname = 'Contact Us';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

// --------
// HTML START
// --------

$arrJava = array('com'=>false);


echo '<a id="top"></a><h1>',$oVIP->selfname,'</h1><br/>',N;
include('../w_contacts.inc');
echo '   <br/>';

include("../../footer_old.php");
?>