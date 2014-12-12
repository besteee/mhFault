<?php if ($this->_var['filter_attr_list']): ?>
<div class="box">
 <div class="box_1">
  <h3><span><?php echo $this->_var['filter_attr_name']; ?></span></h3>
  <div class="boxCenterList RelaArticle">
    <?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['attr']):
?>
    <?php if ($this->_var['attr']['selected']): ?>
    <a href="<?php echo $this->_var['attr']['url']; ?>"><?php echo $this->_var['attr']['attr_value']; ?><?php if ($this->_var['attr']['goods_num']): ?>(<?php echo $this->_var['attr']['goods_num']; ?>)<?php endif; ?></a><br />
    <?php else: ?>
    <a href="<?php echo $this->_var['attr']['url']; ?>"><?php echo $this->_var['attr']['attr_value']; ?><?php if ($this->_var['attr']['goods_num']): ?>(<?php echo $this->_var['attr']['goods_num']; ?>)<?php endif; ?></a><br />
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
 </div>
</div>
<div class="blank5"></div>
<?php endif; ?>