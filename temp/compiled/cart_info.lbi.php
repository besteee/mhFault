<dt class="ld"><s></s><span class="shopping"><span id="shopping-amount"><?php echo $this->_var['str_num']; ?></span></span><a href="flow.php" id="settleup-url">去购物车结算</a> <b></b> </dt>
			      <?php if ($this->_var['goods']): ?>
		 <span id="ECS_CARTINFO">	<dd><div id="settleup-content"><div class="smt"><h4 class="fl">最新加入的商品</h4></div>
				<div class="smc">
				<ul id="mcart-sigle">
				</ul>
				<ul id="mcart-gift"> 
				  <?php $_from = $this->_var['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_58204000_1418266297');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_58204000_1418266297']):
        $this->_foreach['goods']['iteration']++;
?> 
				<li>      
				 <div class="p-img fl"><a target="_blank" href="<?php echo $this->_var['goods_0_58204000_1418266297']['url']; ?>"><img src="<?php echo $this->_var['goods_0_58204000_1418266297']['goods_thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_58204000_1418266297']['goods_name']); ?>" height="50" width="50"></a></div>        <div class="p-name fl"><a href="<?php echo $this->_var['goods_0_58204000_1418266297']['url']; ?>"><?php echo $this->_var['goods_0_58204000_1418266297']['goods_name']; ?></a></div>        <div class="p-detail fr ar"> <span class="p-price"><strong><?php echo $this->_var['goods_0_58204000_1418266297']['goods_price']; ?></strong>×<?php echo $this->_var['goods_0_58204000_1418266297']['goods_number']; ?></span>  <br>   <a class="delete" href="javascript:" onClick="deleteCartGoods(<?php echo $this->_var['goods_0_58204000_1418266297']['rec_id']; ?>)">删除</a> </div>    
				  </li>
				  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
				</div><div class="smb ar">共<b><?php echo $this->_var['str_num']; ?></b>件商品　共计<strong><?php echo $this->_var['str_price']; ?></strong><br><a href="flow.php" title="去购物车结算" id="btn-payforgoods">去购物车结算</a></div></div></dd></span>
        <?php else: ?>
       <dd><div class="prompt"><div class="nogoods"><b></b>购物车中还没有商品，赶紧选购吧！</div></div></dd>
        <?php endif; ?>

<script type="text/javascript">
function deleteCartGoods(rec_id)
{
Ajax.call('delete_cart_goods.php', 'id='+rec_id, deleteCartGoodsResponse, 'POST', 'JSON');
}

/**
 * 接收返回的信息
 */
function deleteCartGoodsResponse(res)
{
  if (res.error)
  {
    alert(res.err_msg);
  }
  else
  {
      document.getElementById('ECS_CARTINFO').innerHTML = res.content;
  }
}
</script>

