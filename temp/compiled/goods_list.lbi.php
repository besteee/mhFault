<div id="filter">
<div class="fore1">
<dl class="order"><dt>排序：</dt>
<dd<?php if ($this->_var['pager']['sort'] == 'goods_id'): ?> class="curr"<?php endif; ?>><a href="<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=goods_id&order=<?php if ($this->_var['pager']['sort'] == 'goods_id' && $this->_var['pager']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#goods_list">上架</a><b></b></dd>
<dd<?php if ($this->_var['pager']['sort'] == 'shop_price'): ?> class="curr"<?php endif; ?>><b></b><a href="<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=shop_price&order=<?php if ($this->_var['pager']['sort'] == 'shop_price' && $this->_var['pager']['order'] == 'ASC'): ?>DESC<?php else: ?>ASC<?php endif; ?>#goods_list" rel="nofollow">价格</a><b></b></dd>
<dd<?php if ($this->_var['pager']['sort'] == 'last_update'): ?> class="curr"<?php endif; ?>><a href="<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=last_update&order=<?php if ($this->_var['pager']['sort'] == 'last_update' && $this->_var['pager']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#goods_list" rel="nofollow">更新</a><b></b></dd>
<dd<?php if ($this->_var['pager']['sort'] == 'click_count'): ?> class="curr"<?php endif; ?>><a href="<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=click_count&order=<?php if ($this->_var['pager']['sort'] == 'click_count' && $this->_var['pager']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#goods_list" rel="nofollow">人气</a><b></b></dd>
</dl>
<div class="pagin pagin-m"><span class="text"><?php echo $this->_var['pager']['page']; ?>/<?php echo $this->_var['pager']['page_count']; ?></span>
<?php if ($this->_var['pager']['page_prev']): ?><a class="prev" href='<?php echo $this->_var['pager']['page_prev']; ?>'>上一页</a><?php else: ?><span class="prev-disabled">上一页<b></b></span><?php endif; ?>
  <?php if ($this->_var['pager']['page_next']): ?><a class="next" href='<?php echo $this->_var['pager']['page_next']; ?>'>下一页<b></b></a><?php else: ?><span class="next-disabled">下一页<b></b></span><?php endif; ?>
