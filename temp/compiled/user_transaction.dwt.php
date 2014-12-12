<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link href="themes/jd2013/base.css" rel="stylesheet" type="text/css">
<link href="themes/jd2013/home.css" rel="stylesheet" type="text/css">

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="clear"></div>
<div class="block clearfix">
  
  <div class="AreaLu">
  <?php echo $this->fetch('library/user_menu.lbi'); ?>
  </div>
  
  
  <div class="AreaRu">
    <div class="">
     <div class="uscenterbox">
      <div class="userCenterBox boxCenterList clearfix" style="_height:1%;">
         
         <?php if ($this->_var['action'] == 'profile'): ?>
         <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
        <script type="text/javascript">
          <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
            var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </script>
      <h5><span><?php echo $this->_var['lang']['profile']; ?></span></h5>
      <div class="blank"></div>
     <form name="formEdit" action="user.php" method="post" onSubmit="return userEdit()">
      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
                <tr>
                  <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['birthday']; ?>： </td>
                  <td width="72%" align="left" bgcolor="#FFFFFF"> <?php echo $this->html_select_date(array('field_order'=>'YMD','prefix'=>'birthday','start_year'=>'-60','end_year'=>'+1','display_days'=>'true','month_format'=>'%m','day_value_format'=>'%02d','time'=>$this->_var['profile']['birthday'])); ?> </td>
                </tr>
                <tr>
                  <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['sex']; ?>： </td>
                  <td width="72%" align="left" bgcolor="#FFFFFF"><input type="radio" name="sex" value="0" <?php if ($this->_var['profile']['sex'] == 0): ?>checked="checked"<?php endif; ?> />
                    <?php echo $this->_var['lang']['secrecy']; ?>&nbsp;&nbsp;
                    <input type="radio" name="sex" value="1" <?php if ($this->_var['profile']['sex'] == 1): ?>checked="checked"<?php endif; ?> />
                    <?php echo $this->_var['lang']['male']; ?>&nbsp;&nbsp;
                    <input type="radio" name="sex" value="2" <?php if ($this->_var['profile']['sex'] == 2): ?>checked="checked"<?php endif; ?> />
                  <?php echo $this->_var['lang']['female']; ?>&nbsp;&nbsp; </td>
                </tr>
                <tr>
                  <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['email']; ?>： </td>
                  <td width="72%" align="left" bgcolor="#FFFFFF"><input name="email" type="text" value="<?php echo $this->_var['profile']['email']; ?>" size="25" class="inputBg" /><span style="color:#FF0000"> *</span></td>
                </tr>
		<?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
		<?php if ($this->_var['field']['id'] == 6): ?>
		<tr>
		  <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['passwd_question']; ?>：</td>
		  <td width="72%" align="left" bgcolor="#FFFFFF">
		  <select name='sel_question'>
		  <option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
		  <?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'],'selected'=>$this->_var['profile']['passwd_question'])); ?>
		  </select>
		  </td>
		</tr>
		<tr>
		  <td width="28%" align="right" bgcolor="#FFFFFF" <?php if ($this->_var['field']['is_need']): ?>id="passwd_quesetion"<?php endif; ?>><?php echo $this->_var['lang']['passwd_answer']; ?>：</td>
		  <td width="72%" align="left" bgcolor="#FFFFFF">
		  <input name="passwd_answer" type="text" size="25" class="inputBg" maxlengt='20' value="<?php echo $this->_var['profile']['passwd_answer']; ?>"/><?php if ($this->_var['field']['is_need']): ?><span style="color:#FF0000"> *</span><?php endif; ?>
		  </td>
		</tr>
		<?php else: ?>
		<tr>
			<td width="28%" align="right" bgcolor="#FFFFFF" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['field']['reg_field_name']; ?>：</td>
			<td width="72%" align="left" bgcolor="#FFFFFF">
			<input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" class="inputBg" value="<?php echo $this->_var['field']['content']; ?>"/><?php if ($this->_var['field']['is_need']): ?><span style="color:#FF0000"> *</span><?php endif; ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <tr>
                  <td colspan="2" align="center" bgcolor="#FFFFFF"><input name="act" type="hidden" value="act_edit_profile" />
                    <input name="submit" type="submit" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" class="bnt_blue_1" style="border:none;" />
                  </td>
                </tr>
       </table>
    </form>
     <form name="formPassword" action="user.php" method="post" onSubmit="return editPassword()" >
     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
        <tr>
          <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['old_password']; ?>：</td>
          <td width="76%" align="left" bgcolor="#FFFFFF"><input name="old_password" type="password" size="25"  class="inputBg" /></td>
        </tr>
        <tr>
          <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['new_password']; ?>：</td>
          <td align="left" bgcolor="#FFFFFF"><input name="new_password" type="password" size="25"  class="inputBg" /></td>
        </tr>
        <tr>
          <td width="28%" align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['confirm_password']; ?>：</td>
          <td align="left" bgcolor="#FFFFFF"><input name="comfirm_password" type="password" size="25"  class="inputBg" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#FFFFFF"><input name="act" type="hidden" value="act_edit_password" />
            <input name="submit" type="submit" class="bnt_blue_1" style="border:none;" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" />
          </td>
        </tr>
      </table>
    </form>
     <?php endif; ?>
     
     <?php if ($this->_var['action'] == 'bonus'): ?>
      <script type="text/javascript">
        <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </script>
      <h5><span><?php echo $this->_var['lang']['label_bonus']; ?></span></h5>
      <div class="blank"></div>
       <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
        <tr>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_sn']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_name']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_amount']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['min_goods_amount']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_end_date']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_status']; ?></th>
        </tr>
        <?php if ($this->_var['bonus']): ?>
        <?php $_from = $this->_var['bonus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
        <tr>
          <td align="center" bgcolor="#FFFFFF"><?php echo empty($this->_var['item']['bonus_sn']) ? 'N/A' : $this->_var['item']['bonus_sn']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['type_name']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['type_money']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['min_goods_amount']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['use_enddate']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['status']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php else: ?>
        <tr>
          <td colspan="6" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['user_bonus_empty']; ?></td>
        </tr>
        <?php endif; ?>
      </table>
      <div class="blank5"></div>
      <?php echo $this->fetch('library/pages.lbi'); ?>
      <div class="blank5"></div>
      <h5><span><?php echo $this->_var['lang']['add_bonus']; ?></span></h5>
      <div class="blank"></div>
      <form name="addBouns" action="user.php" method="post" onSubmit="return addBonus()">
        <div style="padding: 15px;">
        <?php echo $this->_var['lang']['bonus_number']; ?>
          <input name="bonus_sn" type="text" size="30" class="inputBg" />
          <input type="hidden" name="act" value="act_add_bonus" class="inputBg" />
          <input type="submit" class="bnt_blue_1" style="border:none;" value="<?php echo $this->_var['lang']['add_bonus']; ?>" />
        </div>
      </form>
    <?php endif; ?>
   
      
       <?php if ($this->_var['action'] == 'order_list'): ?>
       <h5><span><?php echo $this->_var['lang']['label_order']; ?></span></h5>
       <div class="blank"></div>
       <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr align="center">
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_number']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_addtime']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_money']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_status']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
          </tr>
          <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <tr>
            <td align="center" bgcolor="#ffffff"><a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>" class="f6"><?php echo $this->_var['item']['order_sn']; ?></a></td>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['order_time']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['total_fee']; ?></td>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['order_status']; ?></td>
            <td align="center" bgcolor="#ffffff"><font class="f6"><?php echo $this->_var['item']['handler']; ?></font></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </table>
        <div class="blank5"></div>
       <?php echo $this->fetch('library/pages.lbi'); ?>
       <div class="blank5"></div>
       <h5><span><?php echo $this->_var['lang']['merge_order']; ?></span></h5>
       <div class="blank"></div>
        <script type="text/javascript">
        <?php $_from = $this->_var['lang']['merge_order_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </script>
        <form action="user.php" method="post" name="formOrder" onsubmit="return mergeOrder()">
          <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
            <tr>
              <td width="22%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['first_order']; ?>:</td>
              <td width="12%" align="left" bgcolor="#ffffff"><select name="to_order">
              <option value="0"><?php echo $this->_var['lang']['select']; ?></option>

                  <?php echo $this->html_options(array('options'=>$this->_var['merge'])); ?>

                </select></td>
              <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['second_order']; ?>:</td>
              <td width="11%" align="left" bgcolor="#ffffff"><select name="from_order">
              <option value="0"><?php echo $this->_var['lang']['select']; ?></option>

                  <?php echo $this->html_options(array('options'=>$this->_var['merge'])); ?>

                </select></td>
              <td width="36%" bgcolor="#ffffff">&nbsp;<input name="act" value="merge_order" type="hidden" />
              <input type="submit" name="Submit"  class="bnt_blue_1" style="border:none;"  value="<?php echo $this->_var['lang']['merge_order']; ?>" /></td>
            </tr>
            <tr>
              <td bgcolor="#ffffff">&nbsp;</td>
              <td colspan="4" align="left" bgcolor="#ffffff"><?php echo $this->_var['lang']['merge_order_notice']; ?></td>
            </tr>
          </table>
        </form>
       <?php endif; ?>
      
       
      <?php if ($this->_var['action'] == 'track_packages'): ?>
        <h5><span><?php echo $this->_var['lang']['label_track_packages']; ?></span></h5>
        <div class="blank"></div>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" id="order_table">
        <tr align="center">
          <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_number']; ?></td>
          <td bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
        </tr>
        <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
        <tr>
          <td align="center" bgcolor="#ffffff"><a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>"><?php echo $this->_var['item']['order_sn']; ?></a></td>
          <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['query_link']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </table>
      <script>
      var query_status = '<?php echo $this->_var['lang']['query_status']; ?>';
      var ot = document.getElementById('order_table');
      for (var i = 1; i < ot.rows.length; i++)
      {
        var row = ot.rows[i];
        var cel = row.cells[1];
        cel.getElementsByTagName('a').item(0).innerHTML = query_status;
      }
      </script>
      <div class="blank5"></div>
      <?php echo $this->fetch('library/pages.lbi'); ?>
      <?php endif; ?>
    
     
      <?php if ($this->_var['action'] == order_detail): ?>
        <h5><span><?php echo $this->_var['lang']['order_status']; ?></span></h5>
        <div class="blank"></div>
         <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
        <tr>
          <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_order_sn']; ?>：</td>
          <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['order_sn']; ?>
          <?php if ($this->_var['order']['extension_code'] == "group_buy"): ?>
					<a href="./group_buy.php?act=view&id=<?php echo $this->_var['order']['extension_id']; ?>" class="f6"><strong><?php echo $this->_var['lang']['order_is_group_buy']; ?></strong></a>
					<?php elseif ($this->_var['order']['extension_code'] == "exchange_goods"): ?>
					<a href="./exchange.php?act=view&id=<?php echo $this->_var['order']['extension_id']; ?>" class="f6"><strong><?php echo $this->_var['lang']['order_is_exchange']; ?></strong></a>
					<?php endif; ?>  
					<a href="user.php?act=message_list&order_id=<?php echo $this->_var['order']['order_id']; ?>" class="f6">[<?php echo $this->_var['lang']['business_message']; ?>]</a>
					</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_order_status']; ?>：</td>
          <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['order_status']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_var['order']['confirm_time']; ?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_pay_status']; ?>：</td>
          <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['pay_status']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($this->_var['order']['order_amount'] > 0): ?><?php echo $this->_var['order']['pay_online']; ?><?php endif; ?><?php echo $this->_var['order']['pay_time']; ?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_shipping_status']; ?>：</td>
          <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['shipping_status']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_var['order']['shipping_time']; ?></td>
        </tr>
        <?php if ($this->_var['order']['invoice_no']): ?>
        <tr>
          <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['consignment']; ?>：</td>
          <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['invoice_no']; ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($this->_var['order']['to_buyer']): ?>
        <tr>
          <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detail_to_buyer']; ?>：</td>
          <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['to_buyer']; ?></td>
        </tr>
        <?php endif; ?>

        <?php if ($this->_var['virtual_card']): ?>
        <tr>
          <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['virtual_card_info']; ?>：</td>
          <td colspan="3" align="left" bgcolor="#ffffff">
          <?php $_from = $this->_var['virtual_card']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vgoods');if (count($_from)):
    foreach ($_from AS $this->_var['vgoods']):
?>
            <?php $_from = $this->_var['vgoods']['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'card');if (count($_from)):
    foreach ($_from AS $this->_var['card']):
?>
              <?php if ($this->_var['card']['card_sn']): ?><?php echo $this->_var['lang']['card_sn']; ?>:<span style="color:red;"><?php echo $this->_var['card']['card_sn']; ?></span><?php endif; ?>
              <?php if ($this->_var['card']['card_password']): ?><?php echo $this->_var['lang']['card_password']; ?>:<span style="color:red;"><?php echo $this->_var['card']['card_password']; ?></span><?php endif; ?>
              <?php if ($this->_var['card']['end_date']): ?><?php echo $this->_var['lang']['end_date']; ?>:<?php echo $this->_var['card']['end_date']; ?><?php endif; ?><br />
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </td>
        </tr>
        <?php endif; ?>
      </table>
        <div class="blank"></div>
        <h5><span><?php echo $this->_var['lang']['goods_list']; ?></span>
        <?php if ($this->_var['allow_to_cart']): ?>
        <a href="javascript:;" onclick="returnToCart(<?php echo $this->_var['order']['order_id']; ?>)" class="f6"><?php echo $this->_var['lang']['return_to_cart']; ?></a>
        <?php endif; ?>
        </h5>
        <div class="blank"></div>
         <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <th width="23%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['goods_name']; ?></th>
            <th width="29%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['goods_attr']; ?></th>
            <!--<th><?php echo $this->_var['lang']['market_price']; ?></th>-->
            <th width="26%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['goods_price']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?></th>
            <th width="9%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['number']; ?></th>
            <th width="20%" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['subtotal']; ?></th>
          </tr>
          <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
          <tr>
            <td bgcolor="#ffffff">
              <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
                <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" class="f6"><?php echo $this->_var['goods']['goods_name']; ?></a>
                <?php if ($this->_var['goods']['parent_id'] > 0): ?>
                <span style="color:#FF0000">（<?php echo $this->_var['lang']['accessories']; ?>）</span>
                <?php elseif ($this->_var['goods']['is_gift']): ?>
                <span style="color:#FF0000">（<?php echo $this->_var['lang']['largess']; ?>）</span>
                <?php endif; ?>
              <?php elseif ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
                <a href="javascript:void(0)" onclick="setSuitShow(<?php echo $this->_var['goods']['goods_id']; ?>)" class="f6"><?php echo $this->_var['goods']['goods_name']; ?><span style="color:#FF0000;">（礼包）</span></a>
                <div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" style="display:none">
                    <?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');if (count($_from)):
    foreach ($_from AS $this->_var['package_goods_list']):
?>
                      <a href="goods.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>" target="_blank" class="f6"><?php echo $this->_var['package_goods_list']['goods_name']; ?></a><br />
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
              <?php endif; ?>
              </td>
            <td align="left" bgcolor="#ffffff"><?php echo nl2br($this->_var['goods']['goods_attr']); ?></td>
            <!--<td align="right"><?php echo $this->_var['goods']['market_price']; ?></td>-->
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['goods']['goods_price']; ?></td>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['goods']['goods_number']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['goods']['subtotal']; ?></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <tr>
            <td colspan="8" bgcolor="#ffffff" align="right">
            <?php echo $this->_var['lang']['shopping_money']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?>: <?php echo $this->_var['order']['formated_goods_amount']; ?>
            </td>
          </tr>
        </table>
         <div class="blank"></div>
        <h5><span><?php echo $this->_var['lang']['fee_total']; ?></span></h5>
        <div class="blank"></div>
         <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td align="right" bgcolor="#ffffff">
                <?php echo $this->_var['lang']['goods_all_price']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?>: <?php echo $this->_var['order']['formated_goods_amount']; ?>
              <?php if ($this->_var['order']['discount'] > 0): ?>
              - <?php echo $this->_var['lang']['discount']; ?>: <?php echo $this->_var['order']['formated_discount']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['tax'] > 0): ?>
              + <?php echo $this->_var['lang']['tax']; ?>: <?php echo $this->_var['order']['formated_tax']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['shipping_fee'] > 0): ?>
              + <?php echo $this->_var['lang']['shipping_fee']; ?>: <?php echo $this->_var['order']['formated_shipping_fee']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['insure_fee'] > 0): ?>
              + <?php echo $this->_var['lang']['insure_fee']; ?>: <?php echo $this->_var['order']['formated_insure_fee']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['pay_fee'] > 0): ?>
              + <?php echo $this->_var['lang']['pay_fee']; ?>: <?php echo $this->_var['order']['formated_pay_fee']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['pack_fee'] > 0): ?>
              + <?php echo $this->_var['lang']['pack_fee']; ?>: <?php echo $this->_var['order']['formated_pack_fee']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['card_fee'] > 0): ?>
              + <?php echo $this->_var['lang']['card_fee']; ?>: <?php echo $this->_var['order']['formated_card_fee']; ?>
              <?php endif; ?>        </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#ffffff">
              <?php if ($this->_var['order']['money_paid'] > 0): ?>
              - <?php echo $this->_var['lang']['order_money_paid']; ?>: <?php echo $this->_var['order']['formated_money_paid']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['surplus'] > 0): ?>
              - <?php echo $this->_var['lang']['use_surplus']; ?>: <?php echo $this->_var['order']['formated_surplus']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['integral_money'] > 0): ?>
              - <?php echo $this->_var['lang']['use_integral']; ?>: <?php echo $this->_var['order']['formated_integral_money']; ?>
              <?php endif; ?>
              <?php if ($this->_var['order']['bonus'] > 0): ?>
              - <?php echo $this->_var['lang']['use_bonus']; ?>: <?php echo $this->_var['order']['formated_bonus']; ?>
              <?php endif; ?>        </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['order_amount']; ?>: <?php echo $this->_var['order']['formated_order_amount']; ?>
            <?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><br />
            <?php echo $this->_var['lang']['notice_gb_order_amount']; ?><?php endif; ?></td>
          </tr>
            <?php if ($this->_var['allow_edit_surplus']): ?>
          <tr>
            <td align="right" bgcolor="#ffffff">
      <form action="user.php" method="post" name="formFee" id="formFee"><?php echo $this->_var['lang']['use_more_surplus']; ?>:
            <input name="surplus" type="text" size="8" value="0" style="border:1px solid #ccc;"/><?php echo $this->_var['max_surplus']; ?>
            <input type="submit" name="Submit" class="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" />
      <input type="hidden" name="act" value="act_edit_surplus" />
      <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>" />
      </form></td>
          </tr>
    <?php endif; ?>
        </table>
         <div class="blank"></div>
        <h5><span><?php echo $this->_var['lang']['consignee_info']; ?></span></h5>
        <div class="blank"></div>
         <?php if ($this->_var['order']['allow_update_address'] > 0): ?>
          <form action="user.php" method="post" name="formAddress" id="formAddress">
           <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
              <tr>
                <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['consignee_name']; ?>： </td>
                <td width="35%" align="left" bgcolor="#ffffff"><input name="consignee" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['consignee']); ?>" size="25">
                </td>
                <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['email_address']; ?>： </td>
                <td width="35%" align="left" bgcolor="#ffffff"><input name="email" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['email']); ?>" size="25" />
                </td>
              </tr>
              <?php if ($this->_var['order']['exist_real_goods']): ?>
              
              <tr>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detailed_address']; ?>： </td>
                <td align="left" bgcolor="#ffffff"><input name="address" type="text" class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['address']); ?> " size="25" /></td>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['postalcode']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="zipcode" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['zipcode']); ?>" size="25" /></td>
              </tr>
              <?php endif; ?>
              <tr>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['phone']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="tel" type="text" class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['tel']); ?>" size="25" /></td>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['backup_phone']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="mobile" type="text"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['mobile']); ?>" size="25" /></td>
              </tr>
              <?php if ($this->_var['order']['exist_real_goods']): ?>
              
              <tr>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['sign_building']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="sign_building" class="inputBg" type="text" value="<?php echo htmlspecialchars($this->_var['order']['sign_building']); ?>" size="25" />
                </td>
                <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['deliver_goods_time']; ?>：</td>
                <td align="left" bgcolor="#ffffff"><input name="best_time" type="text" class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['best_time']); ?>" size="25" />
                </td>
              </tr>
              <?php endif; ?>
              <tr>
                <td colspan="4" align="center" bgcolor="#ffffff"><input type="hidden" name="act" value="save_order_address" />
                  <input type="hidden" name="order_id" value="<?php echo $this->_var['order']['order_id']; ?>" />
                  <input type="submit" class="bnt_blue_2" value="<?php echo $this->_var['lang']['update_address']; ?>"  />
                </td>
              </tr>
            </table>
          </form>
          <?php else: ?>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
            <tr>
              <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['consignee_name']; ?>：</td>
              <td width="35%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['consignee']; ?></td>
              <td width="15%" align="right" bgcolor="#ffffff" ><?php echo $this->_var['lang']['email_address']; ?>：</td>
              <td width="35%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['email']; ?></td>
            </tr>
            <?php if ($this->_var['order']['exist_real_goods']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detailed_address']; ?>：</td>
              <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['address']; ?>
                <?php if ($this->_var['order']['zipcode']): ?>
                [<?php echo $this->_var['lang']['postalcode']; ?>: <?php echo $this->_var['order']['zipcode']; ?>]
                <?php endif; ?></td>
            </tr>
            <?php endif; ?>
            <tr>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['phone']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['tel']; ?> </td>
              <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['backup_phone']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['mobile']; ?></td>
            </tr>
            <?php if ($this->_var['order']['exist_real_goods']): ?>
            <tr>
              <td align="right" bgcolor="#ffffff" ><?php echo $this->_var['lang']['sign_building']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['sign_building']; ?> </td>
              <td align="right" bgcolor="#ffffff" ><?php echo $this->_var['lang']['deliver_goods_time']; ?>：</td>
              <td align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['best_time']; ?></td>
            </tr>
            <?php endif; ?>
          </table>
          <?php endif; ?>
          <div class="blank"></div>
        <h5><span><?php echo $this->_var['lang']['payment']; ?></span></h5>
        <div class="blank"></div>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
                <tr>
                  <td bgcolor="#ffffff">
                  <?php echo $this->_var['lang']['select_payment']; ?>: <?php echo $this->_var['order']['pay_name']; ?>。<?php echo $this->_var['lang']['order_amount']; ?>: <strong><?php echo $this->_var['order']['formated_order_amount']; ?></strong><br />
                  <?php echo $this->_var['order']['pay_desc']; ?>
                  </td>
                </tr>
                  <tr>
                  <td bgcolor="#ffffff" align="right">
                  <?php if ($this->_var['payment_list']): ?>
              <form name="payment" method="post" action="user.php">
              <?php echo $this->_var['lang']['change_payment']; ?>:
              <select name="pay_id">
                <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
                <option value="<?php echo $this->_var['payment']['pay_id']; ?>">
                <?php echo $this->_var['payment']['pay_name']; ?>(<?php echo $this->_var['lang']['pay_fee']; ?>:<?php echo $this->_var['payment']['format_pay_fee']; ?>)
                </option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
              <input type="hidden" name="act" value="act_edit_payment" />
              <input type="hidden" name="order_id" value="<?php echo $this->_var['order']['order_id']; ?>" />
              <input type="submit" name="Submit" class="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" />
              </form>
              <?php endif; ?>
                  </td>
                </tr>
              </table>
        <div class="blank"></div>
        <h5><span><?php echo $this->_var['lang']['other_info']; ?></span></h5>
        <div class="blank"></div>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <?php if ($this->_var['order']['shipping_id'] > 0): ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['shipping']; ?>：</td>
            <td colspan="3" width="85%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['shipping_name']; ?></td>
          </tr>
          <?php endif; ?>

          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment']; ?>：</td>
            <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['pay_name']; ?></td>
          </tr>
          <?php if ($this->_var['order']['insure_fee'] > 0): ?>
          <?php endif; ?>
          <?php if ($this->_var['order']['pack_name']): ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['use_pack']; ?>：</td>
            <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['pack_name']; ?></td>
          </tr>
          <?php endif; ?>
          <?php if ($this->_var['order']['card_name']): ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['use_card']; ?>：</td>
            <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['card_name']; ?></td>
          </tr>
          <?php endif; ?>
          <?php if ($this->_var['order']['card_message']): ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['bless_note']; ?>：</td>
            <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['card_message']; ?></td>
          </tr>
          <?php endif; ?>
          <?php if ($this->_var['order']['surplus'] > 0): ?>
          <?php endif; ?>
          <?php if ($this->_var['order']['integral'] > 0): ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['use_integral']; ?>：</td>
            <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['integral']; ?></td>
          </tr>
          <?php endif; ?>
          <?php if ($this->_var['order']['bonus'] > 0): ?>
          <?php endif; ?>
          <?php if ($this->_var['order']['inv_payee'] && $this->_var['order']['inv_content']): ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['invoice_title']; ?>：</td>
            <td width="36%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_payee']; ?></td>
            <td width="19%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['invoice_content']; ?>：</td>
            <td width="25%" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['inv_content']; ?></td>
          </tr>
          <?php endif; ?>
          <?php if ($this->_var['order']['postscript']): ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['order_postscript']; ?>：</td>
            <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['postscript']; ?></td>
          </tr>
          <?php endif; ?>
          <tr>
            <td width="15%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_process']; ?>：</td>
            <td colspan="3" align="left" bgcolor="#ffffff"><?php echo $this->_var['order']['how_oos_name']; ?></td>
          </tr>
        </table>
      <?php endif; ?>
    
    
      <?php if ($this->_var['action'] == "account_raply" || $this->_var['action'] == "account_log" || $this->_var['action'] == "account_deposit" || $this->_var['action'] == "account_detail"): ?>
        <script type="text/javascript">
          <?php $_from = $this->_var['lang']['account_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
            var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </script>
        <h5><span><?php echo $this->_var['lang']['user_balance']; ?></span></h5>
        <div class="blank"></div>
         <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td align="right" bgcolor="#ffffff"><a href="user.php?act=account_deposit" class="f6"><?php echo $this->_var['lang']['surplus_type_0']; ?></a> | <a href="user.php?act=account_raply" class="f6"><?php echo $this->_var['lang']['surplus_type_1']; ?></a> | <a href="user.php?act=account_detail" class="f6"><?php echo $this->_var['lang']['add_surplus_log']; ?></a> | <a href="user.php?act=account_log" class="f6"><?php echo $this->_var['lang']['view_application']; ?></a> </td>
          </tr>
        </table>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "account_raply"): ?>
        <form name="formSurplus" method="post" action="user.php" onSubmit="return submitSurplus()">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td width="15%" bgcolor="#ffffff"><?php echo $this->_var['lang']['repay_money']; ?>:</td>
            <td bgcolor="#ffffff" align="left"><input type="text" name="amount" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" class="inputBg" size="30" />
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_notic']; ?>:</td>
            <td bgcolor="#ffffff" align="left"><textarea name="user_note" cols="55" rows="6" style="border:1px solid #ccc;"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea></td>
          </tr>
          <tr>
            <td bgcolor="#ffffff" colspan="2" align="center">
            <input type="hidden" name="surplus_type" value="1" />
              <input type="hidden" name="act" value="act_account" />
              <input type="submit" name="submit"  class="bnt_blue_1" value="<?php echo $this->_var['lang']['submit_request']; ?>" />
              <input type="reset" name="reset" class="bnt_blue_1" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
            </td>
          </tr>
        </table>
        </form>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "account_deposit"): ?>
        <form name="formSurplus" method="post" action="user.php" onSubmit="return submitSurplus()">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
            <tr>
              <td width="15%" bgcolor="#ffffff"><?php echo $this->_var['lang']['deposit_money']; ?>:</td>
              <td align="left" bgcolor="#ffffff"><input type="text" name="amount"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" size="30" /></td>
            </tr>
            <tr>
              <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_notic']; ?>:</td>
              <td align="left" bgcolor="#ffffff"><textarea name="user_note" cols="55" rows="6" style="border:1px solid #ccc;"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea></td>
            </tr>
          </table>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
            <tr align="center">
              <td bgcolor="#ffffff"  colspan="3" align="left"><?php echo $this->_var['lang']['payment']; ?>:</td>
            </tr>
            <tr align="center">
              <td bgcolor="#ffffff"><?php echo $this->_var['lang']['pay_name']; ?></td>
              <td bgcolor="#ffffff" width="60%"><?php echo $this->_var['lang']['pay_desc']; ?></td>
              <td bgcolor="#ffffff" width="17%"><?php echo $this->_var['lang']['pay_fee']; ?></td>
            </tr>
            <?php $_from = $this->_var['payment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <tr>
              <td bgcolor="#ffffff" align="left">
              <input type="radio" name="payment_id" value="<?php echo $this->_var['list']['pay_id']; ?>" /><?php echo $this->_var['list']['pay_name']; ?></td>
              <td bgcolor="#ffffff" align="left"><?php echo $this->_var['list']['pay_desc']; ?></td>
              <td bgcolor="#ffffff" align="center"><?php echo $this->_var['list']['pay_fee']; ?></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
        <td bgcolor="#ffffff" colspan="3"  align="center">
        <input type="hidden" name="surplus_type" value="0" />
          <input type="hidden" name="rec_id" value="<?php echo $this->_var['order']['id']; ?>" />
          <input type="hidden" name="act" value="act_account" />
          <input type="submit" class="bnt_blue_1" name="submit" value="<?php echo $this->_var['lang']['submit_request']; ?>" />
          <input type="reset" class="bnt_blue_1" name="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
        </td>
      </tr>
          </table>
        </form>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "act_account"): ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td width="25%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['surplus_amount']; ?></td>
            <td width="80%" bgcolor="#ffffff"><?php echo $this->_var['amount']; ?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment_name']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['payment']['pay_name']; ?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment_fee']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['pay_fee']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="middle" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment_desc']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['payment']['pay_desc']; ?></td>
          </tr>
          <tr>
            <td colspan="2" bgcolor="#ffffff"><?php echo $this->_var['payment']['pay_button']; ?></td>
          </tr>
        </table>
        <?php endif; ?>
       <?php if ($this->_var['action'] == "account_detail"): ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr align="center">
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_time']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['surplus_pro_type']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['money']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['change_desc']; ?></td>
          </tr>
          <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <tr>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['change_time']; ?></td>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['type']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['amount']; ?></td>
            <td bgcolor="#ffffff" title="<?php echo $this->_var['item']['change_desc']; ?>">&nbsp;&nbsp;<?php echo $this->_var['item']['short_change_desc']; ?></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <tr>
            <td colspan="4" align="center" bgcolor="#ffffff"><div align="right"><?php echo $this->_var['lang']['current_surplus']; ?><?php echo $this->_var['surplus_amount']; ?></div></td>
          </tr>
        </table>
        <?php echo $this->fetch('library/pages.lbi'); ?>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "account_log"): ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr align="center">
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_time']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['surplus_pro_type']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['money']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_notic']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['admin_notic']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['is_paid']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
          </tr>
          <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <tr>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['add_time']; ?></td>
            <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['type']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['amount']; ?></td>
            <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['short_user_note']; ?></td>
            <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['short_admin_note']; ?></td>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['pay_status']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['handle']; ?>
              <?php if (( $this->_var['item']['is_paid'] == 0 && $this->_var['item']['process_type'] == 1 ) || $this->_var['item']['handle']): ?>
              <a href="user.php?act=cancel&id=<?php echo $this->_var['item']['id']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_account']; ?>')) return false;"><?php echo $this->_var['lang']['is_cancel']; ?></a>
              <?php endif; ?>
                            </td>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <tr>
            <td colspan="7" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['current_surplus']; ?><?php echo $this->_var['surplus_amount']; ?></td>
          </tr>
        </table>
        <?php echo $this->fetch('library/pages.lbi'); ?>
      <?php endif; ?>
      
      
      <?php if ($this->_var['action'] == 'address_list'): ?>
        <h5><span><?php echo $this->_var['lang']['consignee_info']; ?></span></h5>
        <div class="blank"></div>
         
            <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,transport.js,region.js,shopping_flow.js')); ?>
            <script type="text/javascript">
              region.isAdmin = false;
              <?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
              var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
              onload = function() {
                if (!document.all)
                {
                  document.forms['theForm'].reset();
                }
              }
              
            </script>
            <?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
