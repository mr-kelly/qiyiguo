<?php

function checkDateTime($datetime)
{
    if (strlen($datetime) != 14) return false;
    $year = substr($datetime, 0, 4);
    $month = substr($datetime, 4, 2);
    $day = substr($datetime, 6, 2);
    $hour = substr($datetime, 8, 2);
    $minute = substr($datetime, 10, 2);
    $second = substr($datetime, 12, 2);
    if (!is_numeric($year) || !is_numeric($month) || !is_numeric($day) ||
        !is_numeric($hour) || !is_numeric($minute) || !is_numeric($second))
        return false;
    if (!checkdate($month, $day, $year)) return false;
    if ($hour < 0 || $hour > 23) return false;
    if ($minute < 0 || $minute > 59) return false;
    if ($second < 0 || $second > 59) return false;
    return true;
}

function addNotifyMsg($aParam)
{
    $syntax = 'Syntax for Notify, at least 2 lines of message, first line should like:
NOTIFY:YYYYMMDD[HH[MM[SS]]]:to_list
and the other lines is the message we need to notify at the time.

YYYYMMDD[HH[MM[SS]]] is the date and time
to_list is the list who need to be notified, seperate with comma, just the the list in msn.class.php,
and the from will be added to this list automaticly.';

    $from = $aParam['from'];
    $network = $aParam['network'];
    $msg = $aParam['msg'];

    $aLines = @explode("\n", $msg);
    if ($aLines === false || count($aLines) == 0)
        return $syntax;

    $aCmd = explode(':', trim($aLines[0]));
    // $aCmd[0] = 'NOTIFY'
    // $aCmd[1] = datetime
    // $aCmd[2] = to_list or empty
    if (!isset($aCmd[1])) return $syntax;
    $datetime = str_pad(trim($aCmd[1]), 14, '0');
    if (!checkDateTime($datetime))
        return "DATETIME '$datetime' is invalid\n\n$syntax";
    if ($from == '') {
        $from_email = '<unknown>';
        $to_list = '';
    }
    else {
        $from_email = $from.'@'.$network;
        $to_list = $from_email;
    }
    if (isset($aCmd[2]) && strlen(trim($aCmd[2])) > 0) {
        if ($to_list !== '')
            $to_list = ',';
        $to_list .= trim($aCmd[2]);
    }

    $sMsg = '';
    $i = 0;
    foreach ($aLines as $line) {
        if ($i++ == 0) continue;
        if ($sMsg !== '')
            $sMsg .= "\n";
        $sMsg .= rtrim($line);
    }

    include('notify_config.php');
    if (!isset($adodb_include))
        return "DB Setting Error!";
    include_once($adodb_include);
    $adodb_function = 'ADONewConnection';
    if (!function_exists($adodb_function) || !is_callable($adodb_function))
        return "DB Error!\n\n$adodb_function() not exist!";

    $conn = &ADONewConnection($notify_db_type);
    $conn->PConnect($notify_db_host, $notify_db_user, $notify_db_pass, $notify_db_name);
    $sql = "insert into $notify_table_name (
msn_datetime, msn_to, msn_msg, msn_from, msn_tm
) values (
".$conn->Param('datetime').', '.$conn->Param('to').', '.$conn->Param('msg').', '.$conn->Param('from').', NOW())';
    $stmt = $conn->Prepare($sql);
    $rs = $conn->Execute($stmt, array($datetime, $to_list, $sMsg, $from_email));
    if (!$rs)
        $errmsg = $conn->ErrorMsg();
    else {
        $rs->Close();
        $errmsg = '';
    }
    $conn->Close();
    if ($errmsg === '')
        return "Notify added";
    else
        return "DB Error!\n$errmsg";
}

?>
