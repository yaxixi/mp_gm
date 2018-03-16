<?php /* Smarty version 2.6.22, created on 2018-01-23 15:28:33
         compiled from D:%5Csoftware%5CUSBWebserver%5Croot%5Cgm//view/find_source_map.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script LANGUAGE="JavaScript">
function find_source_map(key){
    $.get(window.location.origin + "/gm/source/find_source_map.php?src_file=" + key, function(result){
        var ret = "找回成功";
        try{
            result = JSON.parse(result);
            if (result['ret'] != 0)
                ret = "找回失败";
        }
        catch(err)
        {
            ret = "找回失败";
        }
        alert(ret);
    });
}
</script>

<div class='input'>
	<form method="POST">
	作者RID：<input type="text" name="rid">
	<input type="submit" value="查询">
	</form>
</div>
<div>
</br>
<span>域名前缀：<?php if ($this->_tpl_vars['data']['url']): ?><?php echo $this->_tpl_vars['data']['url']; ?>
<?php endif; ?><?php if (! $this->_tpl_vars['data']['url']): ?>http://slimeeditor.oss-cn-shanghai.aliyuncs.com/maps/published_source_maps/<?php endif; ?></span>
</br>
</br>
<h4>源地图列表</h4>
<table cellpadding="20" cellspacing="10">
	<tr align="center">
		<th>文件名</th>
		<th>更改时间</th>
        <th>操作</th>
	</tr>
	<?php $_from = $this->_tpl_vars['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
	<tr align="center">
        <td><?php echo $this->_tpl_vars['val']['file']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['modifyTime']; ?>
</td>
        <td><button type="button" onClick=find_source_map('<?php echo $this->_tpl_vars['val']['file']; ?>
')>找回</button></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>