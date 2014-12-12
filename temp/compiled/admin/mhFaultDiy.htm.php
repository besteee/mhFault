<?php echo $this->fetch('mhFaultpageheader.htm'); ?>


<table id="mhFaultAll" >
	<tr>
		<th class="mhFaultD_title">id</th>
		<th class="mhFaultD_title">客户编号</th>
		<td class="mhFaultD_title">客户名称</td>
		<td class="mhFaultD_title">车型</td>
		<td class="mhFaultD_title">故障</td>
		<td class="mhFaultD_title">故障id</td>
	</tr>
<?php $_from = $this->_var['fault_diy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'diy');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['diy']):
?>
	<tr>
		<td class="mhFaultD_text"><?php echo $this->_var['diy']['id']; ?></td>
		<td class="mhFaultD_text"><?php echo $this->_var['diy']['user_id']; ?></td>
		<td class="mhFaultD_text"><?php echo $this->_var['diy']['name']; ?></td>
		<td class="mhFaultD_text"><?php echo $this->_var['diy']['cartype']; ?></td>
		<td class="mhFaultD_text"><?php echo $this->_var['diy']['need']; ?></td>
		<td class="mhFaultD_text"><a href="/admin/mhFault.php?act=detail&fault_id=<?php echo $this->_var['diy']['fault_id']; ?>&fault_name=<?php echo $this->_var['diy']['cartype']; ?> <?php echo $this->_var['diy']['need']; ?>&diyId=<?php echo $this->_var['diy']['id']; ?>">生成套餐包</a></td>
	</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>




<script type="text/javascript">

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>