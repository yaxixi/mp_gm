<?php /* Smarty version 2.6.22, created on 2018-01-17 17:29:04
         compiled from D:%5Csoftware%5CUSBWebserver%5Croot%5Cgm//view/map_info.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'D:\\software\\USBWebserver\\root\\gm//view/map_info.htm', 39, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class='input'>
	<form method="POST">
	作者RID：<input type="text" name="author_rid">
	作者昵称：<input type="text" name="author_name">
	地图ID：<input type="text" name="map_id">
	地图名：<input type="text" name="map_name">
	<input type="submit" value="查询">
	</form>
</div>
<div>
</br>
<span>地图信息</span>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr align="center">
		<th>地图ID</th>
		<th>地图名</th>
		<th>地图类型</th>
		<th>地图评分</th>
		<th>地图文件</th>
		<th>作者RID</th>
		<th>作者昵称</th>
		<th>地图更新时间</th>
		<th>地图大小</th>
		<th>地图版本</th>
		<th>地图完成度</th>
		<th>地图描述</th>
	</tr>
	<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
	<tr align="center">
		<td><?php echo $this->_tpl_vars['val']['id']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['map_name']; ?>
</td>
		<td><?php echo $this->_tpl_vars['type_map'][$this->_tpl_vars['val']['type']]; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['score']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['file']; ?>
</td>
		<td><a href="index.php?s=user_info&rid=<?php echo $this->_tpl_vars['val']['author_rid']; ?>
"><?php echo $this->_tpl_vars['val']['author_rid']; ?>
</a></td>
		<td><?php echo $this->_tpl_vars['val']['author_name']; ?>
</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['update_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['map_size']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['version_text']; ?>
</td>
		<td><?php echo $this->_tpl_vars['status_map'][$this->_tpl_vars['val']['status']]; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['map_desc']; ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>