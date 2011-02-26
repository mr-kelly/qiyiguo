#!/usr/bin/php -Cq
<?php

error_reporting(0);

if (!isset($argc)) $argc = $_SERVER['argc'];
if (!isset($argv)) $argv = $_SERVER['argv'];

if ($argc != 3) {
    echo "Syntax: $argv[0] to msg\n";
    exit;
}
/*
// send it via MSN object directly.
$aTo = explode(',', $argv[1]);
$sMsg = $argv[2];

$msn_acct = 'YOUR_MSN_ACCOUNT';
$msn_password = 'YOUR_MSN_PASSWORD';

include_once('msn.class.php');

$msn = new MSN();

if (!$msn->connect($msn_acct, $msn_password)) {
    echo "Error for connect to MSN network\n";
    echo "$msn->error\n";
    exit;
}

$msn->sendMessage($sMsg, $aTo);
if ($msn->error != '')
    echo "Error: $msn->error\n";

*/

// write the file to use msnbot
$sTo = $argv[1];
$sMsg = $argv[2];

$fname = '/var/spool/msnbot/spool/msn_'.posix_getpid().'_'.md5(strftime('%D %T')).'.msn';

$fp = fopen($fname, 'wt');
if (!$fp) {
    echo "Can't write to $fname\n";
    exit;
}

fputs($fp, "TO: $sTo\n$sMsg");
fclose($fp);
chmod($fname, 0666);

exit;

?>

