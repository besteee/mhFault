<!-- $Id: order_info.htm 17060 2010-03-25 03:44:42Z liuhui $ -->

<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'topbar.js,../js/utils.js,listtable.js,selectzone.js,../js/common.js')); ?>
<?php if ($this->_var['user']): ?>
<div id="topbar">
  <div align="right"><a href="" onclick="closebar(); return false"><img src="images/close.gif" border="0" /></a></div>
  <table width="100%" border="0">
    <caption><strong> <?php echo $this->_var['lang']['buyer_info']; ?> </strong></caption>
    <tr>
      <td> <?php echo $this->_var['lang']['email']; ?> </td>
      <td> <a href="mailto:<?php echo $this->_var['user']['email']; ?>"><?php echo $this->_var['user']['email']; ?></a> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['user_money']; ?> </td>
      <td> <?php echo $this->_var['user']['formated_user_money']; ?> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['pay_points']; ?> </td>
      <td> <?php echo $this->_var['user']['pay_points']; ?> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['rank_points']; ?> </td>
      <td> <?php echo $this->_var['user']['rank_points']; ?> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['rank_name']; ?> </td>
      <td> <?php echo $this->_var['user']['rank_name']; ?> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['bonus_count']; ?> </td>
      <td> <?php echo $this->_var['user']['bonus_count']; ?> </td>
    </tr>
  </table>

  <?php $_from = $this->_var['address_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'address');if (count($_from)):
    foreach ($_from AS $this->_var['address']):
?>
  <table width="100%" border="0">
    <caption><strong> <?php echo $this->_var['lang']['consignee']; ?> : <?php echo htmlspecialchars($this->_var['address']['consignee']); ?> </strong></caption>
    <tr>
      <td> <?php echo $this->_var['lang']['email']; ?> </td>
      <td> <a href="mailto:<?php echo htmlspecialchars($this->_var['address']['email']); ?>"><?php echo htmlspecialchars($this->_var['address']['email']); ?></a> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['address']; ?> </td>
      <td> <?php echo htmlspecialchars($this->_var['address']['address']); ?> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['zipcode']; ?> </td>
      <td> <?php echo htmlspecialchars($this->_var['address']['zipcode']); ?> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['tel']; ?> </td>
      <td> <?php echo htmlspecialchars($this->_var['address']['tel']); ?> </td>
    </tr>
    <tr>
      <td> <?php echo $this->_var['lang']['mobile']; ?> </td>
      <td> <?php echo htmlspecialchars($this->_var['address']['mobile']); ?> </td>
    </tr>
  </table>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>

<form action="order.php?act=operate" method="post" name="theForm">
<div class="list-div" style="margin-bottom: 5px">
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
    <td colspan="4">
      <div align="center">
        <input name="prev" type="button" class="button" onClick="location.href='order.php?act=info&order_id=<?php echo $this->_var['prev_id']; ?>';" value="<?php echo $this->_var['lang']['prev']; ?>" <?php if (! $this->_var['prev_id']): ?>disabled<?php endif; ?> />
        <input name="next" type="button" class="button" onClick="location.href='order.php?act=info&order_id=<?php echo $this->_var['next_id']; ?>';" value="<?php echo $this->_var['lang']['next']; ?>" <?php if (! $this->_var['next_id']): ?>disabled<?php endif; ?> />
        <input type="button" onclick="window.open('order.php?act=info&order_id=<?php echo $this->_var['order']['order_id']; ?>&print=1')" class="button" value="<?php echo $this->_var['lang']['print_order']; ?>" />
    </div></td>
  </tr>
  <tr>
    <th colspan="4"><?php echo $this->_var['lang']['base_info']; ?></th>
  </tr>
  <tr>
    <td width="18%"><div align="right"><strong><?php echo $this->_var['lang']['label_order_sn']; ?></strong></div></td>
    <td width="34%"><?php echo $this->_var['order']['order_sn']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><a href="group_buy.php?act=edit&id=<?php echo $this->_var['order']['extension_id']; ?>"><?php echo $this->_var['lang']['group_buy']; ?></a><?php elseif ($this->_var['order']['extension_code'] == "exchange_goods"): ?><a href="exchange_goods.php?act=edit&id=<?php echo $this->_var['order']['extension_id']; ?>"><?php echo $this->_var['lang']['exchange_goods']; ?></a><?php endif; ?></td>
    <td width="15%"><div align="right"><strong><?php echo $this->_var['lang']['label_order_status']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['status']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_user_name']; ?></strong></div></td>
    <td><?php echo empty($this->_var['order']['user_name']) ? $this->_var['lang']['anonymous'] : $this->_var['order']['user_name']; ?> <?php if ($this->_var['order']['user_id'] > 0): ?>[ <a href="" onclick="staticbar();return false;"><?php echo $this->_var['lang']['display_buyer']; ?></a> ] [ <a href="user_msg.php?act=add&order_id=<?php echo $this->_var['order']['order_id']; ?>&user_id=<?php echo $this->_var['order']['user_id']; ?>"><?php echo $this->_var['lang']['send_message']; ?></a> ]<?php endif; ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_order_time']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['formated_add_time']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_payment']; ?></strong></div></td>
    <td><?php if ($this->_var['order']['pay_id'] > 0): ?><?php echo $this->_var['order']['pay_name']; ?><?php else: ?><?php echo $this->_var['lang']['require_field']; ?><?php endif; ?><a href="order.php?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=payment" class="special"><?php echo $this->_var['lang']['edit']; ?></a>
    (<?php echo $this->_var['lang']['action_note']; ?>: <span onclick="listTable.edit(this, 'edit_pay_note', <?php echo $this->_var['order']['order_id']; ?>)"><?php if ($this->_var['order']['pay_note']): ?><?php echo $this->_var['order']['pay_note']; ?><?php else: ?>N/A<?php endif; ?></span>)</td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_pay_time']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['pay_time']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_shipping']; ?></strong></div></td>
    <td><?php if ($this->_var['exist_real_goods']): ?><?php if ($this->_var['order']['shipping_id'] > 0): ?><?php echo $this->_var['order']['shipping_name']; ?><?php else: ?><?php echo $this->_var['lang']['require_field']; ?><?php endif; ?><a href="order.php?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=shipping" class="special"><?php echo $this->_var['lang']['edit']; ?></a>&nbsp;&nbsp;<input type="button" onclick="window.open('order.php?act=info&order_id=<?php echo $this->_var['order']['order_id']; ?>&shipping_print=1')" class="button" value="<?php echo $this->_var['lang']['print_shipping']; ?>"> <?php if ($this->_var['order']['insure_fee'] > 0): ?>（<?php echo $this->_var['lang']['label_insure_fee']; ?><?php echo $this->_var['order']['formated_insure_fee']; ?>）<?php endif; ?><?php endif; ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_shipping_time']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['shipping_time']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_invoice_no']; ?></strong></div></td>
    <td><?php if ($this->_var['order']['shipping_id'] > 0 && $this->_var['order']['shipping_status'] > 0): ?><span><?php if ($this->_var['order']['invoice_no']): ?><?php echo $this->_var['order']['invoice_no']; ?><?php else: ?>N/A<?php endif; ?></span><a href="order.php?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=shipping" class="special"><?php echo $this->_var['lang']['edit']; ?></a><?php endif; ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['from_order']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['referer']; ?></td>
  </tr>
  <tr>
    <th colspan="4"><?php echo $this->_var['lang']['other_info']; ?><a href="order.php?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=other" class="special"><?php echo $this->_var['lang']['edit']; ?></a></th>
    </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_inv_type']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['inv_type']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_inv_payee']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['inv_payee']; ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_inv_content']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['inv_content']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_postscript']; ?></strong></div></td>
    <td colspan="3"><?php echo $this->_var['order']['postscript']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_how_oos']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['how_oos']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_pack']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['pack_name']; ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_card']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['card_name']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_card_message']; ?></strong></div></td>
    <td colspan="3"><?php echo $this->_var['order']['card_message']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_to_buyer']; ?></strong></div></td>
    <td colspan="3"><?php echo $this->_var['order']['to_buyer']; ?></td>
  </tr>
  <tr>
    <th colspan="4"><?php echo $this->_var['lang']['consignee_info']; ?><a href="order.php?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=consignee" class="special"><?php echo $this->_var['lang']['edit']; ?></a></th>
    </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_consignee']; ?></strong></div></td>
    <td><?php echo htmlspecialchars($this->_var['order']['consignee']); ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_email']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['email']; ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_address']; ?></strong></div></td>
    <td>[<?php echo $this->_var['order']['region']; ?>] <?php echo htmlspecialchars($this->_var['order']['address']); ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_zipcode']; ?></strong></div></td>
    <td><?php echo htmlspecialchars($this->_var['order']['zipcode']); ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_tel']; ?></strong></div></td>
    <td><?php echo $this->_var['order']['tel']; ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_mobile']; ?></strong></div></td>
    <td><?php echo htmlspecialchars($this->_var['order']['mobile']); ?></td>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_sign_building']; ?></strong></div></td>
    <td><?php echo htmlspecialchars($this->_var['order']['sign_building']); ?></td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_best_time']; ?></strong></div></td>
    <td><?php echo htmlspecialchars($this->_var['order']['best_time']); ?></td>
  </tr>
