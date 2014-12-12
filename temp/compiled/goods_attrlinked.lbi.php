<?php $_from = $this->_var['attribute_linked']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'linked');if (count($_from)):
    foreach ($_from AS $this->_var['linked']):
?>
<?php if ($this->_var['linked']['goods']): ?>
<div class="box_1 clearfix">
  <div class="category_all"><div class="tit" title="<?php echo $this->_var['linked']['title']; ?>"><?php echo sub_str($this->_var['linked']['title'],11); ?></div></div>
  <div class="boxCenterList1 clearfix" id='history_list'> 
  <?php $_from = $this->_var['linked']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'linked_goods_data');if (count($_from)):
    foreach ($_from AS $this->_var['linked_goods_data']):
?>
  <ul class="clearfix">
      <li class="goodsimg">
      <a href="<?php echo $this->_var['linked_goods_data']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['linked_goods_data']['goods_thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['linked_goods_data']['name']); ?>" class="B_blue" /></a>
      </li>
      <li>
      <a href="<?php echo $this->_var['linked_goods_data']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['linked_goods_data_name']); ?>"><?php echo htmlspecialchars($this->_var['linked_goods_data']['short_name']); ?></a><br />
      <?php echo $this->_var['lang']['shop_price']; ?><font class="f1"><?php echo $this->_var['linked_goods_data']['shop_price']; ?></font><br />
      </li>
    </ul>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
 </div>
<div class="blank5"></div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>