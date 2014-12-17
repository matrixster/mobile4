<?php

/*
 * PHP versions 4 and 5
 *
 *
 * @category   Wavuh Ltd
 * @package    Wavuh Ltd
 * @author     Patrick Muteti <pmuteti@wavuh.com>
 * @copyright  2008-2012 The PHP Group
 * @license    http://www.php.net/license  PHP License 3.0
 * @version    1.1.0.1 build:20090101
 * @since      File available since Release 1.0.1.1
 * @deprecated File deprecated in Release 2.0.0
 *
 */

session_start();
require_once('../w_init.php');
require_once('../../header_old.php');
// INITIALISE

$oVIP->selfurl = 'faqs.php';
$oVIP->selfname = 'FAQs';

// --------
// HTML START
// --------

$arrJava = array('com'=>false);


echo '<a id="top"></a><h1>',$oVIP->selfname,'</h1><br/>',N;
include('../w_faqs.inc');
echo '   <br/>';

// HTML EN;D

include('../../footer.php');

?>