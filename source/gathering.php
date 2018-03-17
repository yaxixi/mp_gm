<?php
error_reporting(0);
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$uid = $_SESSION[SESSION_USERID];
$gathering = $_REQUEST['gathering'];
$orderid = $_REQUEST["orderid"];

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

    $ret = curl_post("http://mpay.yituozhifu.com/mpay/gathering.php", $params);
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
$price = trim($_REQUEST['price']);
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

    echo $sql . json_encode($order_arr);
}

$sql_cond = "status=0 and ";
$like_char = "%";
if ($userid)
    $sql_cond = $sql_cond . "userid like '$userid$like_char' ";
if ($price)
    $sql_cond = $sql_cond . "and price=$price ";

if ($sql_cond != "")
{
    $sql = "select * from charge_exception where " . $sql_cond;
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
