<?php
//error_reporting(0);
/*error_reporting(E_ALL);
    ini_set('display_errors', 'On');
ini_set('display_startup_errors','On');*/
include_once '../include/config.php';
include_once '../include/network.php';
check_priv("priv_vendor_readonly");

check_login();

$uid = $_SESSION[SESSION_USERID];

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
