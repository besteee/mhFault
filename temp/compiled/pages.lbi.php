
<form name="selectPageForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<?php if ($this->_var['pager']['styleid'] == 0): ?>
<div id="pager">
  <?php echo $this->_var['lang']['pager_1']; ?><?php echo $this->_var['pager']['record_count']; ?><?php echo $this->_var['lang']['pager_2']; ?><?php echo $this->_var['lang']['pager_3']; ?><?php echo $this->_var['pager']['page_count']; ?><?php echo $this->_var['lang']['pager_4']; ?> <span> <a href="<?php echo $this->_var['pager']['page_first']; ?>"><?php echo $this->_var['lang']['page_first']; ?></a> <a href="<?php echo $this->_var['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?></a> <a href="<?php echo $this->_var['pager']['page_next']; ?>"><?php echo $this->_var['lang']['page_next']; ?></a> <a href="<?php echo $this->_var['pager']['page_last']; ?>"><?php echo $this->_var['lang']['page_last']; ?></a> </span>
    <?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_55909600_1418266297');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_55909600_1418266297']):
?>
      <?php if ($this->_var['key'] == 'keywords'): ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo urldecode($this->_var['item_0_55909600_1418266297']); ?>" />
        <?php else: ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['item_0_55909600_1418266297']; ?>" />
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <select name="page" id="page" onchange="selectPage(this)">
    <?php echo $this->html_options(array('options'=>$this->_var['pager']['array'],'selected'=>$this->_var['pager']['page'])); ?>
    </select>
</div>
<?php else: ?>

 



<div class="clearfix">
    <div class="pagin f_r">
     <?php if ($this->_var['pager']['page_prev']): ?><a class="prev" href="<?php echo $this->_var['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?><b></b></a><?php else: ?><span class="prev-disabled"><?php echo $this->_var['lang']['page_prev']; ?><b></b></span><?php endif; ?>
       
    <?php if ($this->_var['pager']['page_count'] != 1): ?>
    <?php $_from = $this->_var['pager']['page_number']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_55980800_1418266297');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_55980800_1418266297']):
?>
      <?php if ($this->_var['pager']['page'] == $this->_var['key']): ?>
      <a href="<?php echo $this->_var['item_0_55980800_1418266297']; ?>" class="current"><?php echo $this->_var['key']; ?></a>
      <?php else: ?>
      <a href="<?php echo $this->_var['item_0_55980800_1418266297']; ?>"><?php echo $this->_var['key']; ?></a>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endif; ?>
    
     <?php if ($this->_var['pager']['page_next']): ?><a class="next" href='<?php echo $this->_var['pager']['page_next']; ?>'><?php echo $this->_var['lang']['page_next']; ?><b></b></a><?php else: ?><span class="next-disabled"><?php echo $this->_var['lang']['page_next']; ?><b></b></span><?php endif; ?>
     
     <?php if ($this->_var['pager']['page_kbd']): ?>
    <?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_56037600_1418266297');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_56037600_1418266297']):
?>
      <?php if ($this->_var['key'] == 'keywords'): ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo urldecode($this->_var['item_0_56037600_1418266297']); ?>" />
        <?php else: ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['item_0_56037600_1418266297']; ?>" />
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <kbd style="float:left; margin:0 8px; position:relative; top:3px;"><input type="text" name="page" onkeydown="if(event.keyCode==13)selectPage(this)" size="3" class="B_blue" /></kbd>
 <?php endif; ?> 
        
    </div>
    
</div>

<?php endif; ?>
</form>
<script type="Text/Javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>
