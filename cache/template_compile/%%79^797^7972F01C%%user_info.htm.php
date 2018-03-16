<?php /* Smarty version 2.6.22, created on 2018-01-17 10:50:43
         compiled from D:%5Csoftware%5CUSBWebserver%5Croot%5Cgm//view/user_info.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class='input'>
	<form method="POST">
	账号：<input type="text" name="account">
	渠道：<input type="text" name="channel">
	RID：<input type="text" name="rid">
	昵称：<input type="text" name="name">
	<input type="submit" value="查询">
	</form>
</div>
<div>
<span>基础信息</span>
<table>
	<tr>
		<td>rid</td>
		<td><?php echo $this->_tpl_vars['data']['rid']; ?>
</td>
	</tr>
	<tr>
		<td>昵称</td>
		<td><?php echo $this->_tpl_vars['data']['name']; ?>
</td>
	</tr>
	<tr>
		<td>账号</td>
		<td><?php echo $this->_tpl_vars['data']['account']; ?>
</td>
	</tr>
	<tr>
		<td>渠道</td>
		<td><?php echo $this->_tpl_vars['data']['channel']; ?>
</td>
	</tr>
	<tr>
		<td>账号权限</td>
		<td><?php echo $this->_tpl_vars['data']['privilege']; ?>
</td>
	</tr>
	<tr>
		<td>所在区组</td>
		<td><?php echo $this->_tpl_vars['data']['dist_id']; ?>
</td>
	</tr>
	<tr>
		<td>创建时间</td>
		<td><?php echo $this->_tpl_vars['data']['create_time']; ?>
</td>
	</tr>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>