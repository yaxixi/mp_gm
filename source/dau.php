<?php
check_priv("tongji_main");
include_once '../include/config.php';

db('mpay');
$today = date("Y-m-d");
$time = strtotime($today . " 00:00:00");
$sql = "select sum(price) as today_money from charge where time >= $time";
$res = mysql_query($sql);
$today_money = 0;
while($row = mysql_fetch_assoc($res)){
    $today_money = $row['today_money'] ? $row['today_money'] : 0;
}

$sql = "select sum(price) as exception_money from charge_exception where clientTime like '$today%' and status=0";
$res = mysql_query($sql);
$exception_money = 0;
while($row = mysql_fetch_assoc($res)){
   $exception_money = $row['exception_money'] ? $row['exception_money'] : 0;
}

$begin_date = $_REQUEST['begin_date'];
$end_date = $_REQUEST['end_date'];
if ($end_date == '')
    $end_date = $today;
if ($begin_date == '')
    $begin_date = $today;

$begin_time = strtotime($begin_date . " 00:00:00");
$end_time = strtotime($end_date . " 23:59:59");

$sql = "select count(1) as num, orderuid from precharge where time >= $begin_time and time <= $end_time group by orderuid";
$res = mysql_query($sql);
$accountMap = array();
$accountSuc = array();
$acountCharge = array();
while($row = mysql_fetch_assoc($res)){
    $accountMap[$row['orderuid']] = $row['num'];
}

$sql = "select count(1) as num, orderuid from precharge where status=1 and time >= $begin_time and time <= $end_time group by orderuid";
$res = mysql_query($sql);
while($row = mysql_fetch_assoc($res)){
    $acountCharge[$row['orderuid']] = $row['num'];
    if ((int)$accountMap[$row['orderuid']] > 0)
        $accountSuc[$row['orderuid']] = (float)$row['num'] / (float)$accountMap[$row['orderuid']];
}

$sql = "select sum(price) as total_price, orderuid from charge where time >= $begin_time and time <= $end_time group by orderuid order by total_price desc";
$res = mysql_query($sql);
while($row = mysql_fetch_assoc($res)){
    $row['total_price'] = round($row['total_price'], 2);
    $row['precharge_count'] = (int)$accountMap[$row['orderuid']];
    $row['suc'] = round($accountSuc[$row['orderuid']], 3);
    $row['charge_count'] = (int)$acountCharge[$row['orderuid']];
    $data[] = $row;
}

if ($begin_date)
{
    $sql = "select sum(price) as today_money from charge where time >= $begin_time and time <= $end_time";
    $res = mysql_query($sql);
    $date_money = 0;
    while($row = mysql_fetch_assoc($res)){
        $date_money = $row['today_money'] ? $row['today_money'] : 0;
    }
}

$Smarty->assign(
    array(
    'exception_money'=>$exception_money,
    'today_money'=>round($today_money, 2),
    'date_money'=>round($date_money, 2),
    'date'=>($_REQUEST['begin_date'] ? $begin_date . ' ~ '. $end_date : ''),
    'data'=>$data,
    )
);
?>