</table>
</div>

<div class="list-div" style="margin-bottom: 5px">
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
    <th colspan="8" scope="col"><?php echo $this->_var['lang']['goods_info']; ?><a href="order.php?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=goods" class="special"><?php echo $this->_var['lang']['edit']; ?></a></th>
    </tr>
  <tr>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['goods_name_brand']; ?></strong></div></td>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['goods_sn']; ?></strong></div></td>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['product_sn']; ?></strong></div></td>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['goods_price']; ?></strong></div></td>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['goods_number']; ?></strong></div></td>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['goods_attr']; ?></strong></div></td>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['storage']; ?></strong></div></td>
    <td scope="col"><div align="center"><strong><?php echo $this->_var['lang']['subtotal']; ?></strong></div></td>
  </tr>
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
  <tr>
    <td>
    <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
    <a href="../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?> <?php if ($this->_var['goods']['brand_name']): ?>[ <?php echo $this->_var['goods']['brand_name']; ?> ]<?php endif; ?>
    <?php if ($this->_var['goods']['is_gift']): ?><?php if ($this->_var['goods']['goods_price'] > 0): ?><?php echo $this->_var['lang']['remark_favourable']; ?><?php else: ?><?php echo $this->_var['lang']['remark_gift']; ?><?php endif; ?><?php endif; ?>
    <?php if ($this->_var['goods']['parent_id'] > 0): ?><?php echo $this->_var['lang']['remark_fittings']; ?><?php endif; ?></a>
    <?php elseif ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
    <a href="javascript:void(0)" onclick="setSuitShow(<?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_name']; ?><span style="color:#FF0000;"><?php echo $this->_var['lang']['remark_package']; ?></span></a>
    <div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" style="display:none">
        <?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');if (count($_from)):
    foreach ($_from AS $this->_var['package_goods_list']):
