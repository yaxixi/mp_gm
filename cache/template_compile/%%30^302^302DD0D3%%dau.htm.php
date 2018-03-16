<?php /* Smarty version 2.6.22, created on 2018-01-16 11:41:11
         compiled from D:%5Csoftware%5CUSBWebserver%5Croot%5Cgm//view/dau.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script LANGUAGE="JavaScript">
    function getFlashLine(key){
        var columnChart = new FusionCharts(
            {
                type: 'scrollline2d', //'scrollstackedcolumn2d',
                id: 'ex1',
                width: '100%',
                height: 400,
                renderAt: 'online',
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
            <td width="25%" align="center">登录</td>
            <td width="25%" align="center">新增</td>
        </tr>
        <tr>
            <td align="center">今日当前</td>
            <td align="center"><?php echo $this->_tpl_vars['login']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['new_today']; ?>
</td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:10px 0 10px 0;">
        <tr>
            <td width="25%" align="center">&nbsp;</td>
            <td width="25%" align="center">登录</td>
            <td width="25%" align="center">新增</td>
        </tr>
        <tr>
            <td align="center">昨日</td>
            <td align="center"><?php echo $this->_tpl_vars['login_yesterday']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['new_yesterday']; ?>
</td>
        </tr>
        <tr>
            <td align="center">上周同期</td>
            <td align="center"><?php echo $this->_tpl_vars['login_lday']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['new_lday']; ?>
</td>
        </tr>
        <tr>
            <td align="center">历史最高</td>
            <td align="center"><?php echo $this->_tpl_vars['login_top']['value']; ?>
<br /><?php echo $this->_tpl_vars['login_top']['date']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['new_max']['value']; ?>
<br /><?php echo $this->_tpl_vars['new_max']['date']; ?>
</td>
        </tr>
    </table>
</div>
<div id="online" align="center"></div>
<script type="text/javascript">getFlashLine('online');</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>