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
<?php if ($this->_var['cat_style']): ?>
<link href="<?php echo $this->_var['cat_style']; ?>" rel="stylesheet" type="text/css" />
<?php endif; ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js')); ?>
<!--[if lte IE 6]>
<script type="text/javascript" src="themes/jd2013/js/DD_belatedPNG.js"></script>
<script type="text/javascript">
  DD_belatedPNG.fix('.goodsItem span');
</script>
<![endif]-->
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="clear"></div>

<div class="block">
 <div id="ur_here">
  <?php echo $this->fetch('library/ur_here.lbi'); ?>
 </div>
</div>

<div class="blank5"></div>
<div class="block clearfix">
  
<div class="AreaL">
<div id="sortlist">  
  <?php $_from = get_categories_tree(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
<?php if ($this->_var['category'] == $this->_var['cat']['id'] || $this->_var['cat']['id'] == $this->_var['topcat_id']): ?>  
<div class="mt"><h2><?php echo htmlspecialchars($this->_var['cat']['name']); ?></h2></div>
	<div class="mc">
	<?php if ($this->_var['topcat_id'] == $this->_var['cat']['id']): ?> 
       <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['childnum'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['childnum']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['childnum']['iteration']++;
?>  
	<div id="subitem<?php echo $this->_foreach['childnum']['iteration']; ?>" class="item<?php if ($this->_var['cat_parent_id'] == $this->_var['child']['id']): ?> current<?php elseif ($this->_var['cat_parent_id'] == $this->_var['cat']['id'] && $this->_var['category'] == $this->_var['child']['id']): ?> current<?php endif; ?>"><h3 onclick="showmenu(<?php echo $this->_foreach['childnum']['iteration']; ?>)"><b></b><a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></h3>
	<ul>
	 <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');$this->_foreach['curn'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['curn']['total'] > 0):
    foreach ($_from AS $this->_var['childer']):
        $this->_foreach['curn']['iteration']++;
?>
	   <li><a href="<?php echo $this->_var['childer']['url']; ?>" <?php if ($this->_var['category'] == $this->_var['childer']['id']): ?>class="cat3"<?php endif; ?>><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a></li>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	</ul>
	</div>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	  <?php endif; ?> 
	</div>
	<?php endif; ?> 
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<script language="javascript">
function showmenu(sid)
{
var subitem=document.getElementById("subitem"+sid);
if(subitem.className=='item'){
subitem.className='item current';
}
else{
subitem.className='item';
}
}
</script>
<div class="blank"></div>
<div class="box">
 <div class="box_1">
  <div class="category_allc"><div class="tit">本周热销榜</div></div>
  <div class="boxCenterList clearfix">
	<?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
	<ul class="clearfix">
	<li class="goodsimg"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" target="_blank"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" /></a></li><li><p class="nmae"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['goods']['name']); ?></a></p><font class="f1"><?php if ($this->_var['goods']['promote_price'] != ""): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></font><br /></li>
	</ul>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
 </div>
</div>
<div class="blank5"></div>
<div class="box_1">
<div class="category_allc"><div class="tit">一周销量排行榜</div></div>
 <div class="rank">
  <div class="mc" style="border:0">
					<ul class="tabcon">
					<?php $_from = $this->_var['top_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['top_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['top_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['top_goods']['iteration']++;
?>     
					<?php if ($this->_foreach['top_goods']['iteration'] < 2): ?>               
					<li class="fore"><span><?php echo $this->_foreach['top_goods']['iteration']; ?></span><div class="p-img"><a target="_blank" href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"  height="50" width="50"></a></div><div class="p-name"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_name']; ?></a></div><div class="p-price"><strong><?php echo $this->_var['goods']['price']; ?></strong></div></li>
					<?php else: ?>
					<li><span<?php if ($this->_foreach['top_goods']['iteration'] > 3): ?> class="bg1"<?php endif; ?>><?php echo $this->_foreach['top_goods']['iteration']; ?></span><div class="p-name"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_name']; ?></a></div></li>
					<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</ul>
				</div>
  
 </div>
</div>
<div class="blank5"></div>
 <?php echo $this->fetch('library/history.lbi'); ?>
    
  </div>
  
  
  <div class="AreaR">

	 
	  <?php if ($this->_var['brands']['1'] || $this->_var['price_grade']['1'] || $this->_var['filter_attr_list']): ?>
	  <div id="select">
	  <div class="box_1" style="border-bottom:0">
       <div class="category_allc clearfix"><div class="tit" style="float:left"><span class="cname"><?php echo $this->_var['cat_name']; ?></span>&nbsp;-&nbsp;商品筛选</div><div class="extra"><a href="category.php?id=<?php echo $this->_var['category']; ?>">重置筛选条件</a></div></div>
	    <div class="blank5"></div>
			<?php if ($this->_var['brands']['1']): ?>
			<div class="screeBox">
              <div class="screeBoxs">
			    <strong><?php echo $this->_var['lang']['brand']; ?>：</strong>
				<?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>
					<?php if ($this->_var['brand']['selected']): ?>
					<span><?php echo $this->_var['brand']['brand_name']; ?></span>
					<?php else: ?>
					<a href="<?php echo $this->_var['brand']['url']; ?>"><?php echo $this->_var['brand']['brand_name']; ?></a>&nbsp;
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
               </div>
			</div>
			<?php endif; ?>
			<?php if ($this->_var['price_grade']['1']): ?>
			<div class="screeBox">
            <div class="screeBoxs">
			<strong><?php echo $this->_var['lang']['price']; ?>：</strong>
			<?php $_from = $this->_var['price_grade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'grade');if (count($_from)):
    foreach ($_from AS $this->_var['grade']):
?>
				<?php if ($this->_var['grade']['selected']): ?>
				<span><?php echo $this->_var['grade']['price_range']; ?></span>
				<?php else: ?>
				<a href="<?php echo $this->_var['grade']['url']; ?>"><?php echo $this->_var['grade']['price_range']; ?></a>&nbsp;
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
             </div>
			</div>
			<?php endif; ?>
			<?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter_attr_0_44729200_1418266297');if (count($_from)):
    foreach ($_from AS $this->_var['filter_attr_0_44729200_1418266297']):
?>
      <div class="screeBox">
           <div class="screeBoxs">
			<strong><?php echo htmlspecialchars($this->_var['filter_attr_0_44729200_1418266297']['filter_attr_name']); ?>：</strong>
			<?php $_from = $this->_var['filter_attr_0_44729200_1418266297']['attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['attr']):
?>
				<?php if ($this->_var['attr']['selected']): ?>
				<span><?php echo $this->_var['attr']['attr_value']; ?></span>
				<?php else: ?>
				<a href="<?php echo $this->_var['attr']['url']; ?>"><?php echo $this->_var['attr']['attr_value']; ?></a>&nbsp;
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
            </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         <div class="screeBox screeBoxbnone clearfix">
           <div class="screeBoxs">
            <div class="f_l">
			<strong>价格：</strong> <span>全部</span> </div> <div class="f_l pl10"><form action="" method="post" id="s_fm" onsubmit="return sbm();"><input class="inputt" name="price_start" id="minprice" maxlength="8" type="text">
	&nbsp;<label>至</label>&nbsp;<input class="inputt" name="price_end" id="maxprice" maxlength="8" type="text">
    <input value="确定" class="submitbtn" type="submit">
</form></div>
<script type="text/javascript">
         function sbm(){
         var $minprice;
         var $maxprice;
         $minprice=document.getElementById("minprice").value;
         $maxprice=document.getElementById("maxprice").value;
         document.getElementById("s_fm").action="category.php?id="+<?php echo $this->_var['category']; ?>+"&price_min="+$minprice+"&price_max="+$maxprice;
         }
        </script>
			</div>
            <div class="clear"></div>
            </div>
            <div id="advanced"><div><a href="search.php?act=advanced_search">高级搜索</a><b></b></div></div>
		</div>
		<div class="blank5"></div>
	  <?php endif; ?>
	 
  
  
  <?php echo $this->fetch('library/goods_list.lbi'); ?>
  <?php echo $this->fetch('library/pages.lbi'); ?>
  
  <div class="blank"></div>
</div>
</div>
<div class="blank"></div>
<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
