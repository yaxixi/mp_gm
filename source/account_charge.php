<?php
error_reporting(0);
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$account = $_REQUEST["account"];
$date = $_REQUEST["date"];

$today = date("Y-m-d");

if ($account == '' && $date == '')
    $date = $today;

db('mpay');

$account_cond = '';
if ($account != '')
    $account_cond = " and account='$account' ";
if ($date != '')
{
    $begin_time = strtotime($date . " 00:00:00");
    $end_time = strtotime($date . " 23:59:59");
    $sql = "select sum(price) as total_price, account from charge where time >= $begin_time and time <= $end_time " . $account_cond . " group by account";
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        $row['date'] = $date;
        $data[] = $row;
    }
}
else
{
    $begin_time = strtotime($today . " 00:00:01");
    $end_time = strtotime($today . " 23:59:59");
    for ($i=1; $i <= 7; $i++)
    {
        $begin_time2 = $begin_time - 3600 * 24 * ($i - 1);
        $end_time2 = $end_time - 3600 * 24 * ($i - 1);

        $sql = "select sum(price) as total_price, account from charge where time >= $begin_time2 and time <= $end_time2 " . $account_cond . " group by account";
        $res = mysql_query($sql);
        $flag = 0;
        while($row = mysql_fetch_assoc($res)){
            $flag = 1;
            $row['date'] = date("Y-m-d", $begin_time2);
            $data[] = $row;
        }
        if($flag != 1)
            $data[] = [
                'date'=> date("Y-m-d", $begin_time2),
                'account'=>$account,
                'total_price'=>0,
            ];
    }
}

$Smarty->assign(array(
    'data'=>$data,
    )
);
?>
