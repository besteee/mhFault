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
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link href="themes/jd2013/base.css" rel="stylesheet" type="text/css">
<link href="themes/jd2013/home.css" rel="stylesheet" type="text/css">

<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.11.0.min.js')); ?>
<!--script type="text/javascript" src="js/MSClass.js"></script>
<script type="text/javascript" src="themes/jd2013/js/scrollpic.js"></script>
<script type="text/javascript" src="js/site.js"></script-->
</head>
<body>
<script type="text/javascript">
var isWidescreen=screen.width>=1280;
if (isWidescreen){document.getElementsByTagName("body")[0].className="w1210";}
</script>
<?php echo $this->fetch('library/index_header.lbi'); ?>
<?php echo $this->fetch('library/index_bestslid.lbi'); ?>
<div id="floatText">
	<div style="font-size:16px;font-weight:bold; line-height:32px;"> 快速询价 产品套餐定制 </div>
	<?php $_from = $this->_var['mhBrand']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['brand']):
?>
	<div class="carSys">
		<div class="carSysTitle"><?php echo $this->_var['brand']['site_carCountry']; ?></div>
		<ul>
		<?php $_from = $this->_var['brand']['carSys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'carSys');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['carSys']):
?>
			<li><a href='brand.php?id=<?php echo $this->_var['carSys']['id']; ?>'><?php echo $this->_var['carSys']['name']; ?></a></li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<div class="clear"></div>
	</div>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

	<div class="clear"></div>
</div>

<div class="w" style="text-align:center;"><img src="themes/jd2013/images/flowImg.jpg"></div>

<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
