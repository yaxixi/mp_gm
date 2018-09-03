<?php
check_priv("tongji_main");
include_once '../include/config.php';

db('mpay');
$today = date("Y-m-d");
$time = strtotime($today . " 00:00:00");

$begin_date = $_REQUEST['begin_date'];
$end_date = $_REQUEST['end_date'];
if ($end_date == '')
    $end_date = $today;
if ($begin_date == '')
    $begin_date = $today;

$begin_time = strtotime($begin_date . " 00:00:00");
$end_time = strtotime($end_date . " 23:59:59");

$sql = "select count(1) as num, uid from precharge where time >= $begin_time and time <= $end_time group by uid";
$res = mysql_query($sql);
$accountMap = array();
$accountSuc = array();
$acountCharge = array();
while($row = mysql_fetch_assoc($res)){
    $accountMap[$row['uid']] = $row['num'];
}

$sql = "select count(1) as num, uid from precharge where status=1 and time >= $begin_time and time <= $end_time group by uid";
$res = mysql_query($sql);
while($row = mysql_fetch_assoc($res)){
    $acountCharge[$row['uid']] = $row['num'];
    if ((int)$accountMap[$row['uid']] > 0)
        $accountSuc[$row['uid']] = (float)$row['num'] / (float)$accountMap[$row['uid']];
}

$sql = "select uid,sum(price) as total_price from charge where time >= $begin_time and time <= $end_time group by uid order by total_price desc";
$res = mysql_query($sql);
$today_money = 0;
while($row = mysql_fetch_assoc($res)){
    $row['total_price'] = round($row['total_price'], 2);
    $row['precharge_count'] = (int)$accountMap[$row['uid']];
    $row['suc'] = round($accountSuc[$row['uid']], 3);
    $row['charge_count'] = (int)$acountCharge[$row['uid']];
    $data[] = $row;
    $exception_data[$row['uid']] = 0;
}

$sql = "select uid,sum(price) as exception_money from charge_exception where clientTime like '$today%' and status=0 group by uid";
$res = mysql_query($sql);
$exception_money = 0;
while($row = mysql_fetch_assoc($res)){
    $exception_money = $row['exception_money'] ? $row['exception_money'] : 0;
    $exception_data[$row['uid']] = $exception_money;
}

$Smarty->assign(
    array(
    'exception_data'=>$exception_data,
    'begin_date'=>$begin_date,
    'end_date'=>$end_date,
    'data'=>$data,
    )
);
?>
