<?php
session_start();
require_once('../w_init.php');

$oDB->Query('UPDATE organization SET Suspended=0');
$row99 = $oDB->Getrow();
?>