?>
          <a href="../goods.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>" target="_blank"><?php echo $this->_var['package_goods_list']['goods_name']; ?></a><br />
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <?php endif; ?>
    </td>
    <td><?php echo $this->_var['goods']['goods_sn']; ?></td>
    <td><?php echo $this->_var['goods']['product_sn']; ?></td>
    <td><div align="right"><?php echo $this->_var['goods']['formated_goods_price']; ?></div></td>
    <td><div align="right"><?php echo $this->_var['goods']['goods_number']; ?>
    </div></td>
    <td><?php echo nl2br($this->_var['goods']['goods_attr']); ?></td>
    <td><div align="right"><?php echo $this->_var['goods']['storage']; ?></div></td>
    <td><div align="right"><?php echo $this->_var['goods']['formated_subtotal']; ?></div></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php if ($this->_var['order']['total_weight']): ?><div align="right"><strong><?php echo $this->_var['lang']['label_total_weight']; ?>
    </strong></div><?php endif; ?></td>
    <td><?php if ($this->_var['order']['total_weight']): ?><div align="right"><?php echo $this->_var['order']['total_weight']; ?>
    </div><?php endif; ?></td>
    <td>&nbsp;</td>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_total']; ?></strong></div></td>
    <td><div align="right"><?php echo $this->_var['order']['formated_goods_amount']; ?></div></td>
  </tr>
</table>
</div>

<div class="list-div" style="margin-bottom: 5px">
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
    <th><?php echo $this->_var['lang']['fee_info']; ?><a href="order.php?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=money" class="special"><?php echo $this->_var['lang']['edit']; ?></a></th>
  </tr>
  <tr>
    <td><div align="right"><?php echo $this->_var['lang']['label_goods_amount']; ?><strong><?php echo $this->_var['order']['formated_goods_amount']; ?></strong>
