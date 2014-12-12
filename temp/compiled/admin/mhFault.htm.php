<?php echo $this->fetch('mhFaultpageheader.htm'); ?>

<table id="mhFaultAll">
<?php $_from = $this->_var['fault']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'mhFault');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['mhFault']):
?>
	<tr class="mhF">
		<td class="mhFault" fault_id="<?php echo $this->_var['mhFault']['id']; ?>"><?php echo $this->_var['mhFault']['name']; ?></td>
		<td class="subMhF">
		<?php $_from = $this->_var['mhFault']['subMhFault']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'subMhFault');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['subMhFault']):
?>
			<a href="/admin/mhFault.php?act=detail&fault_id=<?php echo $this->_var['subMhFault']['id']; ?>&fault_name=<?php echo $this->_var['subMhFault']['name']; ?>"><li class="subMhFault" fault_id="<?php echo $this->_var['subMhFault']['id']; ?>"><?php echo $this->_var['subMhFault']['name']; ?></li></a>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</td>
	</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>



<script type="text/javascript">

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>