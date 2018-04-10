<?php
//error_reporting(0);
/*error_reporting(E_ALL);
    ini_set('display_errors', 'On');
ini_set('display_startup_errors','On');*/
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$uid = $_SESSION[SESSION_USERID];
$account = $_REQUEST['account'];
$oper = $_REQUEST["oper"];
$delete_account = (int)$_REQUEST['delete_account'];

if (isset($_REQUEST["oper"]))
{
    // 前端 js 调用操作
    $params = array(
        'account'=>$account,
        'status'=>$oper,
        'func'=>'switch_account_status',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $account . "|" . $oper;
            history_add("account_oper", $request);
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

if ($delete_account == 1)
{
    // 前端 js 调用操作
    $params = array(
        'account'=>$account,
        'func'=>'delete_account',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $account;
            history_add("delete_account", $request);
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
$today = date("Y-m-d");
$time = strtotime($today . " 00:00:00");
$accountSuc = [];
if ($account)
{
    // 查询支付宝帐号信息
    $uid_cond = " and uid='$uid'";
    if ($uid == "admin")
        $uid_cond = '';
    $sql = "select * from account where account='$account'" . $uid_cond;
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        if ($row['status'] == '0')
            $row['status_str'] = '有效';
        else
            $row['status_str'] = '无效';
        $account_info[] = $row;
    }
}
else if (isset($_REQUEST['status']))
{
    $sql = "select count(1) as num, account from precharge where time >= $time group by account";
    $res = mysql_query($sql);
    $accountMap = array();
    $accountSuc = array();
    $acountCharge = array();
    while($row = mysql_fetch_assoc($res)){
        $accountMap[$row['account']] = $row['num'];
    }

    $sql = "select count(1) as num, account from precharge where status=1 and time >= $time group by account";
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        $acountCharge[$row['account']] = $row['num'];
        if ((int)$accountMap[$row['account']] > 0)
            $accountSuc[$row['account']] = (float)$row['num'] / (float)$accountMap[$row['account']];
    }
    //echo json_encode($accountMap) . "   " . json_encode($accountSuc);

    $status = $_REQUEST['status'];
    $uid_cond = " and uid='$uid'";
    if ($uid == "admin")
        $uid_cond = '';
    $sql = "select * from account where status=$status" . $uid_cond;
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        if ($row['status'] == '0')
            $row['status_str'] = '有效';
        else
            $row['status_str'] = '无效';

        $row['precharge_count'] = (int)$accountMap[$row['account']];
        $row['suc'] = round($accountSuc[$row['account']], 3);
        $row['charge_count'] = (int)$acountCharge[$row['account']];
        $account_info[] = $row;
    }
}

$Smarty->assign(array(
    'data'=>$account_info,
    )
);
?>
