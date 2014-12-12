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

<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,common.js,user.js')); ?>
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
         
         <?php if ($this->_var['action'] == 'default'): ?>
          <font class="f5"><b class="f4"><?php echo $this->_var['info']['username']; ?></b> <?php echo $this->_var['lang']['welcome_to']; ?> <?php echo $this->_var['info']['shop_name']; ?>！</font><br />
          <div class="blank"></div>
          <?php echo $this->_var['lang']['last_time']; ?>: <?php echo $this->_var['info']['last_time']; ?><br />
          <div class="blank5"></div>
          <?php echo $this->_var['rank_name']; ?> <?php echo $this->_var['next_rank_name']; ?><br />
          <div class="blank5"></div>
           <?php if ($this->_var['info']['is_validate'] == 0): ?>
          <?php echo $this->_var['lang']['not_validated']; ?> <a href="javascript:sendHashMail()" style="color:#006bd0;"><?php echo $this->_var['lang']['resend_hash_mail']; ?></a><br />
           <?php endif; ?>
           <div style="margin:5px 0; border:1px solid #F2E19B;padding:10px 20px; background-color:#FFF9D5;">
           <img src="themes/jd2013/images/note.gif" alt="note" />&nbsp;<?php echo $this->_var['user_notice']; ?>
           </div>
           <br /><br />
          <div class="f_l" style="width:350px;">
          <h5><span><?php echo $this->_var['lang']['your_account']; ?></span></h5>
          <div class="blank"></div>
          <?php echo $this->_var['lang']['your_surplus']; ?>:<a href="user.php?act=account_log" style="color:#006bd0;"><?php echo $this->_var['info']['surplus']; ?></a><br />
          <?php if ($this->_var['info']['credit_line'] > 0): ?>
          <?php echo $this->_var['lang']['credit_line']; ?>:<?php echo $this->_var['info']['formated_credit_line']; ?><br />
          <?php endif; ?>
          <?php echo $this->_var['lang']['your_bonus']; ?>:<a href="user.php?act=bonus" style="color:#006bd0;"><?php echo $this->_var['info']['bonus']; ?></a><br />
          <?php echo $this->_var['lang']['your_integral']; ?>:<?php echo $this->_var['info']['integral']; ?><br />
          </div>
          <div class="f_r" style="width:350px;">
          <h5><span><?php echo $this->_var['lang']['your_notice']; ?></span></h5>
          <div class="blank"></div>
           <?php $_from = $this->_var['prompt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <?php echo $this->_var['item']['text']; ?><br />
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php echo $this->_var['lang']['last_month_order']; ?><?php echo $this->_var['info']['order_count']; ?><?php echo $this->_var['lang']['order_unit']; ?><br />
          <?php if ($this->_var['info']['shipped_order']): ?>
          <?php echo $this->_var['lang']['please_received']; ?><br />
          <?php $_from = $this->_var['info']['shipped_order']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>" style="color:#006bd0;"><?php echo $this->_var['item']['order_sn']; ?></a>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php endif; ?>
          </div>
         <?php endif; ?>
         
         
         <?php if ($this->_var['action'] == 'message_list'): ?>
          <h5><span><?php echo $this->_var['lang']['label_message']; ?></span></h5>
          <div class="blank"></div>
           <?php $_from = $this->_var['message_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'message');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['message']):
?>
          <div class="f_l">
          <b><?php echo $this->_var['message']['msg_type']; ?>:</b>&nbsp;&nbsp;<font class="f4"><?php echo $this->_var['message']['msg_title']; ?></font> (<?php echo $this->_var['message']['msg_time']; ?>)
          </div>
          <div class="f_r">
          <a href="user.php?act=del_msg&amp;id=<?php echo $this->_var['key']; ?>&amp;order_id=<?php echo $this->_var['message']['order_id']; ?>" title="<?php echo $this->_var['lang']['drop']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_msg']; ?>')) return false;" class="f6"><?php echo $this->_var['lang']['drop']; ?></a>
          </div>
          <div class="msgBottomBorder">
          <?php echo $this->_var['message']['msg_content']; ?>
           <?php if ($this->_var['message']['message_img']): ?>
           <div align="right">
           <a href="data/feedbackimg/<?php echo $this->_var['message']['message_img']; ?>" target="_bank" class="f6"><?php echo $this->_var['lang']['view_upload_file']; ?></a>
           </div>
           <?php endif; ?>
           <br />
           <?php if ($this->_var['message']['re_msg_content']): ?>
           <a href="mailto:<?php echo $this->_var['message']['re_user_email']; ?>" class="f6"><?php echo $this->_var['lang']['shopman_reply']; ?></a> (<?php echo $this->_var['message']['re_msg_time']; ?>)<br />
           <?php echo $this->_var['message']['re_msg_content']; ?>
           <?php endif; ?>
          </div>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php if ($this->_var['message_list']): ?>
          <div class="f_r">
          <?php echo $this->fetch('library/pages.lbi'); ?>
          </div>
          <?php endif; ?>
          <div class="blank"></div>
          <form action="user.php" method="post" enctype="multipart/form-data" name="formMsg" onSubmit="return submitMsg()">
                  <table width="100%" border="0" cellpadding="3">
                    <?php if ($this->_var['order_info']): ?>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['order_number']; ?></td>
                      <td>
                      <a href ="<?php echo $this->_var['order_info']['url']; ?>"><img src="themes/jd2013/images/note.gif" /><?php echo $this->_var['order_info']['order_sn']; ?></a>
                      <input name="msg_type" type="hidden" value="5" />
                      <input name="order_id" type="hidden" value="<?php echo $this->_var['order_info']['order_id']; ?>" class="inputBg" />
                      </td>
                    </tr>
                    <?php else: ?>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['message_type']; ?>：</td>
                      <td><input name="msg_type" type="radio" value="0" checked="checked" />
                        <?php echo $this->_var['lang']['type']['0']; ?>
                        <input type="radio" name="msg_type" value="1" />
                        <?php echo $this->_var['lang']['type']['1']; ?>
                        <input type="radio" name="msg_type" value="2" />
                        <?php echo $this->_var['lang']['type']['2']; ?>
                        <input type="radio" name="msg_type" value="3" />
                        <?php echo $this->_var['lang']['type']['3']; ?>
                        <input type="radio" name="msg_type" value="4" />
                        <?php echo $this->_var['lang']['type']['4']; ?> </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['message_title']; ?>：</td>
                      <td><input name="msg_title" type="text" size="30" class="inputBg" /></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->_var['lang']['message_content']; ?>：</td>
                      <td><textarea name="msg_content" cols="50" rows="4" wrap="virtual" class="B_blue"></textarea></td>
                    </tr>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['upload_img']; ?>：</td>
                      <td><input type="file" name="message_img"  size="45"  class="inputBg" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input type="hidden" name="act" value="act_add_message" />
                        <input type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_bonus" />
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>
                      <?php echo $this->_var['lang']['img_type_tips']; ?><br />
                      <?php echo $this->_var['lang']['img_type_list']; ?>
                      </td>
                    </tr>
                  </table>
                </form>
         <?php endif; ?>
         
         
          <?php if ($this->_var['action'] == 'comment_list'): ?>
          <h5><span><?php echo $this->_var['lang']['label_comment']; ?></span></h5>
          <div class="blank"></div>
          <?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
          <div class="f_l">
          <b><?php if ($this->_var['comment']['comment_type'] == '0'): ?><?php echo $this->_var['lang']['goods_comment']; ?><?php else: ?><?php echo $this->_var['lang']['article_comment']; ?><?php endif; ?>: </b><font class="f4"><?php echo $this->_var['comment']['cmt_name']; ?></font>&nbsp;&nbsp;(<?php echo $this->_var['comment']['formated_add_time']; ?>)
          </div>
          <div class="f_r">
          <a href="user.php?act=del_cmt&amp;id=<?php echo $this->_var['comment']['comment_id']; ?>" title="<?php echo $this->_var['lang']['drop']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_msg']; ?>')) return false;" class="f6"><?php echo $this->_var['lang']['drop']; ?></a>
          </div>
          <div class="msgBottomBorder">
          <?php echo htmlspecialchars($this->_var['comment']['content']); ?><br />
          <?php if ($this->_var['comment']['reply_content']): ?>
          <b><?php echo $this->_var['lang']['reply_comment']; ?>：</b><br />
          <?php echo $this->_var['comment']['reply_content']; ?>
           <?php endif; ?>
          </div>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php if ($this->_var['comment_list']): ?>
          <?php echo $this->fetch('library/pages.lbi'); ?>
          <?php else: ?>
          <?php echo $this->_var['lang']['no_comments']; ?>
          <?php endif; ?>
          <?php endif; ?>
    
    
    <?php if ($this->_var['action'] == 'tag_list'): ?>
    <h5><span><?php echo $this->_var['lang']['label_tag']; ?></span></h5>
    <div class="blank"></div>
     <?php if ($this->_var['tags']): ?>
    <?php $_from = $this->_var['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'tag');if (count($_from)):
    foreach ($_from AS $this->_var['tag']):
?>
    <a href="search.php?keywords=<?php echo urlencode($this->_var['tag']['tag_words']); ?>" class="f6"><?php echo htmlspecialchars($this->_var['tag']['tag_words']); ?></a> <a href="user.php?act=act_del_tag&amp;tag_words=<?php echo urlencode($this->_var['tag']['tag_words']); ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_drop_tag']; ?>')) return false;" title="<?php echo $this->_var['lang']['drop']; ?>"><img src="themes/jd2013/images/drop.gif" alt="<?php echo $this->_var['lang']['drop']; ?>" /></a>&nbsp;&nbsp;
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php else: ?>
    <span style="margin:2px 10px; font-size:14px; line-height:36px;"><?php echo $this->_var['lang']['no_tag']; ?></span>
    <?php endif; ?>
    <?php endif; ?>
    
    
    <?php if ($this->_var['action'] == 'collection_list'): ?>
  <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
    <h5><span><?php echo $this->_var['lang']['label_collection']; ?></span></h5>
    <div class="blank"></div>
     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
      <tr align="center">
        <th width="35%" bgcolor="#ffffff"><?php echo $this->_var['lang']['goods_name']; ?></th>
        <th width="30%" bgcolor="#ffffff"><?php echo $this->_var['lang']['price']; ?></th>
        <th width="35%" bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></th>
      </tr>
      <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
      <tr>
        <td bgcolor="#ffffff"><a href="<?php echo $this->_var['goods']['url']; ?>" class="f6"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></td>
        <td bgcolor="#ffffff"><?php if ($this->_var['goods']['promote_price'] != ""): ?>
          <?php echo $this->_var['lang']['promote_price']; ?><span class="goods-price"><?php echo $this->_var['goods']['promote_price']; ?></span>
          <?php else: ?>
          <?php echo $this->_var['lang']['shop_price']; ?><span class="goods-price"><?php echo $this->_var['goods']['shop_price']; ?></span>
          <?php endif; ?>        </td>
        <td align="center" bgcolor="#ffffff">
          <?php if ($this->_var['goods']['is_attention']): ?>
          <a href="javascript:if (confirm('<?php echo $this->_var['lang']['del_attention']; ?>')) location.href='user.php?act=del_attention&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>'" class="f6"><?php echo $this->_var['lang']['no_attention']; ?></a>
          <?php else: ?>
          <a href="javascript:if (confirm('<?php echo $this->_var['lang']['add_to_attention']; ?>')) location.href='user.php?act=add_to_attention&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>'" class="f6"><?php echo $this->_var['lang']['attention']; ?></a>
          <?php endif; ?>
           <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" class="f6"><?php echo $this->_var['lang']['add_to_cart']; ?></a> <a href="javascript:if (confirm('<?php echo $this->_var['lang']['remove_collection_confirm']; ?>')) location.href='user.php?act=delete_collection&collection_id=<?php echo $this->_var['goods']['rec_id']; ?>'" class="f6"><?php echo $this->_var['lang']['drop']; ?></a>
        </td>
      </tr>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php echo $this->fetch('library/pages.lbi'); ?>
     <div class="blank5"></div>

    <h5><span><?php echo $this->_var['lang']['label_affiliate']; ?></span></h5>
    <div class="blank"></div>
     <form name="theForm" method="post" action="">
     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr>
      <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_need_image']; ?></td>
      <td bgcolor="#ffffff">
        <select name="need_image" id="need_image">
          <option value="true" selected><?php echo $this->_var['lang']['need']; ?></option>
          <option value="false"><?php echo $this->_var['lang']['need_not']; ?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_goods_num']; ?></td>
      <td bgcolor="#ffffff"><input name="goods_num" type="text" id="goods_num" value="6" class="inputBg" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_arrange']; ?></td>
      <td bgcolor="#ffffff"><select name="arrange" id="arrange">
        <option value="h" selected><?php echo $this->_var['lang']['horizontal']; ?></option>
        <option value="v"><?php echo $this->_var['lang']['verticle']; ?></option>
      </select></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_rows_num']; ?></td>
      <td bgcolor="#ffffff"><input name="rows_num" type="text" id="rows_num" value="1" class="inputBg" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['label_charset']; ?></td>
      <td bgcolor="#ffffff"><select name="charset" id="charset">
        <?php echo $this->html_options(array('options'=>$this->_var['lang_list'])); ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#ffffff"><input type="button" name="gen_code" value="<?php echo $this->_var['lang']['generate']; ?>" onclick="genCode()" class="bnt_blue_1" />
			</td>
  </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#ffffff"><textarea name="code" cols="80" rows="5" id="code" class="B_blue"></textarea></td>
  </tr>
  </table>
     </form>
      <script language="JavaScript">
      var elements = document.forms['theForm'].elements;
      var url = '<?php echo $this->_var['url']; ?>';
      var u   = '<?php echo $this->_var['user_id']; ?>';
      /**
       * 生成代码
       */
      function genCode()
      {
          // 检查输入
          if (isNaN(parseInt(elements['goods_num'].value)))
          {
              alert('<?php echo $this->_var['lang']['goods_num_must_be_int']; ?>');
              return;
          }
          if (elements['goods_num'].value < 1)
          {
              alert('<?php echo $this->_var['lang']['goods_num_must_over_0']; ?>');
              return;
          }
          if (isNaN(parseInt(elements['rows_num'].value)))
          {
              alert('<?php echo $this->_var['lang']['rows_num_must_be_int']; ?>');
              return;
          }
          if (elements['rows_num'].value < 1)
          {
              alert('<?php echo $this->_var['lang']['rows_num_must_over_0']; ?>');
              return;
          }

          // 生成代码
          var code = '\<script src=\"' + url + 'goods_script.php?';
          code += 'need_image=' + elements['need_image'].value + '&';
          code += 'goods_num=' + elements['goods_num'].value + '&';
          code += 'arrange=' + elements['arrange'].value + '&';
          code += 'rows_num=' + elements['rows_num'].value + '&';
          code += 'charset=' + elements['charset'].value + '&u=' + u;
          code += '\"\>\</script\>';
          elements['code'].value = code;
          elements['code'].select();
          if (Browser.isIE)
          {
              window.clipboardData.setData("Text",code);
          }
      }
	var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
  var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
  var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
  var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
  </script>
  <?php endif; ?>
    
    
    <?php if ($this->_var['action'] == 'booking_list'): ?>
    <h5><span><?php echo $this->_var['lang']['label_booking']; ?></span></h5>
    <div class="blank"></div>
     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
      <tr align="center">
        <td width="20%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_goods_name']; ?></td>
        <td width="10%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_amount']; ?></td>
        <td width="20%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_time']; ?></td>
        <td width="35%" bgcolor="#ffffff"><?php echo $this->_var['lang']['process_desc']; ?></td>
        <td width="15%" bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
      </tr>
      <?php $_from = $this->_var['booking_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
      <tr>
        <td align="left" bgcolor="#ffffff"><a href="<?php echo $this->_var['item']['url']; ?>" target="_blank" class="f6"><?php echo $this->_var['item']['goods_name']; ?></a></td>
        <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['goods_number']; ?></td>
        <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['booking_time']; ?></td>
        <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['dispose_note']; ?></td>
        <td align="center" bgcolor="#ffffff"><a href="javascript:if (confirm('<?php echo $this->_var['lang']['confirm_remove_account']; ?>')) location.href='user.php?act=act_del_booking&id=<?php echo $this->_var['item']['rec_id']; ?>'" class="f6"><?php echo $this->_var['lang']['drop']; ?></a> </td>
      </tr>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php endif; ?>
    <div class="blank5"></div>
   
  <?php if ($this->_var['action'] == 'add_booking'): ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['booking_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
    <h5><span><?php echo $this->_var['lang']['add']; ?><?php echo $this->_var['lang']['label_booking']; ?></span></h5>
    <div class="blank"></div>
     <form action="user.php" method="post" name="formBooking" onsubmit="return addBooking();">
     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_goods_name']; ?></td>
        <td bgcolor="#ffffff"><?php echo $this->_var['info']['goods_name']; ?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_amount']; ?>:</td>
        <td bgcolor="#ffffff"><input name="number" type="text" value="<?php echo $this->_var['info']['goods_number']; ?>" class="inputBg" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['describe']; ?>:</td>
        <td bgcolor="#ffffff"><textarea name="desc" cols="50" rows="5" wrap="virtual" class="B_blue"><?php echo $this->_var['goods_attr']; ?><?php echo htmlspecialchars($this->_var['info']['goods_desc']); ?></textarea>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['contact_username']; ?>:</td>
        <td bgcolor="#ffffff"><input name="linkman" type="text" value="<?php echo htmlspecialchars($this->_var['info']['consignee']); ?>" size="25"  class="inputBg"/>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['email_address']; ?>:</td>
        <td bgcolor="#ffffff"><input name="email" type="text" value="<?php echo htmlspecialchars($this->_var['info']['email']); ?>" size="25" class="inputBg" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['contact_phone']; ?>:</td>
        <td bgcolor="#ffffff"><input name="tel" type="text" value="<?php echo htmlspecialchars($this->_var['info']['tel']); ?>" size="25" class="inputBg" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff">&nbsp;</td>
        <td bgcolor="#ffffff"><input name="act" type="hidden" value="act_add_booking" />
          <input name="id" type="hidden" value="<?php echo $this->_var['info']['id']; ?>" />
          <input name="rec_id" type="hidden" value="<?php echo $this->_var['info']['rec_id']; ?>" />
          <input type="submit" name="submit" class="submit" value="<?php echo $this->_var['lang']['submit_booking_goods']; ?>" />
          <input type="reset" name="reset" class="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
        </td>
      </tr>
    </table>
     </form>
    <?php endif; ?>
    
    <?php if ($this->_var['affiliate']['on'] == 1): ?>
     <?php if ($this->_var['action'] == 'affiliate'): ?>
      <?php if (! $this->_var['goodsid'] || $this->_var['goodsid'] == 0): ?>
      <h5><span><?php echo $this->_var['lang']['affiliate_detail']; ?></span></h5>
      <div class="blank"></div>
     <?php echo $this->_var['affiliate_intro']; ?>
    <?php if ($this->_var['affiliate']['config']['separate_by'] == 0): ?>
    
    <div class="blank"></div>
    <h5><span><a name="myrecommend"><?php echo $this->_var['lang']['affiliate_member']; ?></a></span></h5>
    <div class="blank"></div>
   <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_lever']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_num']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_point']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_money']; ?></td>
    </tr>
    <?php $_from = $this->_var['affdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level', 'val');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level'] => $this->_var['val']):
        $this->_foreach['affdb']['iteration']++;
?>
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['level']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['num']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

<?php else: ?>


<?php endif; ?>

<div class="blank"></div>
<h5><span>分成规则</span></h5>
<div class="blank"></div>
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_number']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_money']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_point']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_mode']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_status']; ?></td>
    </tr>
    <?php $_from = $this->_var['logdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['logdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['logdb']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['logdb']['iteration']++;
?>
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['order_sn']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
      <td bgcolor="#ffffff"><?php if ($this->_var['val']['separate_type'] == 1 || $this->_var['val']['separate_type'] === 0): ?><?php echo $this->_var['lang']['affiliate_type'][$this->_var['val']['separate_type']]; ?><?php else: ?><?php echo $this->_var['lang']['affiliate_type'][$this->_var['affiliate_type']]; ?><?php endif; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_stats'][$this->_var['val']['is_separate']]; ?></td>
    </tr>
    <?php endforeach; else: ?>
<tr><td colspan="5" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['no_records']; ?></td>
</tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['logdb']): ?>
    <tr>
    <td colspan="5" bgcolor="#ffffff">
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
  <div id="pager"> <?php echo $this->_var['lang']['pager_1']; ?><?php echo $this->_var['pager']['record_count']; ?><?php echo $this->_var['lang']['pager_2']; ?><?php echo $this->_var['lang']['pager_3']; ?><?php echo $this->_var['pager']['page_count']; ?><?php echo $this->_var['lang']['pager_4']; ?> <span> <a href="<?php echo $this->_var['pager']['page_first']; ?>"><?php echo $this->_var['lang']['page_first']; ?></a> <a href="<?php echo $this->_var['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?></a> <a href="<?php echo $this->_var['pager']['page_next']; ?>"><?php echo $this->_var['lang']['page_next']; ?></a> <a href="<?php echo $this->_var['pager']['page_last']; ?>"><?php echo $this->_var['lang']['page_last']; ?></a> </span>
    <select name="page" id="page" onchange="selectPage(this)">
    <?php echo $this->html_options(array('options'=>$this->_var['pager']['array'],'selected'=>$this->_var['pager']['page'])); ?>
    </select>
    <input type="hidden" name="act" value="affiliate" />
  </div>
</form>
    </td>
    </tr>
    <?php endif; ?>
  </table>
 <script type="text/javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>

<div class="blank"></div>
<h5><span><?php echo $this->_var['lang']['affiliate_code']; ?></span></h5>
<div class="blank"></div>
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
<tr>
<td width="30%" bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" class="f6"><?php echo $this->_var['shopname']; ?></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="&lt;a href=&quot;<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>&quot; target=&quot;_blank&quot;&gt;<?php echo $this->_var['shopname']; ?>&lt;/a&gt;" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_webcode']; ?></td>
</tr>
<tr>
<td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" title="<?php echo $this->_var['shopname']; ?>"  class="f6"><img src="<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>" /></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="&lt;a href=&quot;<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>&quot; target=&quot;_blank&quot; title=&quot;<?php echo $this->_var['shopname']; ?>&quot;&gt;&lt;img src=&quot;<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>&quot; /&gt;&lt;/a&gt;" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_webcode']; ?></td>
</tr>
<tr>
<td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" class="f6"><?php echo $this->_var['shopname']; ?></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="[url=<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>]<?php echo $this->_var['shopname']; ?>[/url]" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_bbscode']; ?></td>
</tr>
<tr>
<td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" title="<?php echo $this->_var['shopname']; ?>" class="f6"><img src="<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>" /></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="[url=<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>][img]<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>[/img][/url]" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_bbscode']; ?></td>
</tr>
</table>

        <?php else: ?>
        
        <style type="text/css">
        .types a{text-decoration:none; color:#006bd0;}
        </style>
    <h5><span><?php echo $this->_var['lang']['affiliate_code']; ?></span></h5>
    <div class="blank"></div>
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_view']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_code']; ?></td>
    </tr>
    <?php $_from = $this->_var['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['types'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['types']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['types']['iteration']++;
?>
    <tr align="center">
      <td bgcolor="#ffffff" class="types"><script src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>"></script></td>
      <td bgcolor="#ffffff">javascript <?php echo $this->_var['lang']['affiliate_codetype']; ?><br>
        <textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>" style="border:1px solid #ccc;"><script src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>"></script></textarea>[<a href="#" titleTo Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]
<br>iframe <?php echo $this->_var['lang']['affiliate_codetype']; ?><br><textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_iframe"  style="border:1px solid #ccc;"><iframe width="250" height="270" src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>&display_mode=iframe" frameborder="0" scrolling="no"></iframe></textarea>[<a href="#" titleTo Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_iframe').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');" class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]
<br /><?php echo $this->_var['lang']['bbs']; ?>UBB <?php echo $this->_var['lang']['affiliate_codetype']; ?><br /><textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_ubb"  style="border:1px solid #ccc;"><?php if ($this->_var['val'] != 5): ?>[url=<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>][img]<?php if ($this->_var['val'] < 3): ?><?php echo $this->_var['goods']['goods_thumb']; ?><?php else: ?><?php echo $this->_var['goods']['goods_img']; ?><?php endif; ?>[/img][/url]<?php endif; ?>

[url=<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>][b]<?php echo $this->_var['goods']['goods_name']; ?>[/b][/url]
<?php if ($this->_var['val'] != 1 && $this->_var['val'] != 3): ?>[s]<?php echo $this->_var['goods']['market_price']; ?>[/s]<?php endif; ?> [color=red]<?php echo $this->_var['goods']['shop_price']; ?>[/color]</textarea>[<a href="#" titleTo Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_ubb').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]
<?php if ($this->_var['val'] == 5): ?><br /><?php echo $this->_var['lang']['im_code']; ?> <?php echo $this->_var['lang']['affiliate_codetype']; ?><br /><textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_txt"  style="border:1px solid #ccc;"><?php echo $this->_var['lang']['show_good_to_you']; ?> <?php echo $this->_var['goods']['goods_name']; ?>

<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?></textarea>[<a href="#" titleTo Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_txt').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]<?php endif; ?></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
<script language="Javascript">
copyToClipboard = function(txt)
{
 if(window.clipboardData)
 {
    window.clipboardData.clearData();
    window.clipboardData.setData("Text", txt);
 }
 else if(navigator.userAgent.indexOf("Opera") != -1)
 {
   //暂时无方法:-(
 }
 else if (window.netscape)
 {
  try
  {
    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
  }
  catch (e)
  {
    alert("<?php echo $this->_var['lang']['firefox_copy_alert']; ?>");
    return false;
  }
  var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
  if (!clip)
    return;
  var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
  if (!trans)
    return;
  trans.addDataFlavor('text/unicode');
  var str = new Object();
  var len = new Object();
  var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
  var copytext = txt;
  str.data = copytext;
  trans.setTransferData("text/unicode",str,copytext.length*2);
  var clipid = Components.interfaces.nsIClipboard;
  if (!clip)
  return false;
  clip.setData(trans,null,clipid.kGlobalClipboard);
 }
}
                </script>
            
            <?php endif; ?>
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