- <?php echo $this->_var['lang']['label_discount']; ?><strong><?php echo $this->_var['order']['formated_discount']; ?></strong>     + <?php echo $this->_var['lang']['label_tax']; ?><strong><?php echo $this->_var['order']['formated_tax']; ?></strong>
      + <?php echo $this->_var['lang']['label_shipping_fee']; ?><strong><?php echo $this->_var['order']['formated_shipping_fee']; ?></strong>
      + <?php echo $this->_var['lang']['label_insure_fee']; ?><strong><?php echo $this->_var['order']['formated_insure_fee']; ?></strong>
      + <?php echo $this->_var['lang']['label_pay_fee']; ?><strong><?php echo $this->_var['order']['formated_pay_fee']; ?></strong>
      + <?php echo $this->_var['lang']['label_pack_fee']; ?><strong><?php echo $this->_var['order']['formated_pack_fee']; ?></strong>
      + <?php echo $this->_var['lang']['label_card_fee']; ?><strong><?php echo $this->_var['order']['formated_card_fee']; ?></strong></div></td>
  <tr>
    <td><div align="right"> = <?php echo $this->_var['lang']['label_order_amount']; ?><strong><?php echo $this->_var['order']['formated_total_fee']; ?></strong></div></td>
  </tr>
  <tr>
    <td><div align="right">
      - <?php echo $this->_var['lang']['label_money_paid']; ?><strong><?php echo $this->_var['order']['formated_money_paid']; ?></strong> - <?php echo $this->_var['lang']['label_surplus']; ?> <strong><?php echo $this->_var['order']['formated_surplus']; ?></strong>
      - <?php echo $this->_var['lang']['label_integral']; ?> <strong><?php echo $this->_var['order']['formated_integral_money']; ?></strong>
      - <?php echo $this->_var['lang']['label_bonus']; ?> <strong><?php echo $this->_var['order']['formated_bonus']; ?></strong>
    </div></td>
  <tr>
    <td><div align="right"> = <?php if ($this->_var['order']['order_amount'] >= 0): ?><?php echo $this->_var['lang']['label_money_dues']; ?><strong><?php echo $this->_var['order']['formated_order_amount']; ?></strong>
      <?php else: ?><?php echo $this->_var['lang']['label_money_refund']; ?><strong><?php echo $this->_var['order']['formated_money_refund']; ?></strong>
      <input name="refund" type="button" value="<?php echo $this->_var['lang']['refund']; ?>" onclick="location.href='order.php?act=process&func=load_refund&anonymous=<?php if ($this->_var['order']['user_id'] <= 0): ?>1<?php else: ?>0<?php endif; ?>&order_id=<?php echo $this->_var['order']['order_id']; ?>&refund_amount=<?php echo $this->_var['order']['money_refund']; ?>'" />
      <?php endif; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><br /><?php echo $this->_var['lang']['notice_gb_order_amount']; ?><?php endif; ?></div></td>
  </tr>
</table>
</div>

