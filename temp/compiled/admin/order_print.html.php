
<style type="text/css">
body,td {font-size:13px;}
</style>

<h1 align="center"><?php echo $this->_var['lang']['order_info']; ?></h1>
<table width="100%" cellpadding="1">
    <tr>
        <td width="8%"><?php echo $this->_var['lang']['print_buy_name']; ?></td>
        <td><?php if ($this->_var['order']['user_name']): ?><?php echo $this->_var['order']['user_name']; ?><?php else: ?><?php echo $this->_var['lang']['anonymous']; ?><?php endif; ?><!-- 购货人姓名 --></td>
        <td align="right"><?php echo $this->_var['lang']['label_order_time']; ?></td><td><?php echo $this->_var['order']['order_time']; ?><!-- 下订单时间 --></td>
        <td align="right"><?php echo $this->_var['lang']['label_payment']; ?></td><td><?php echo $this->_var['order']['pay_name']; ?><!-- 支付方式 --></td>
        <td align="right"><?php echo $this->_var['lang']['print_order_sn']; ?></td><td><?php echo $this->_var['order']['order_sn']; ?><!-- 订单号 --></td>
    </tr>
    <tr>
        <td><?php echo $this->_var['lang']['label_pay_time']; ?></td><td><?php echo $this->_var['order']['pay_time']; ?></td><!-- 付款时间 -->
        <td align="right"><?php echo $this->_var['lang']['label_shipping_time']; ?></td><td><?php echo $this->_var['order']['shipping_time']; ?><!-- 发货时间 --></td>
        <td align="right"><?php echo $this->_var['lang']['label_shipping']; ?></td><td><?php echo $this->_var['order']['shipping_name']; ?><!-- 配送方式 --></td>
        <td align="right"><?php echo $this->_var['lang']['label_invoice_no']; ?></td><td><?php echo $this->_var['order']['invoice_no']; ?> <!-- 发货单号 --></td>
    </tr>
    <tr>
        <td><?php echo $this->_var['lang']['label_consignee_address']; ?></td>
        <td colspan="7">
        [<?php echo $this->_var['order']['region']; ?>]&nbsp;<?php echo $this->_var['order']['address']; ?>&nbsp;<!-- 收货人地址 -->
        <?php echo $this->_var['lang']['label_consignee']; ?><?php echo $this->_var['order']['consignee']; ?>&nbsp;<!-- 收货人姓名 -->
        <?php if ($this->_var['order']['zipcode']): ?><?php echo $this->_var['lang']['label_zipcode']; ?><?php echo $this->_var['order']['zipcode']; ?>&nbsp;<?php endif; ?><!-- 邮政编码 -->
        <?php if ($this->_var['order']['tel']): ?><?php echo $this->_var['lang']['label_tel']; ?><?php echo $this->_var['order']['tel']; ?>&nbsp; <?php endif; ?><!-- 联系电话 -->
        <?php if ($this->_var['order']['mobile']): ?><?php echo $this->_var['lang']['label_mobile']; ?><?php echo $this->_var['order']['mobile']; ?><?php endif; ?><!-- 手机号码 -->
        </td>
    </tr>