?>
            <form action="user.php" method="post" name="theForm" onsubmit="return checkConsignee(this)">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
                <tr>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['country_province']; ?>：</td>
                  <td colspan="3" align="left" bgcolor="#ffffff"><select name="country" id="selCountries_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 1, 'selProvinces_<?php echo $this->_var['sn']; ?>')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['0']; ?></option>
                      <?php $_from = $this->_var['country_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
                      <option value="<?php echo $this->_var['country']['region_id']; ?>" <?php if ($this->_var['consignee']['country'] == $this->_var['country']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['country']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="province" id="selProvinces_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 2, 'selCities_<?php echo $this->_var['sn']; ?>')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
                      <?php $_from = $this->_var['province_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                      <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['consignee']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="city" id="selCities_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 3, 'selDistricts_<?php echo $this->_var['sn']; ?>')">
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
                      <?php $_from = $this->_var['city_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
                      <option value="<?php echo $this->_var['city']['region_id']; ?>" <?php if ($this->_var['consignee']['city'] == $this->_var['city']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                    <select name="district" id="selDistricts_<?php echo $this->_var['sn']; ?>" <?php if (! $this->_var['district_list'][$this->_var['sn']]): ?>style="display:none"<?php endif; ?>>
                      <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
                      <?php $_from = $this->_var['district_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
                      <option value="<?php echo $this->_var['district']['region_id']; ?>" <?php if ($this->_var['consignee']['district'] == $this->_var['district']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                  <?php echo $this->_var['lang']['require_field']; ?> </td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['consignee_name']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="consignee" type="text" class="inputBg" id="consignee_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['consignee']); ?>" />
                  <?php echo $this->_var['lang']['require_field']; ?> </td>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['email_address']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="email" type="text" class="inputBg" id="email_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['email']); ?>" />
                  <?php echo $this->_var['lang']['require_field']; ?></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['detailed_address']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="address" type="text" class="inputBg" id="address_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['address']); ?>" />
                  <?php echo $this->_var['lang']['require_field']; ?></td>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['postalcode']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="zipcode" type="text" class="inputBg" id="zipcode_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['zipcode']); ?>" /></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['phone']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="tel" type="text" class="inputBg" id="tel_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['tel']); ?>" />
                  <?php echo $this->_var['lang']['require_field']; ?></td>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['backup_phone']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="mobile" type="text" class="inputBg" id="mobile_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['mobile']); ?>" /></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['sign_building']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="sign_building" type="text" class="inputBg" id="sign_building_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['sign_building']); ?>" /></td>
                  <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['deliver_goods_time']; ?>：</td>
                  <td align="left" bgcolor="#ffffff"><input name="best_time" type="text"  class="inputBg" id="best_time_<?php echo $this->_var['sn']; ?>" value="<?php echo htmlspecialchars($this->_var['consignee']['best_time']); ?>" /></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#ffffff">&nbsp;</td>
                  <td colspan="3" align="center" bgcolor="#ffffff"><?php if ($this->_var['consignee']['consignee'] && $this->_var['consignee']['email']): ?>
                    <input type="submit" name="submit" class="bnt_blue_1" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" />
                    <input name="button" type="button" class="bnt_blue"  onclick="if (confirm('<?php echo $this->_var['lang']['confirm_drop_address']; ?>'))location.href='user.php?act=drop_consignee&id=<?php echo $this->_var['consignee']['address_id']; ?>'" value="<?php echo $this->_var['lang']['drop']; ?>" />
                    <?php else: ?>
                    <input type="submit" name="submit" class="bnt_blue_2"  value="<?php echo $this->_var['lang']['add_address']; ?>"/>
                    <?php endif; ?>
                    <input type="hidden" name="act" value="act_edit_address" />
                    <input name="address_id" type="hidden" value="<?php echo $this->_var['consignee']['address_id']; ?>" />
                  </td>
                </tr>
              </table>
            </form>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php endif; ?>
    
      
       <?php if ($this->_var['action'] == 'transform_points'): ?>
       <h5><span><?php echo $this->_var['lang']['transform_points']; ?></span></h5>
             <div class="blank"></div>
       <?php if ($this->_var['exchange_type'] == 'ucenter'): ?>
        <form action="user.php" method="post" name="transForm" onsubmit="return calcredit();">
       <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
                <tr>
                    <th width="120" bgcolor="#FFFFFF" align="right" valign="top"><?php echo $this->_var['lang']['cur_points']; ?>:</th>
                    <td bgcolor="#FFFFFF">
                    <label for="pay_points"><?php echo $this->_var['lang']['exchange_points']['1']; ?>:</label><input type="text" size="15" id="pay_points" name="pay_points" value="<?php echo $this->_var['shop_points']['pay_points']; ?>" style="border:0;border-bottom:1px solid #DADADA;" readonly="readonly" /><br />
                    <div class="blank"></div>
                    <label for="rank_points"><?php echo $this->_var['lang']['exchange_points']['0']; ?>:</label><input type="text" size="15" id="rank_points" name="rank_points" value="<?php echo $this->_var['shop_points']['rank_points']; ?>" style="border:0;border-bottom:1px solid #DADADA;" readonly="readonly" />
                    </td>
                    </tr>
          <tr><td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <th align="right" bgcolor="#FFFFFF"><label for="amount"><?php echo $this->_var['lang']['exchange_amount']; ?>:</label></th>
            <td bgcolor="#FFFFFF"><input size="15" name="amount" id="amount" value="0" onkeyup="calcredit();" type="text" />
                <select name="fromcredits" id="fromcredits" onchange="calcredit();">
                  <?php echo $this->html_options(array('options'=>$this->_var['lang']['exchange_points'],'selected'=>$this->_var['selected_org'])); ?>
                </select>
            </td>
          </tr>
          <tr>
            <th align="right" bgcolor="#FFFFFF"><label for="desamount"><?php echo $this->_var['lang']['exchange_desamount']; ?>:</label></th>
            <td bgcolor="#FFFFFF"><input type="text" name="desamount" id="desamount" disabled="disabled" value="0" size="15" />
              <select name="tocredits" id="tocredits" onchange="calcredit();">
                <?php echo $this->html_options(array('options'=>$this->_var['to_credits_options'],'selected'=>$this->_var['selected_dst'])); ?>
              </select>
            </td>
          </tr>
          <tr>
            <th align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['exchange_ratio']; ?>:</th>
            <td bgcolor="#FFFFFF">1 <span id="orgcreditunit"><?php echo $this->_var['orgcreditunit']; ?></span> <span id="orgcredittitle"><?php echo $this->_var['orgcredittitle']; ?></span> <?php echo $this->_var['lang']['exchange_action']; ?> <span id="descreditamount"><?php echo $this->_var['descreditamount']; ?></span> <span id="descreditunit"><?php echo $this->_var['descreditunit']; ?></span> <span id="descredittitle"><?php echo $this->_var['descredittitle']; ?></span></td>
          </tr>
          <tr><td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF"><input type="hidden" name="act" value="act_transform_ucenter_points" /><input type="submit" name="transfrom" value="<?php echo $this->_var['lang']['transform']; ?>" /></td></tr>
  </table>
        </form>
       <script type="text/javascript">
        <?php $_from = $this->_var['lang']['exchange_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'lang_js');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['lang_js']):
?>
        var <?php echo $this->_var['key']; ?> = '<?php echo $this->_var['lang_js']; ?>';
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        var out_exchange_allow = new Array();
        <?php $_from = $this->_var['out_exchange_allow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ratio');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['ratio']):
?>
        out_exchange_allow['<?php echo $this->_var['key']; ?>'] = '<?php echo $this->_var['ratio']; ?>';
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        function calcredit()
        {
            var frm = document.forms['transForm'];
            var src_credit = frm.fromcredits.value;
            var dest_credit = frm.tocredits.value;
            var in_credit = frm.amount.value;
            var org_title = frm.fromcredits[frm.fromcredits.selectedIndex].innerHTML;
            var dst_title = frm.tocredits[frm.tocredits.selectedIndex].innerHTML;
            var radio = 0;
            var shop_points = ['rank_points', 'pay_points'];
            if (parseFloat(in_credit) > parseFloat(document.getElementById(shop_points[src_credit]).value))
            {
                alert(balance.replace('{%s}', org_title));
                frm.amount.value = frm.desamount.value = 0;
                return false;
            }
            if (typeof(out_exchange_allow[dest_credit+'|'+src_credit]) == 'string')
            {
                radio = (1 / parseFloat(out_exchange_allow[dest_credit+'|'+src_credit])).toFixed(2);
            }
            document.getElementById('orgcredittitle').innerHTML = org_title;
            document.getElementById('descreditamount').innerHTML = radio;
            document.getElementById('descredittitle').innerHTML = dst_title;
            if (in_credit > 0)
            {
                if (typeof(out_exchange_allow[dest_credit+'|'+src_credit]) == 'string')
                {
                    frm.desamount.value = Math.floor(parseFloat(in_credit) / parseFloat(out_exchange_allow[dest_credit+'|'+src_credit]));
                    frm.transfrom.disabled = false;
                    return true;
                }
                else
                {
                    frm.desamount.value = deny;
                    frm.transfrom.disabled = true;
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
       </script>
       <?php else: ?>
        <b><?php echo $this->_var['lang']['cur_points']; ?>:</b>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td width="30%" valign="top" bgcolor="#FFFFFF"><table border="0">
              <?php $_from = $this->_var['bbs_points']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'points');if (count($_from)):
    foreach ($_from AS $this->_var['points']):
?>
              <tr>
                <th><?php echo $this->_var['points']['title']; ?>:</th>
                <td width="120" style="border-bottom:1px solid #DADADA;"><?php echo $this->_var['points']['value']; ?></td>
              </tr>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table></td>
            <td width="50%" valign="top" bgcolor="#FFFFFF"><table>
                    <tr>
                <th><?php echo $this->_var['lang']['pay_points']; ?>:</th>
                <td width="120" style="border-bottom:1px solid #DADADA;"><?php echo $this->_var['shop_points']['pay_points']; ?></td>
                    </tr>
              <tr>
                <th><?php echo $this->_var['lang']['rank_points']; ?>:</th>
                <td width="120" style="border-bottom:1px solid #DADADA;"><?php echo $this->_var['shop_points']['rank_points']; ?></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <br />
        <b><?php echo $this->_var['lang']['rule_list']; ?>:</b>
        <ul class="point clearfix">
          <?php $_from = $this->_var['rule_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rule');if (count($_from)):
    foreach ($_from AS $this->_var['rule']):
?>
          <li><font class="f1">·</font>"<?php echo $this->_var['rule']['from']; ?>" <?php echo $this->_var['lang']['transform']; ?> "<?php echo $this->_var['rule']['to']; ?>" <?php echo $this->_var['lang']['rate_is']; ?> <?php echo $this->_var['rule']['rate']; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>

        <form action="user.php" method="post" name="theForm">
        <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border-collapse:collapse;border:1px solid #DADADA;">
          <tr style="background:#F1F1F1;">
            <th><?php echo $this->_var['lang']['rule']; ?></th>
            <th><?php echo $this->_var['lang']['transform_num']; ?></th>
            <th><?php echo $this->_var['lang']['transform_result']; ?></th>
          </tr>
          <tr>
            <td>
              <select name="rule_index" onchange="changeRule()">
                <?php $_from = $this->_var['rule_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rule');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rule']):
?>
                <option value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['rule']['from']; ?>-><?php echo $this->_var['rule']['to']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
          </td>
          <td>
            <input type="text" name="num" value="0" onkeyup="calPoints()"/>
          </td>
          <td><span id="ECS_RESULT">0</span></td>
          </tr>
          <tr>
            <td colspan="3" align="center"><input type="hidden" name="act" value="act_transform_points"  /><input type="submit" value="<?php echo $this->_var['lang']['transform']; ?>" /></td>
          </tr>
        </table>
        </form>
       <script type="text/javascript">
          //<![CDATA[
            var rule_list = new Object();
            var invalid_input = '<?php echo $this->_var['lang']['invalid_input']; ?>';
            <?php $_from = $this->_var['rule_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rule');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rule']):
?>
            rule_list['<?php echo $this->_var['key']; ?>'] = '<?php echo $this->_var['rule']['rate']; ?>';
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            function calPoints()
            {
              var frm = document.forms['theForm'];
              var rule_index = frm.elements['rule_index'].value;
              var num = parseInt(frm.elements['num'].value);
              var rate = rule_list[rule_index];

              if (isNaN(num) || num < 0 || num != frm.elements['num'].value)
              {
                document.getElementById('ECS_RESULT').innerHTML = invalid_input;
                rerutn;
              }
              var arr = rate.split(':');
              var from = parseInt(arr[0]);
              var to = parseInt(arr[1]);

              if (from <=0 || to <=0)
              {
                from = 1;
                to = 0;
              }
              document.getElementById('ECS_RESULT').innerHTML = parseInt(num * to / from);
            }

            function changeRule()
            {
              document.forms['theForm'].elements['num'].value = 0;
              document.getElementById('ECS_RESULT').innerHTML = 0;
            }
          //]]>
       </script>
       <?php endif; ?>
        <?php endif; ?>
        




      </div>
     </div>
    </div>
  </div>
  
</div>
<div class="blank"></div>
<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['clips_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</html>


