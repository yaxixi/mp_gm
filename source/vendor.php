<?php
check_priv("priv_vendor");
include_once '../include/config.php';

db('mpay');

$sql = "select balance from vendor where uid='A9D9113YR003'";
$res = mysql_query($sql);
$balance = 0;
while($row = mysql_fetch_assoc($res)){
   $balance = $row['balance'] ? $row['balance'] : 0;
}

$Smarty->assign(
    array(
    'balance'=>round($balance, 4),
    )
);
?>