</table>
<table width="100%" border="1" style="border-collapse:collapse;border-color:#000;">
    <tr align="center">
        <td bgcolor="#cccccc"><?php echo $this->_var['lang']['goods_name']; ?>  <!-- 商品名称 --></td>
        <td bgcolor="#cccccc"><?php echo $this->_var['lang']['goods_sn']; ?>    <!-- 商品货号 --></td>
        <td bgcolor="#cccccc"><?php echo $this->_var['lang']['goods_attr']; ?>  <!-- 商品属性 --></td>
        <td bgcolor="#cccccc"><?php echo $this->_var['lang']['goods_price']; ?> <!-- 商品单价 --></td>
        <td bgcolor="#cccccc"><?php echo $this->_var['lang']['goods_number']; ?><!-- 商品数量 --></td>
        <td bgcolor="#cccccc"><?php echo $this->_var['lang']['subtotal']; ?>    <!-- 价格小计 --></td>
    </tr>
    <!-- <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?> -->
    <tr>
        <td>&nbsp;<?php echo $this->_var['goods']['goods_name']; ?><!-- 商品名称 -->
        <?php if ($this->_var['goods']['is_gift']): ?><?php if ($this->_var['goods']['goods_price'] > 0): ?><?php echo $this->_var['lang']['remark_favourable']; ?><?php else: ?><?php echo $this->_var['lang']['remark_gift']; ?><?php endif; ?><?php endif; ?>
        <?php if ($this->_var['goods']['parent_id'] > 0): ?><?php echo $this->_var['lang']['remark_fittings']; ?><?php endif; ?>
        </td>
        <td>&nbsp;<?php echo $this->_var['goods']['goods_sn']; ?> <!-- 商品货号 --></td>
        <td><!-- 商品属性 -->
        <!-- <?php $_from = $this->_var['goods_attr'][$this->_var['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['attr']):
?> -->
        <!-- <?php if ($this->_var['attr']['name']): ?> --> <?php echo $this->_var['attr']['name']; ?>:<?php echo $this->_var['attr']['value']; ?> <!-- <?php endif; ?> -->
        <!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
        </td>
        <td align="right"><?php echo $this->_var['goods']['formated_goods_price']; ?>&nbsp;<!-- 商品单价 --></td>
        <td align="right"><?php echo $this->_var['goods']['goods_number']; ?>&nbsp;<!-- 商品数量 --></td>
        <td align="right"><?php echo $this->_var['goods']['formated_subtotal']; ?>&nbsp;<!-- 商品金额小计 --></td>
    </tr>
    <!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
    <tr>
        <!-- 发票抬头和发票内容 -->
        <td colspan="4">
        <?php if ($this->_var['order']['inv_payee']): ?>
        <?php echo $this->_var['lang']['label_inv_payee']; ?><?php echo $this->_var['order']['inv_payee']; ?>&nbsp;&nbsp;&nbsp;
        <?php echo $this->_var['lang']['label_inv_content']; ?><?php echo $this->_var['order']['inv_content']; ?>
        <?php endif; ?>
        </td>
        <!-- 商品总金额 -->
        <td colspan="2" align="right"><?php echo $this->_var['lang']['label_goods_amount']; ?><?php echo $this->_var['order']['formated_goods_amount']; ?></td>
    </tr>
</table>
<table width="100%" border="0">
    <tr align="right">
        <td><?php if ($this->_var['order']['discount'] > 0): ?>- <?php echo $this->_var['lang']['label_discount']; ?><?php echo $this->_var['order']['formated_discount']; ?><?php endif; ?><?php if ($this->_var['order']['pack_name'] && $this->_var['order']['pack_fee'] != '0.00'): ?>
         <!-- 包装名称包装费用 -->
        + <?php echo $this->_var['lang']['label_pack_fee']; ?><?php echo $this->_var['order']['formated_pack_fee']; ?>
        <?php endif; ?>
        <?php if ($this->_var['order']['card_name'] && $this->_var['order']['card_fee'] != '0.00'): ?><!-- 贺卡名称以及贺卡费用 -->
        + <?php echo $this->_var['lang']['label_card_fee']; ?><?php echo $this->_var['order']['formated_card_fee']; ?>
        <?php endif; ?>
        <?php if ($this->_var['order']['pay_fee'] != '0.00'): ?><!-- 支付手续费 -->
        + <?php echo $this->_var['lang']['label_pay_fee']; ?><?php echo $this->_var['order']['formated_pay_fee']; ?>
        <?php endif; ?>
        <?php if ($this->_var['order']['shipping_fee'] != '0.00'): ?><!-- 配送费用 -->
        + <?php echo $this->_var['lang']['label_shipping_fee']; ?><?php echo $this->_var['order']['formated_shipping_fee']; ?>
        <?php endif; ?>
        <?php if ($this->_var['order']['insure_fee'] != '0.00'): ?><!-- 保价费用 -->
        + <?php echo $this->_var['lang']['label_insure_fee']; ?><?php echo $this->_var['order']['formated_insure_fee']; ?>
        <?php endif; ?>
        <!-- 订单总金额 -->
        = <?php echo $this->_var['lang']['label_order_amount']; ?><?php echo $this->_var['order']['formated_total_fee']; ?>        </td>
    </tr>
    <tr align="right">
        <td>
        <!-- 如果已付了部分款项, 减去已付款金额 -->
        <?php if ($this->_var['order']['money_paid'] != '0.00'): ?>- <?php echo $this->_var['lang']['label_money_paid']; ?><?php echo $this->_var['order']['formated_money_paid']; ?><?php endif; ?>

        <!-- 如果使用了余额支付, 减去已使用的余额 -->
        <?php if ($this->_var['order']['surplus'] != '0.00'): ?>- <?php echo $this->_var['lang']['label_surplus']; ?><?php echo $this->_var['order']['formated_surplus']; ?><?php endif; ?>

        <!-- 如果使用了积分支付, 减去已使用的积分 -->
        <?php if ($this->_var['order']['integral_money'] != '0.00'): ?>- <?php echo $this->_var['lang']['label_integral']; ?><?php echo $this->_var['order']['formated_integral_money']; ?><?php endif; ?>

        <!-- 如果使用了红包支付, 减去已使用的红包 -->
        <?php if ($this->_var['order']['bonus'] != '0.00'): ?>- <?php echo $this->_var['lang']['label_bonus']; ?><?php echo $this->_var['order']['formated_bonus']; ?><?php endif; ?>

        <!-- 应付款金额 -->
        = <?php echo $this->_var['lang']['label_money_dues']; ?><?php echo $this->_var['order']['formated_order_amount']; ?>
        </td>
    </tr>
</table>
<table width="100%" border="0">
    <?php if ($this->_var['order']['to_buyer']): ?>
    <tr><!-- 给购货人看的备注信息 -->
        <td><?php echo $this->_var['lang']['label_to_buyer']; ?><?php echo $this->_var['order']['to_buyer']; ?></td>
    </tr>
    <?php endif; ?>
    <?php if ($this->_var['order']['invoice_note']): ?>
    <tr> <!-- 发货备注 -->
        <td><?php echo $this->_var['lang']['label_invoice_note']; ?> <?php echo $this->_var['order']['invoice_note']; ?></td>
    </tr>
    <?php endif; ?>
    <?php if ($this->_var['order']['pay_note']): ?>
    <tr> <!-- 支付备注 -->
        <td><?php echo $this->_var['lang']['pay_note']; ?> <?php echo $this->_var['order']['pay_note']; ?></td>
    </tr>
    <?php endif; ?>

    <tr><!-- 网店名称, 网店地址, 网店URL以及联系电话 -->
        <td>
        <?php echo $this->_var['shop_name']; ?>（<?php echo $this->_var['shop_url']; ?>）
        <?php echo $this->_var['lang']['label_shop_address']; ?><?php echo $this->_var['shop_address']; ?>&nbsp;&nbsp;<?php echo $this->_var['lang']['label_service_phone']; ?><?php echo $this->_var['service_phone']; ?>
        </td>
    </tr>
    <tr align="right"><!-- 订单操作员以及订单打印的日期 -->
        <td><?php echo $this->_var['lang']['label_print_time']; ?><?php echo $this->_var['print_time']; ?>&nbsp;&nbsp;&nbsp;<?php echo $this->_var['lang']['action_user']; ?><?php echo $this->_var['action_user']; ?></td>
    </tr>
</table>