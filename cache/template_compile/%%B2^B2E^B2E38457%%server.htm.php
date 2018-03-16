<?php /* Smarty version 2.6.22, created on 2018-01-16 11:41:13
         compiled from D:%5Csoftware%5CUSBWebserver%5Croot%5Cgm//view/server.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script LANGUAGE="JavaScript">
    function getFlashLine(key){
        var columnChart = new FusionCharts(
            {
                type: 'scrollcombidy2d',//'scrollcolumn2d', //'scrollstackedcolumn2d',
                width: '100%',
                height: 200,
                renderAt: key,
                dataFormat: 'json',
                dataSource: '<?php echo $this->_tpl_vars['data_source']; ?>
',
          });
        // Render the chart
        columnChart.render();
    }
</script>

<div class="menu" align="center"></div>

<div>
    <div class="head_tp">统计概况</div>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="25%" align="center">&nbsp;</td>
            <td width="25%" align="center">CPU</td>
            <td width="25%" align="center">联网人数</td>
            <td width="25%" align="center">房间数</td>
        </tr>
        <tr>
            <td align="center">最高</td>
            <td align="center"><?php echo $this->_tpl_vars['max_cpu']; ?>
<br /><?php echo $this->_tpl_vars['max_cpu_id']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['max_user_num']; ?>
<br /><?php echo $this->_tpl_vars['max_user_num_id']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['max_room_num']; ?>
<br /><?php echo $this->_tpl_vars['max_room_num_id']; ?>
</td>
        </tr>
    </table>
</div>
<div id="server_status" align="center"></div>
<script type="text/javascript">getFlashLine('server_status');</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>