<div class="list-div" style="margin-bottom: 5px">
<table cellpadding="3" cellspacing="1">
  <tr>
    <th colspan="6"><?php echo $this->_var['lang']['action_info']; ?></th>
  </tr>
  <tr>
    <td><div align="right"><strong><?php echo $this->_var['lang']['label_action_note']; ?></strong></div></td>
  <td colspan="5"><textarea name="action_note" cols="80" rows="3"></textarea></td>
    </tr>
  <tr>
    <td><div align="right"></div>
      <div align="right"><strong><?php echo $this->_var['lang']['label_operable_act']; ?></strong> </div></td>
    <td colspan="5"><?php if ($this->_var['operable_list']['confirm']): ?>
      <input name="confirm" type="submit" value="<?php echo $this->_var['lang']['op_confirm']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['pay']): ?>
        <input name="pay" type="submit" value="<?php echo $this->_var['lang']['op_pay']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['unpay']): ?>
        <input name="unpay" type="submit" class="button" value="<?php echo $this->_var['lang']['op_unpay']; ?>" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['prepare']): ?>
        <input name="prepare" type="submit" value="<?php echo $this->_var['lang']['op_prepare']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['split']): ?>
        <input name="ship" type="submit" value="<?php echo $this->_var['lang']['op_split']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['unship']): ?>
        <input name="unship" type="submit" value="<?php echo $this->_var['lang']['op_unship']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['receive']): ?>
        <input name="receive" type="submit" value="<?php echo $this->_var['lang']['op_receive']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['cancel']): ?>
        <input name="cancel" type="submit" value="<?php echo $this->_var['lang']['op_cancel']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['invalid']): ?>
        <input name="invalid" type="submit" value="<?php echo $this->_var['lang']['op_invalid']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['return']): ?>
        <input name="return" type="submit" value="<?php echo $this->_var['lang']['op_return']; ?>" class="button" />
        <?php endif; ?> <?php if ($this->_var['operable_list']['to_delivery']): ?>
        <input name="to_delivery" type="submit" value="<?php echo $this->_var['lang']['op_to_delivery']; ?>" class="button"/>
        <input name="order_sn" type="hidden" value="<?php echo $this->_var['order']['order_sn']; ?>" />
        <?php endif; ?> <input name="after_service" type="submit" value="<?php echo $this->_var['lang']['op_after_service']; ?>" class="button" /><?php if ($this->_var['operable_list']['remove']): ?>
        <input name="remove" type="submit" value="<?php echo $this->_var['lang']['remove']; ?>" class="button" onClick="return window.confirm('<?php echo $this->_var['lang']['js_languages']['remove_confirm']; ?>');" />
        <?php endif; ?>
        <?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['notice_gb_ship']; ?><?php endif; ?>
        <?php if ($this->_var['agency_list']): ?>
        <input name="assign" type="submit" value="<?php echo $this->_var['lang']['op_assign']; ?>" class="button" onclick="return assignTo(document.forms['theForm'].elements['agency_id'].value)" />
        <select name="agency_id"><option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
        <?php $_from = $this->_var['agency_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'agency');if (count($_from)):
    foreach ($_from AS $this->_var['agency']):
?>
        <option value="<?php echo $this->_var['agency']['agency_id']; ?>" <?php if ($this->_var['agency']['agency_id'] == $this->_var['order']['agency_id']): ?>selected<?php endif; ?>><?php echo $this->_var['agency']['agency_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </select>
        <?php endif; ?>
        <input name="order_id" type="hidden" value="<?php echo $_REQUEST['order_id']; ?>"></td>
    </tr>
  <tr>
    <th><?php echo $this->_var['lang']['action_user']; ?></th>
    <th><?php echo $this->_var['lang']['action_time']; ?></th>
    <th><?php echo $this->_var['lang']['order_status']; ?></th>
    <th><?php echo $this->_var['lang']['pay_status']; ?></th>
    <th><?php echo $this->_var['lang']['shipping_status']; ?></th>
    <th><?php echo $this->_var['lang']['action_note']; ?></th>
  </tr>
  <?php $_from = $this->_var['action_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'action');if (count($_from)):
    foreach ($_from AS $this->_var['action']):
?>
  <tr>
    <td><div align="center"><?php echo $this->_var['action']['action_user']; ?></div></td>
    <td><div align="center"><?php echo $this->_var['action']['action_time']; ?></div></td>
    <td><div align="center"><?php echo $this->_var['action']['order_status']; ?></div></td>
    <td><div align="center"><?php echo $this->_var['action']['pay_status']; ?></div></td>
    <td><div align="center"><?php echo $this->_var['action']['shipping_status']; ?></div></td>
    <td><?php echo nl2br($this->_var['action']['action_note']); ?></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
</div>
</form>

<script language="JavaScript">

  var oldAgencyId = <?php echo empty($this->_var['order']['agency_id']) ? '0' : $this->_var['order']['agency_id']; ?>;

  onload = function()
  {
    // 开始检查订单
    startCheckOrder();
  }

  /**
   * 把订单指派给某办事处
   * @param int agencyId
   */
  function assignTo(agencyId)
  {
    if (agencyId == 0)
    {
      alert(pls_select_agency);
      return false;
    }
    if (oldAgencyId != 0 && agencyId == oldAgencyId)
    {
      alert(pls_select_other_agency);
      return false;
    }
    return true;
  }
</script>


<?php echo $this->fetch('pagefooter.htm'); ?>