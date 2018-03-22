<?php
//error_reporting(0);
include_once '../include/config.php';
include_once '../include/network.php';

check_login();

$uid = $_SESSION[SESSION_USERID];
$account = $_REQUEST['account'];
$oper = $_REQUEST["oper"];

if (isset($_REQUEST["oper"]))
{
    // 前端 js 调用操作
    $params = array(
        'account'=>$account,
        'status'=>$oper,
        'func'=>'switch_account_status',
    );

    $ret = curl_post("http://mpay.yituozhifu.com/mpay/gm_oper.php", $params);
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

db('mpay');
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
    $sql = "select * from account where status=$status" . $uid_cond;
    $res = mysql_query($sql);
    while($row = mysql_fetch_assoc($res)){
        if ($row['status'] == '0')
            $row['status_str'] = '有效';
        else
            $row['status_str'] = '无效';
        $account_info[] = $row;
    }
}

$Smarty->assign(array(
    'data'=>$account_info,
    )
);
?>
