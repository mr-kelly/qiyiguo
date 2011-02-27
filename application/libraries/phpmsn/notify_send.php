#!/usr/bin/php -Cq
<?php

include_once('notify_config.php');

// write log
function log_message($str)
{
    $fname = dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'notify_'.strftime('%Y%m%d').'.log';
    $fp = fopen($fname, 'at');
    if ($fp) {
        fputs($fp, strftime('%m/%d/%y %H:%M:%S').' '.$str."\n");
        fclose($fp);
    }
    return;
}

include_once($adodb_include);
$adodb_function = 'ADONewConnection';
if (!function_exists($adodb_function) || !is_callable($adodb_function)) {
    log_message("DB Error! $adodb_function() not exist!");
    exit;
}

$lck_fname = dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'notify.lck';
$lck_fp = fopen($lck_fname, 'wt');
if (!$lck_fp) {
    log_message("Can't oepn lock file: $lck_fname");
    exit;
}
if (!flock($lck_fp, LOCK_EX | LOCK_NB)) {
    fclose($lck_fp);
    log_message("Can't lock file: $lck_fname");
    exit;
}

$conn = &ADONewConnection($notify_db_type);
$conn->PConnect($notify_db_host, $notify_db_user, $notify_db_pass, $notify_db_name);
$sql = "select msn_id, msn_to, msn_msg, msn_from, msn_tm
from $notify_table_name
where msn_datetime <= '".strftime('%Y%m%d%H%M%S')."'
order by msn_datetime";
$rs = &$conn->Execute($sql);
if (!$rs) {
    log_message('DB Error:'.$conn->ErrorMsg());
    $conn->Close();
    flock($lck_fp, LOCK_UN);
    fclose($lck_fp);
    exit;
}
$aData = array();
while (!$rs->EOF) {
    $aData[] = array(
                'id' => $rs->fields[0],
                'to' => $rs->fields[1],
                'msg' => $rs->fields[2],
                'from' => $rs->fields[3],
                'tm' => $rs->fields[4]
                );
    $rs->MoveNext();
}
$rs->Close();
foreach ($aData as $data) {
    $id = $data['id'];
    $to = $data['to'];
    $msg = $data['msg'];
    $from = $data['from'];
    $tm = $data['tm'];
    $fname = dirname($_SERVER['argv'][0]).DIRECTORY_SEPARATOR.'spool'.DIRECTORY_SEPARATOR.'notify_'.$id.'_'.md5($to.rand(1,1000)).'.msn';
    $fp = fopen($fname, 'wt');
    if ($fp) {
        fputs($fp, "TO: $to\n");
        fputs($fp, "Notify from $from at $tm\n$msg");
        fclose($fp);
        chmod($fname, 0666);
        log_message("Notfiy for $id from $from to $to at $tm: $fname");
        $sql = "delete from $notify_table_name where msn_id = $id";
        $rs = $conn->Execute($sql);
        if (!$rs)
            log_message('DB Error:'.$conn->ErrorMsg());
        else
            $rs->Close();
    }
}
$conn->Close();

flock($lck_fp, LOCK_UN);
fclose($lck_fp);

exit;

?>
