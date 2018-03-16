<?php /* Smarty version 2.6.22, created on 2018-03-08 21:57:25
         compiled from D:%5Csoftware%5CUSBWebserver%5Croot%5Cmpay//view/gathering.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script LANGUAGE="JavaScript">
function gathering(id){
	var orderid = document.getElementById('orderid').value;
	console.log("gathering : %d, orderid : %s", id, orderid);
    $.get(window.location.origin + "/mpay/source/gathering.php?orderid=" + orderid + "&id=" + id, function(result){
        var ret = "操作成功";
        if (result == "OK")
			alert(ret);
		else
			alert(result);
    });
}
</script>

<div class='input'>
	<form method="POST">
	支付宝用户名：<input type="text" name="userid">
	转账金额：<input type="text" name="price">
	转账时间：<input type="text" name="clientTime">
	<input type="submit" value="查询">
	</form>
</div>
<div>
</br>
<h4>未到账记录列表</h4>
<table cellpadding="20" cellspacing="10">
	<tr align="center">
		<th>转账支付宝</th>
		<th>收款支付宝</th>
		<th>转账金额</th>
        <th>备注</th>
		<th>转账时间</th>
		<th>操作</th>
		<th>订单号</th>
	</tr>
	<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
	<tr align="center">
        <td><?php echo $this->_tpl_vars['val']['userid']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['account']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['price']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['remark']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['clientTime']; ?>
</td>
        <td><button type="button" onClick=gathering(<?php echo $this->_tpl_vars['val']['id']; ?>
)>找回</button></td>
		<td><input type="text" id="orderid" name="orderid" /></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>