<?php
//error_reporting(0);
/*error_reporting(E_ALL);
    ini_set('display_errors', 'On');
ini_set('display_startup_errors','On');*/
include_once '../include/config.php';
include_once '../include/network.php';
check_priv("priv_vendor");

check_login();

$uid = $_SESSION[SESSION_USERID];
$rate = $_REQUEST['rate'];
$add_balance = $_REQUEST['add_balance'];

if ($rate) {
    $uid = $_REQUEST['uid'];
    // 前端 js 调用操作
    $params = array(
        'uid'=>$uid,
        'rate'=>$rate,
        'func'=>'set_rate',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $uid;
            history_add("set_rate", $request);
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

if ($add_balance) {
    $uid = $_REQUEST['uid'];
    // 前端 js 调用操作
    $params = array(
        'uid'=>$uid,
        'add_value'=>$add_balance,
        'func'=>'add_balance',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $uid;
            history_add("add_balance", $request);
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

db('mpay');
$cond = "where uid='$uid'";
if ($uid == "admin")
    $cond = "";
$sql = "select * from vendor " . $cond;
$res = mysql_query($sql);
while($row = mysql_fetch_assoc($res)){
    $arr[] = $row;
}

$Smarty->assign(
    array(
        'data_arr'=>$arr,
    )
);
?>
