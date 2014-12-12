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
		<h5><span>您所提交的定制套餐</span></h5>
		<table width="100%" bgcolor="#dddddd" border="0" cellpadding="5" cellspacing="1" style="margin-top:10px;">
          <tbody><tr align="center">
            <td bgcolor="#ffffff">套餐名称</td>
            <td bgcolor="#ffffff">提交时间</td>
            <td bgcolor="#ffffff">回复时间</td>
            <td bgcolor="#ffffff">金额</td>
            <td bgcolor="#ffffff">操作</td>
          </tr>
	  <?php $_from = $this->_var['fault_diy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'diy');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['diy']):
?>
	  <tr>
		<td bgcolor="#fff"><?php echo $this->_var['diy']['fault_name']; ?></td>
		<td bgcolor="#fff"><?php echo $this->_var['diy']['add_time']; ?></td>
		<td bgcolor="#fff"><?php echo $this->_var['diy']['handle_time']; ?></td>
		<td bgcolor="#fff"><?php echo $this->_var['diy']['shop_price']; ?></td>
		<td bgcolor="#fff"><a href="goods.php?id=<?php echo $this->_var['diy']['goods_id']; ?>">购买</a></td>
	  </tr>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </tbody></table>
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


