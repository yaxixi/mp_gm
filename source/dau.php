<?php
check_priv("tongji_main");
include_once '../include/config.php';

db('mpay');
$today = date("Y-m-d");
$time = strtotime($today . " 00:00:00");
$sql = "select sum(price) as today_money, sum(real_price) as today_real_money from charge where time >= $time";
$res = mysql_query($sql);
$today_money = 0;
while($row = mysql_fetch_assoc($res)){
    $today_money = $row['today_money'] ? $row['today_money'] : 0;
    $today_real_money = $row['today_real_money'] ? $row['today_real_money'] : 0;
}

$sql = "select sum(price) as exception_money from charge_exception where clientTime like '$today%' and status=0";
$res = mysql_query($sql);
$exception_money = 0;
while($row = mysql_fetch_assoc($res)){
   $exception_money = $row['exception_money'] ? $row['exception_money'] : 0;
}

$Smarty->assign(
    array(
    'exception_money'=>$exception_money,
    'today_money'=>$today_money,
    'today_real_money'=>$today_real_money,
    )
);
?>
