<?php
error_reporting(0);
/*error_reporting(E_ALL);
    ini_set('display_errors', 'On');
ini_set('display_startup_errors','On');*/
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$uid = $_SESSION[SESSION_USERID];
$return_money = $_REQUEST['return_money'];
$gathering = $_REQUEST['gathering'];
$refresh_warning = $_REQUEST['refresh_warning'];
$orderid = $_REQUEST["orderid"];
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

$page_size = 20;
$start_index = ($page - 1) * $page_size;

if ($refresh_warning)
{
    $params = array(
        'uid'=>$uid,
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
            $_SESSION["result"] = 'OK';
            $request = $orderid . "|" . $price . "|" . $id;
            history_add("gathering", $request);
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

    $userid = $_REQUEST['userid'];
    $price = $_REQUEST['price'];
    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $userid . "|" . $price . "|" . $id;
            history_add("return_money", $request);
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
    $sql = "select * from precharge where tradeno='$orderid'";
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        $order_arr[] = $row;
    }

    if ($order_arr && $order_arr[0])
    {
        $order_arr[0]['time'] = date('Y/m/d H:i', $order_arr[0]['time']);
        if ($order_arr[0]['status'] == "0")
            $order_arr[0]['status'] = "未支付";
        else
        {
            $order_arr[0]['status'] = "已支付";

            // 读 charge 表
            $sql = "select * from charge where tradeno='$orderid'";
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
{
    $sql_cond = $sql_cond . "status=0";
    $status = 0;
}

if ($sql_cond != "")
{
    if ($uid != 'admin')
        $sql_cond = $sql_cond . " and uid='$uid'";
    $sql = "select * from charge_exception where " . $sql_cond . " order by clientTime desc limit $start_index, $page_size";
    $res = mysql_query($sql);

    while($row = mysql_fetch_assoc($res)){
        $data_arr[] = $row;
    }
}

$Smarty->assign(array(
    'data'=>$data_arr,
    'order_data'=>$order_arr,
    'page'=>$page,
    'page_size'=>$page_size,
    'status'=>$status,
    )
);
?>
