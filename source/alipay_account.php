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
$accountid = $_REQUEST['accountid'];
$oper = $_REQUEST["oper"];
$delete_account = (int)$_REQUEST['delete_account'];
$set_max_money = (int)$_REQUEST['set_max_money'];
$set_demo = (int)$_REQUEST['set_demo'];
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

$page_size = 20;
$start_index = ($page - 1) * $page_size;

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

if ($accountid != '')
{
    if ($uid == "admin")
        $uid = 'A9D9113YR003';

    // 前端 js 调用操作
    $params = array(
        'account'=>$account,
        'accountid'=>$accountid,
        'uid'=>$uid,
        'func'=>'add_account',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $account;
            history_add("add_account", $request);
            alert_back('操作成功');
            //redirect()
            //die("OK");
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

if ($set_demo == 1)
{
    // 前端 js 调用操作
    $params = array(
        'account'=>$account,
        'demo'=>$_REQUEST['demo'],
        'func'=>'set_account_demo',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $account;
            history_add("set_account_demo", $request);
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

if ($set_max_money == 1)
{
    // 前端 js 调用操作
    $params = array(
        'account'=>$account,
        'max_money'=>(float)$_REQUEST['max_money'],
        'func'=>'set_max_money',
    );

    $ret = curl_post(MPAY_URL . "mpay/gm_oper.php", $params);
    if ($ret)
    {
        $ret = json_decode($ret, 1);
        if ($ret && $ret['ret'] == 0)
        {
            $_SESSION["result"] = 'OK';
            $request = $account."|".$_REQUEST['max_money'];
            history_add("set_max_money", $request);
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
$cur_time = time();
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
    $status = $_REQUEST['status'];
    $uid_cond = " and uid='$uid'";
    if ($uid == "admin")
        $uid_cond = '';
    $sql = "select * from account where status=$status" . $uid_cond . " order by id limit $start_index, $page_size";
    $res = mysql_query($sql);
    $refresh_rate = false;
    $count = 0;
    while($row = mysql_fetch_assoc($res)){
        if ($row['status'] == '0')
            $row['status_str'] = '有效';
        else
            $row['status_str'] = '无效';

        $account_info[] = $row;

        if ($count == 0) {
            $count = 1;
            if ((int)$row['rate_time'] + 300 <= $cur_time) {
                $refresh_rate = true;
            }
        }
    }

    if ($refresh_rate) {
        $sql = "update account set rate_time = $cur_time";
        mysql_query($sql);

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

        foreach($accountMap as $account=>$value) {
            $precharge_count = (int)$value;
            $charge_count = (int)$acountCharge[$account];
            $suc = (float)round($accountSuc[$account], 3);
            $rate_str = sprintf("%d/%d(%f)", $charge_count, $precharge_count, $suc);

            $sql = "update account set rate = '$rate_str' where account='$account'";
            mysql_query($sql);
        }
    }
}

$Smarty->assign(array(
    'data'=>$account_info,
    'page'=>$page,
    'page_size'=>$page_size,
    'status'=>$_REQUEST['status'],
    )
);
?>