</div>
<div class="total"><span>共<strong><?php echo $this->_var['pager']['record_count']; ?></strong>个商品</span></div>
<span class="clr"></span>
</div>
</div>
<div class="blank"></div>
    <?php if ($this->_var['category'] > 0): ?>
  <form name="compareForm" action="compare.php" method="post" onSubmit="return compareGoods(this);">
    <?php endif; ?>
    <?php if ($this->_var['pager']['display'] == 'list'): ?>
    <div class="goodsList">
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
    <ul class="clearfix bgcolor"<?php if (($this->_foreach['goods_list']['iteration'] - 1) % 2 == 0): ?>id=""<?php else: ?>id="bgcolor"<?php endif; ?>>
    <li>
    <br>
    <a href="javascript:;" id="compareLink" onClick="Compare.add(<?php echo $this->_var['goods']['goods_id']; ?>,'<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>','<?php echo $this->_var['goods']['type']; ?>')" class="f6">比较</a>
    </li>
    <li class="thumb"><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>" /></a></li>
    <li class="goodsName">
    <a href="<?php echo $this->_var['goods']['url']; ?>">
        <?php if ($this->_var['goods']['goods_style_name']): ?>
        <?php echo $this->_var['goods']['goods_style_name']; ?><br />
        <?php else: ?>
        <?php echo $this->_var['goods']['goods_name']; ?><br />
        <?php endif; ?>
      </a>
     <?php if ($this->_var['goods']['goods_brief']): ?>
    <span><?php echo $this->_var['lang']['goods_brief']; ?><?php echo $this->_var['goods']['goods_brief']; ?></span><br />
    <?php endif; ?>
    </li>
    <li>
    <?php if ($this->_var['goods']['promote_price'] != ""): ?>
    <font class="shop"><?php echo $this->_var['goods']['promote_price']; ?></font><br />
    <?php else: ?>
    <font class="shop"><?php echo $this->_var['goods']['shop_price']; ?></font><br />
    <?php endif; ?>
    </li>
    <li class="action">
    <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/jd2013/images/buy.gif"></a> &nbsp;
    <a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);"><img src="themes/jd2013/images/collect.gif"></a>
    </li>
    </ul>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <?php elseif ($this->_var['pager']['display'] == 'grid'): ?>
    <div class="clearfix">
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['foo']['iteration']++;
?>
    <?php if ($this->_var['goods']['goods_id']): ?>
		<div class="goodsItem">
		  <?php if ($this->_var['goods']['watermark_img']): ?><span class="<?php echo $this->_var['goods']['watermark_img']; ?>"></span><?php endif; ?>
			<div class="goodsimg"><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>" class="thumb" /></a></div> 
			<div class="name"><p><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['goods_name']; ?><font class="brief"><?php echo $this->_var['goods']['goods_brief']; ?></font></a></p></div> 
			 <p>
			  <?php if ($this->_var['goods']['promote_price'] != ""): ?><font class="f1"><?php echo $this->_var['goods']['promote_price']; ?></font><?php else: ?><font class="f1"><?php echo $this->_var['goods']['shop_price']; ?></font><?php endif; ?> 
			 </p>		
			 <div class="gbuy clearfix">
             <div class="gbuycart"><a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/jd2013/images/buylist.gif" /></a></div>
			 <div class="gbuyr"><a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);"><img src="themes/jd2013/images/collect.gif"></a></div>
			 <div class="gbuyr"><a href="javascript:;" id="compareLink" onClick="Compare.add(<?php echo $this->_var['goods']['goods_id']; ?>,'<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>','<?php echo $this->_var['goods']['type']; ?>')"><img src="themes/jd2013/images/bcompare.gif"></a></div>
		   </div>	
		</div>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <?php elseif ($this->_var['pager']['display'] == 'text'): ?>
    <div class="goodsList">
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
     <ul class="clearfix bgcolor"<?php if (($this->_foreach['goods_list']['iteration'] - 1) % 2 == 0): ?>id=""<?php else: ?>id="bgcolor"<?php endif; ?>>
    <li style="margin-right:15px;">
    <a href="javascript:;" id="compareLink" onClick="Compare.add(<?php echo $this->_var['goods']['goods_id']; ?>,'<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>','<?php echo $this->_var['goods']['type']; ?>')" class="f6"><?php echo $this->_var['lang']['compare']; ?></a>
    </li>
    <li class="goodsName">
    <a href="<?php echo $this->_var['goods']['url']; ?>" class="f6">
        <?php if ($this->_var['goods']['goods_style_name']): ?>
        <?php echo $this->_var['goods']['goods_style_name']; ?><br />
        <?php else: ?>
        <?php echo $this->_var['goods']['goods_name']; ?><br />
        <?php endif; ?>
      </a>
     <?php if ($this->_var['goods']['goods_brief']): ?>
    <span><?php echo $this->_var['lang']['goods_brief']; ?><?php echo $this->_var['goods']['goods_brief']; ?></span><br />
    <?php endif; ?>
    </li>
    <li>
    <?php if ($this->_var['show_marketprice']): ?>
    <?php echo $this->_var['lang']['market_price']; ?><font class="market"><?php echo $this->_var['goods']['market_price']; ?></font><br />
    <?php endif; ?>
    <?php if ($this->_var['goods']['promote_price'] != ""): ?>
    <?php echo $this->_var['lang']['promote_price']; ?><font class="shop"><?php echo $this->_var['goods']['promote_price']; ?></font><br />
    <?php else: ?>
    <?php echo $this->_var['lang']['shop_price']; ?><font class="shop"><?php echo $this->_var['goods']['shop_price']; ?></font><br />
    <?php endif; ?>
    </li>
    <li class="action">
    <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/jd2013/images/buy.gif"></a> &nbsp;
    <a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);"><img src="themes/jd2013/images/collect.gif"></a>
    </li>
    </ul>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <?php endif; ?>
  <?php if ($this->_var['category'] > 0): ?>
  </form>
  <?php endif; ?>

<div class="blank"></div>
<div class="blank5"></div>
<script type="Text/Javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>
<script type="text/javascript">
window.onload = function()
{
  Compare.init();
}
<?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
<?php if ($this->_var['key'] != 'button_compare'): ?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php else: ?>
var button_compare = '';
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>