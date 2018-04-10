<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sidemenu</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="css/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/dtree.js"></script>
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<!--<script type="text/javascript" src="js/detect.js"></script>-->
</head>

<?php echo "<body id=\"side\" style=\"background:#".BGCOLOR."\"" ?> >
<div class="dtree">
    <p><a href="javascript: d.openAll();">展开所有</a> | <a href="javascript: d.closeAll();">关闭所有</a></p>
    <script type="text/javascript">
    var subId = 1000;
    var treeId = 10;
    d = new dTree('d');
    d.config.target = "mainframe";
    d.add(1,-1,<?php echo "'".TITLE."'" ?>,'welcome.php');
    d.add(++treeId,1,'运营数据');
    <?php if(show_a($priv,'tongji_main')) {?>d.add(subId++,treeId,'充值数据','webroot/index.php?s=dau');<?php }?>
    <?php if(show_a($priv,'tongji_main')) {?>d.add(subId++,treeId,'每日充值','webroot/index.php?s=account_charge');<?php }?>
    d.add(++treeId,1,'客服工具');
    <?php if(show_a($priv,'priv_gm_info')) {?>d.add(subId++,treeId,'帐号管理','webroot/index.php?s=alipay_account&status=0');<?php }?>
    <?php if(show_a($priv,'priv_gm_info')) {?>d.add(subId++,treeId,'订单查询','webroot/index.php?s=order');<?php }?>
    <?php if(show_a($priv,'priv_gm_info')) {?>d.add(subId++,treeId,'收款','webroot/index.php?s=gathering&status=0');<?php }?>
    // 10000以上的编号给系统设置用
    d.add(10000,1,'系统设置');
    d.add(20000,10000,'权限管理');
    <?php if(show_a($priv,'priv_user')) {?>d.add(subId++,20000,'用户列表','user.php');<?php }?>
    <?php if(show_a($priv,'priv_user')) {?>d.add(subId++,20000,'添加用户','user.php?ac=add');<?php }?>
    <?php if(show_a($priv,'priv_user')) {?>d.add(subId++,20000,'设置IP','user.php?ac=ip_edit');<?php }?>
    d.add(20001,10000,'操作记录');
    <?php if(show_a($priv,'priv_user')) {?>d.add(subId++,20001,'详细记录','operate_history.php');<?php }?>
    d.add(20002,10000,'修改密码','password.php');
    document.write(d);
    d.openAll();
    </script>
</div>

<div class="logout_div">
    <ul>
        <li class="logout"><a href="index.php?ac=logout" target="_top">退出</a></li>
    </ul>
</div>
<script type="text/javascript">
var time_old = '';
var time_new = '';
var num_online_old = 0;
var num_login_old = 0;
var num_new_old = 0;
var num_online_new = 0;
var num_login_new = 0;
var num_new_new = 0;

var exception_id = 0;

var hour_old = '';
var hour_new = '';
var num_vip_old = 0;
var num_eshop_old = 0;
var num_vip_new = 0;
var num_eshop_new = 0;

//setInterval("detect();", 180000);
//setInterval("detect_vip_eshop();", 240000);
//setInterval("detect_exception();", 300000);
</script>
</body>
</html>
