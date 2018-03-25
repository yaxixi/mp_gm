<?php
error_reporting(0);
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$uid = $_SESSION[SESSION_USERID];
$return_money = $_REQUEST['return_money'];
$gathering = $_REQUEST['gathering'];
$refresh_warning = $_REQUEST['refresh_warning'];
$orderid = $_REQUEST["orderid"];

if ($refresh_warning)
{
    $params = array(
        'func'=>'charge_exception_count',
    );
    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            die($ret['count']);
        }
        else
        {
            if ($ret && $ret['msg'])
                die($ret['msg']);
            else
                die('Operation failed.');
        }
    }
    return;
}

if ($gathering)
{
    if ($orderid == "")
        echo "收款必须有订单号！";

    // 前端 js 调用收款操作
    $id = $_REQUEST["id"];
    $price = $_REQUEST['money'];
    $token = 'A9Y3A00J8001';

    // 进行验证
    $key = strtolower(md5($orderid. $uid. $token));
    $params = array(
        'orderid'=>$orderid,
        'id'=>$id,
        'uid'=>$uid,
        'price'=>$price,
        'key'=>$key,
    );

    $ret = curl_post(MPAY_URL . "mpay/gathering.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            die("OK");
        }
        else
        {
            if ($ret && $ret['msg'])
                die($ret['msg']);
            else
                die('Operation failed.');
        }
    }
    return;
}

if ($return_money)
{
    // 前端 js 调用操作
    $id = $_REQUEST["id"];
    $params = array(
        'id'=>$id,
        'func'=>'return_money',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            die("OK");
        }
        else
        {
            if ($ret && $ret['msg'])
                die($ret['msg']);
            else
                die('Operation failed.');
        }
    }
    return;
}

$userid = trim($_REQUEST['userid']);
$status = trim($_REQUEST['status']);
$clientTime = trim($_REQUEST['clientTime']);

db('mpay');
if ($orderid)
{
    // 查询订单信息
    $sql = "select * from precharge where orderid='$orderid'";
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        $order_arr[] = $row;
    }

    if ($order_arr && $order_arr[0])
    {
        $order_arr[0]['time'] = date('Y/m/d h:i', $order_arr[0]['time']);
        if ($order_arr[0]['status'] == "0")
            $order_arr[0]['status'] = "未支付";
        else
        {
            $order_arr[0]['status'] = "已支付";

            // 读 charge 表
            $sql = "select * from charge where orderid='$orderid'";
            $res = mysql_query($sql);
            while($row = mysql_fetch_assoc($res)){
                $order_arr[0]['price'] = $row['price'];
                if ($row['status'] == "1")
                    $order_arr[0]['status'] = "支付已关闭";

            }
        }
    }
}

$sql_cond = "";
$like_char = "%";
if ($userid)
    $sql_cond = $sql_cond . "userid like '$userid$like_char' and ";
if ($clientTime)
    $sql_cond = $sql_cond . "clientTime like '$clientTime$like_char' and ";
if ($_REQUEST['status'] != "")
    $sql_cond = $sql_cond . "status=$status";
else if ($sql_cond != "")
    $sql_cond = $sql_cond . "status=0";

if ($sql_cond != "")
{
    $sql = "select * from charge_exception where " . $sql_cond . " order by clientTime desc limit 50";
    $res = mysql_query($sql);

    while($row = mysql_fetch_assoc($res)){
        $data_arr[] = $row;
    }
}
$Smarty->assign(array(
    'data'=>$data_arr,
    'order_data'=>$order_arr,
    )
);
?>
