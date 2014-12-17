<?php 
session_start();
require_once('../../bin/w_init.php');

$oVIP->selfurl = '#';
$oVIP->selfname = 'Page not found';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

if ($oVIP->id!=0){
include("../../header.php");
} else {
include("../../header_old.php");
}
?>
<table class="ta ta_o">
<tr>
<td class="td_o" align="center"><p><img src="../../img/404.gif" alt="Page not found" align="middle" /></p></td>
</tr>
</table>
<?php include("../../footer.php");?>