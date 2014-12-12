<?php $this->assign('categories', get_categories_tree());?>
<div id="sortlist">  
<div class="mt"><h2>商品分类</h2></div>
	<div class="mc">
       <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_0_42047400_1418274503');$this->_foreach['childnum'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['childnum']['total'] > 0):
    foreach ($_from AS $this->_var['cat_0_42047400_1418274503']):
        $this->_foreach['childnum']['iteration']++;
?> 
	<div id="subitem<?php echo $this->_foreach['childnum']['iteration']; ?>" class="item"><h3 onclick="showmenu(<?php echo $this->_foreach['childnum']['iteration']; ?>)"><b></b><?php echo htmlspecialchars($this->_var['cat_0_42047400_1418274503']['name']); ?></h3>
	<ul>
	<?php $_from = $this->_var['cat_0_42047400_1418274503']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>   
	   <li><a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></li>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	</ul>
	</div>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
	</div>
</div>
<script language="javascript">
function showmenu(sid)
{
var subitem=document.getElementById("subitem"+sid);
if(subitem.className=='item'){
subitem.className='item current';
}
else{
subitem.className='item';
}
}
</script>
<div class="blank"></div>