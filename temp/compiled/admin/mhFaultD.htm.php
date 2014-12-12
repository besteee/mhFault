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

<table id="mhFaultDetail">
<tr><td class="topName" id="topNameTitle" colspan="4" fault_id="<?php echo $this->_var['fault_id']; ?>" diyId="<?php echo $this->_var['diyId']; ?>"><input type="text" value="<?php echo $this->_var['fault_name']; ?> 故障恢复　套餐包" style="width:300px;"></td></tr>
<?php $_from = $this->_var['fault_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'mhFault');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['mhFault']):
?>
	<tr class="mhFD">
		<td class="mhFaultD" fault_id="<?php echo $this->_var['mhFault']['id']; ?>"><?php echo $this->_var['mhFault']['name']; ?></td>
		<td class="subMhFD">
			<table class="subMhFdT">
				<tr>
					<th width="30%">故障名称</th>
					<th>匹配费</th>
					<th>工时费</th>
					<th>材料费</th>
				</tr>
				<?php $_from = $this->_var['mhFault']['subMhFault']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'subMhFault');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['subMhFault']):
?>
				<tr>
					<td  fault_id="<?php echo $this->_var['subMhFault']['id']; ?>"><?php echo $this->_var['subMhFault']['name']; ?></td>
					<td  class="matePrice"><input type="text" value=<?php echo $this->_var['subMhFault']['matePrice']; ?>></td>
					<td  class="timePrice"><input type="text" value=<?php echo $this->_var['subMhFault']['timePrice']; ?>></td>
					<td  class="materialsPrice"><input type="text" value=<?php echo $this->_var['subMhFault']['materialsPrice']; ?>></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
		</td>
	</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<tr><td class="topName" id="mhFoot" colspan="4" style="text-align:center;"><button id="btnTotal">合计</button></td></tr>
</table>
<script type="text/javascript">
function price(className){
var price="";
	$(className+" input").each(function(){
		price+=$(this).val()+',';
	}); 
	price=price.replace(/,$/ig,""); 
	return price;
}
function priceNum(className){
var price=0;
	$(className+" input").each(function(){
		price+=parseFloat($(this).val()+'.00');
	}); 
	return price;
}


$("#btnTotal").click(function(){
	var matePrice=price('.matePrice');
	var matePriceNum=priceNum('.matePrice');
	var timePrice=price('.timePrice');
	var timePriceNum=priceNum('.timePrice');
	var materialsPrice=price('.materialsPrice');
	var materialsPriceNum=priceNum('.materialsPrice');
	var totalPrice=matePriceNum+timePriceNum+materialsPriceNum;
	var goods_name=$("#topNameTitle input").val();
	var fault_id=$("#topNameTitle").attr("fault_id");
	var diyId=$("#topNameTitle").attr("diyId");
	var mhFootHtml="合计　";
	mhFootHtml+='匹配费：￥'+matePriceNum+'元　';
	mhFootHtml+='工时费：￥'+timePriceNum+'元　';
	mhFootHtml+='材料费：￥'+materialsPriceNum+'元　';
	mhFootHtml+='总计：￥'+totalPrice+'元　';
	mhFootHtml+='<button id="btnAddGoods">生成套餐</button>';
	$("#mhFoot").html(mhFootHtml);
	$("#btnAddGoods").click(function(){
		$.ajax({
			url:'addGoods.php',
			type: 'POST',
			data:{action:'addGoods',goods_nameP:goods_name,shop_priceP:totalPrice,matePriceP:matePrice,timePriceP:timePrice,materialsPriceP:materialsPrice,matePriceNumP:matePriceNum,timePriceNumP:timePriceNum,materialsPriceNumP:materialsPriceNum,fault_idP:fault_id,diyIdP:diyId},
			dataType: 'html',
			success: function(result)
			{
				alert(result);
			}
		});
	});
});
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>