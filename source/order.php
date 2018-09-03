<?php
error_reporting(0);
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$uid = $_SESSION[SESSION_USERID];
$orderid = $_REQUEST["orderid"];
$vendor_orderid = $_REQUEST["vendor_orderid"];
$account = $_REQUEST['account'];
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

db('mpay');

$page_size = 20;
$start_index = ($page - 1) * $page_size;
$sql_cond = " and precharge.uid='$uid' ";
if ($uid == 'admin')
    $sql_cond = '';
if ($account) {
    $sql_cond = "where precharge.account='$account' " . $sql_cond . " order by time desc limit $start_index, $page_size";
}
else if ($orderid)
{
    $sql_cond = "where precharge.tradeno='$orderid' " . $sql_cond;
}
else if ($vendor_orderid)
{
    $sql_cond = "where precharge.orderid='$vendor_orderid' " . $sql_cond;
}
else {
    $sql_cond2 = " where precharge.uid='$uid' ";
    if ($uid == 'admin')
        $sql_cond2 = '';
    $sql_cond = $sql_cond2 . "order by time desc limit $start_index, $page_size";
}

    // 查询订单信息
    $sql = "select precharge.*, charge.status as charge_status, charge.price as charge_price, charge.clientTime as clientTime, charge.time as chargeTime from precharge left join charge on precharge.tradeno = charge.tradeno " . $sql_cond;
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        $row['time'] = date('Y/m/d H:i', $row['time']);
        $row['price'] = $row['charge_price'];
        if ($row['status'] == "0")
            $row['status'] = "未完成";
        else if ($row['charge_status'] == "1")
        {
            $row['status'] = "已关闭";
            $row['chargeTime'] = date('Y/m/d H:i', $row['chargeTime']);
        }
        else if ($row['charge_status'] == "0")
        {
            $row['status'] = "已完成";
            $row['chargeTime'] = date('Y/m/d H:i', $row['chargeTime']);
        }
        $order_arr[] = $row;
    }


$Smarty->register_function('page_ex','page_ex');
$Smarty->assign(array(
    'order_data'=>$order_arr,
    'page'=>$page,
    'page_size'=>$page_size,
    'account'=>$account,
    )
);
?>
