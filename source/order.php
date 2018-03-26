<?php
error_reporting(0);
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$uid = $_SESSION[SESSION_USERID];
$orderid = $_REQUEST["orderid"];

db('mpay');

$sql_cond = "order by time desc limit 25";
if ($orderid)
{
    $sql_cond = "where precharge.tradeno='$orderid'";
}

    // 查询订单信息
    $sql = "select precharge.*, charge.status as charge_status from precharge left join charge on precharge.tradeno = charge.tradeno " . $sql_cond;
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        $row['time'] = date('Y/m/d h:i', $row['time']);
        if ($row['status'] == "0")
            $row['status'] = "未支付";
        else if ($row['charge_status'] == "1")
        {
            $row['status'] = "支付已关闭";
        }
        else if ($row['charge_status'] === "0")
            $row['status'] = "已支付";
        $order_arr[] = $row;
    }

$Smarty->assign(array(
    'order_data'=>$order_arr,
    )
);
?>
