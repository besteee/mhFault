<?php if ($this->_var['price_grade']): ?>
<div class="box">
 <div class="box_1">
  <h3><span><?php echo $this->_var['lang']['price_grade']; ?></span></h3>
  <div class="boxCenterList RelaArticle">
    <?php $_from = $this->_var['price_grade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'grade');if (count($_from)):
    foreach ($_from AS $this->_var['grade']):
?>
    <?php if ($this->_var['grade']['selected']): ?>
    <img src="themes/jd2013/images/alone.gif" style=" margin-right:8px;"><font class="f1 f5"><?php echo $this->_var['grade']['start']; ?> - <?php echo $this->_var['grade']['end']; ?> <?php if ($this->_var['grade']['goods_num']): ?>(<?php echo $this->_var['grade']['goods_num']; ?>)<?php endif; ?></font><br />
    <?php else: ?>
    <a href="<?php echo $this->_var['grade']['url']; ?>"><?php echo $this->_var['grade']['start']; ?> - <?php echo $this->_var['grade']['end']; ?></a> <?php if ($this->_var['grade']['goods_num']): ?>(<?php echo $this->_var['grade']['goods_num']; ?>)<?php endif; ?><br />
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
 </div>
</div>
<div class="blank5"></div>
<?php endif; ?>
