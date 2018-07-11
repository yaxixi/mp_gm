<?php
error_reporting(0);
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$account = $_REQUEST["account"];

$today = date("Y-m-d");

db('mpay');

$account_cond = '';
if ($account != '')
    $account_cond = " and account='$account' ";

$begin_time = strtotime($today . " 00:00:01");
$end_time = strtotime($today . " 23:59:59");
$dateList = [];
for ($i=1; $i <= 7; $i++)
{
    $begin_time2 = $begin_time - 3600 * 24 * ($i - 1);
    $end_time2 = $end_time - 3600 * 24 * ($i - 1);

    $date = date("m-d", $begin_time2);
    $dateList[] = $date;
    $sql = "select sum(price) as total_price, account from charge where time >= $begin_time2 and time <= $end_time2 " . $account_cond . " group by account";
    $res = mysql_query($sql);
    $flag = 0;
    while($row = mysql_fetch_assoc($res)){
        $flag = 1;
        $account = $row['account'];
        $row['date'] = $date;
        $total_price = round($row['total_price'], 2);
        $data[$account][$date] = $total_price;
    }
    /*
    if($flag != 1)
        $data[] = [
            'date'=> date("m-d", $begin_time2),
            'account'=>$account,
            'total_price'=>0,
        ];*/
}

$Smarty->assign(array(
    'data'=>$data,
    'dateList'=>$dateList,
    )
);
?>
