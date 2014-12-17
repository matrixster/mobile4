<?php
// we'll generate XML output
header('Content-Type: text/xml');
// generate XML header
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
// create the <response> element
echo '<response>';
// retrieve the user name
$s = $_GET['s'];
$e = $_GET['e'];
// generate output depending on the user name received from client
//$userNames = array('patrick', 'muteti', 'patrick muteti');
//if (in_array(strtolower($name), $userNames))
if (htmlentities($e) =='2009-02-01'){
echo 'Wewe ' . htmlentities($e) . '!';
}
/*else if (trim($name) == '')
echo 'Stranger, please tell me your name!';
else
echo htmlentities($e) . ', I don\'t know you!';*/
// close the <response> element
echo '</response>';
?>
