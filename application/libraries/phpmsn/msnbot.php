#!/usr/bin/php -Cq
<?php
/*
UNIX INSTALL:

1. Create some folders like:
   mkdir /var/spool/msnbot
   mkdir /var/spool/msnbot/log
   mkdir /var/spool/msnbot/spool

2. Change the attribute for spool folder:
   chmod 777 /var/spool/msnbot/spool
   chmod o+t /var/spool/msnbot/spool

3. Put msnbot.php, config.php and msn.class.php to /var/spool/msnbot/, and make msnbot.php executable:
   chmod +x /var/spool/msnbot/msnbot.php

4. change the setting in config.php

5. Use msnbot.sh as your startup script to execute msnbot after system boot.

6. Change processMsg function in msnbot.php to do whatever you want.

7. If you need to send message to someone, just create a file under /var/spool/msnbot/spool, the filename like '*.msn',
   and the format like test.msn, first line is TO: email1,email2, and the other lines is the message.
   After create the file, just change the attribute to 0666, then msnbot will try to send it.
   NOTICE: file encoding should be UTF-8 if included non-English word.

WINDOWS INSTALL:

1. Create some folders like:
   md c:\msnbot
   md c:\msnbot\log
   md c:\msnbot\spool

2. Put msnbot.php, config.php and msn.class.php to c:\msnbot

3. change the setting in config.php

4. Change processMsg function in msnbot.php to do whatever you want.

5. execute php.exe -Cq c:\msnbot\msnbot.php

6. If you need to send message to someone, just create a file under c:\msnbot\spool, the filename like '*.msn',
   and the format like test.msn, first line is TO: email1,email2, and the other lines is the message.
   NOTICE: file encoding should be UTF-8 if included non-English word.

*/

function sig_handler($signal)
{
    global $msn;

    if (is_object($msn)) {
        $msn->log_message("*** someone kill me ***");
        $msn->kill_me = true;
    }
    return;
}

// network:
//      1: WLM/MSN
//      2: LCS
//      4: Mobile Phones
//     32: Yahoo!
function getNetworkName($network)
{
    switch ($network) {
        case 1:
            return 'WLM/MSN';
        case 2:
            return 'LCS';
        case 4:
            return 'Mobile Phones';
        case 32:
            return 'Yahoo!';
    }
    return "Unknown ($network)";
}

// your function to process message from someone
function processMsg($from, $msg, $network = 1)
{
    global $msn_acct;
    global $aIgnoreAccts;

    // from myself? ignore it
    if ($from == $msn_acct) return '';
    // also ignore other bot
    if (is_array($aIgnoreAccts)) {
        if (in_array($from, $aIgnoreAccts)) return '';
    }
    if (strncasecmp($msg, 'NOTIFY:', 7) == 0) {
        // notfiy function
        include_once('notify_add.php');
        if (function_exists('addNotifyMsg') && is_callable('addNotifyMsg')) {
            return addNotifyMsg(array('from' => $from,
                                      'network' => $network,
                                      'msg' => $msg
                                      ));
        }
    }
    $nw_name = getNetworkName($network);
    return "message from $from (network: $nw_name):\n$msg";
}

// your function when someone add us to his contact list
function addContact($from, $network = 1)
{
    global $aNotifyUser;

    if (is_array($aNotifyUser) && count($aNotifyUser) > 0) {
        $list = '';
        foreach ($aNotifyUser as $user) {
            if (trim($user) === '') continue;
            if ($list === '')
                $list = $user;
            else
                $list .= ','.$user;
        }
        if ($list === '') return;
        $nw_name = getNetworkName($network);
        $now = strftime('%D %T');
        $fname = dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'spool'.DIRECTORY_SEPARATOR.'msn_'.getpid().'_'.md5('add'.rand(1,1000).$now).'.msn';
        $fp = fopen($fname, 'wt');
        if ($fp) {
            fputs($fp, "TO: $list\n");
            fputs($fp, "Now: $now\n$from (network: $nw_name) add me to his contact list!");
            fclose($fp);
            chmod($fname, 0666);
        }
    }
    return;
}

// your function when someone remove us from his contact list
function removeContact($from, $network = 1)
{
    global $aNotifyUser;

    if (is_array($aNotifyUser) && count($aNotifyUser) > 0) {
        $list = '';
        foreach ($aNotifyUser as $user) {
            if (trim($user) === '') continue;
            if ($list === '')
                $list = $user;
            else
                $list .= ','.$user;
        }
        if ($list === '') return;
        $nw_name = getNetworkName($network);
        $now = strftime('%D %T');
        $fname = dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'spool'.DIRECTORY_SEPARATOR.'msn_'.getpid().'_'.md5('delete'.rand(1,1000).$now).'.msn';
        $fp = fopen($fname, 'wt');
        if ($fp) {
            fputs($fp, "TO: $list\n");
            fputs($fp, "Now: $now\n$from (network: $nw_name) remove me from his contact list!");
            fclose($fp);
            chmod($fname, 0666);
        }
    }
    return;
}

// tick use required as of PHP 4.3.0
declare (ticks = 1);

error_reporting(E_ALL);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
    $windows = true;
else
    $windows = false;

if (!$windows) {
    $pid = pcntl_fork();
    if ($pid) exit;
}

require('config.php');
include_once('msn.class.php');

$msn = new MSN('', dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'debug.log');

if (!$windows) {
    pcntl_signal(SIGTERM, 'sig_handler');
    pcntl_signal(SIGHUP, 'sig_handler');
}

$fp = fopen(dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'msnbot.pid', 'wt');
if ($fp) {
    fputs($fp, getpid());
    fclose($fp);
}
/*

function doLoop($aParams);

$aParams['user']: the MSN account
$aParams['password']: password of the MSN account
$aParams['alias']: the MSN alias, if empty, the program will use $aParams['user']
        default: empty string
$aParams['psm']: personal message
        default: empty string
$aParams['msg_function']: your message process function, if empty, msnbot will ignore any message.
        like: processMsg($from, $msg, $network = 1)
        default: false
$aParams['add_user_function']: your function when someone add us to his contact list.
        like: addContact($from, $network = 1)
        default: false
$aParams['remove_user_function']: your function when someone remove us from his contact list.
        like removeContact($from, $network = 1)
        default: false
$aParams['use_ping']: if true, msnbot will send PNG to server (0-50 seconds) to keep alive, but... even without this,
        we're still online. if this variable is a non-zero integer, will send PNG command every $use_ping seconds.
        default: false
$aParams['retry_wait']: if we lost connection, how long we should wait before we try again.
        default: 30
$aParams['backup_file']: move .msn file to backup folder after processed
        default: true
$aParams['update_pending']: try to add pending list member to avail/reverse list, and delete it from pending list
        default: true
*/
$msn->doLoop(array(
                'user' => $msn_acct,
                'password' => $msn_password,
                'alias' => $msn_alias,
                'psm' => $msn_psm,
                'msg_function' => 'processMsg',
                'add_user_function' => 'addContact',
                'remove_user_function' => 'removeContact',
                'use_ping' => 600
                )
            );

$msn->log_message("done!");
@unlink(dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'msnbot.pid');

exit;

function getpid()
{
    global $windows;

    if ($windows) return 'nopid';
    return posix_getpid();
}


?>
