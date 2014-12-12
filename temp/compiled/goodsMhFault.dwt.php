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
<link href="themes/jd2013/MagicZoom.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="themes/jd2013/js/mzp-packed-me.js"></script>
<script type="text/javascript" src="themes/jd2013/js/site.js"></script>


<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,jquery-1.11.0.min.js')); ?>
<script type="text/javascript">
function $id(element) {
  return document.getElementById(element);
}
//切屏--是按钮，_v是内容平台，_h是内容库
function reg(str){
  var bt=$id(str+"_b").getElementsByTagName("h2");
  for(var i=0;i<bt.length;i++){
    bt[i].subj=str;
    bt[i].pai=i;
    bt[i].style.cursor="pointer";
    bt[i].onclick=function(){
      $id(this.subj+"_v").innerHTML=$id(this.subj+"_h").getElementsByTagName("blockquote")[this.pai].innerHTML;
      for(var j=0;j<$id(this.subj+"_b").getElementsByTagName("h2").length;j++){
        var _bt=$id(this.subj+"_b").getElementsByTagName("h2")[j];
        var ison=j==this.pai;
        _bt.className=(ison?"":"h2bg");
      }
    }
  }
  $id(str+"_h").className="none";
  $id(str+"_v").innerHTML=$id(str+"_h").getElementsByTagName("blockquote")[0].innerHTML;
}
</script>
 <script type="text/javascript">
function change_img(img_src)
{
document.getElementsByName("goods_img")[0].src=img_src;
}
</script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="clear"></div>
<div class="block box">
 <div id="ur_here">
  <?php echo $this->fetch('library/ur_here.lbi'); ?>
 </div>
</div>

<div class="blank5"></div>
<div class="block clearfix">
  
   <div id="goodsInfo" class="clearfix">
    <div class="imgInfo">
     <?php if ($this->_var['pictures']['0']['img_url']): ?>
    <a href="<?php echo $this->_var['pictures']['0']['img_url']; ?>" id="Zoomer" class="MagicZoomPlus" rel="selectors-effect:false;zoom-fade:true;background-opacity:70;zoom-width:350;zoom-height:350;caption-source:img:title;thumb-change:mouseover" title="">
    <img id="img_url" name="goods_img" src="<?php echo $this->_var['pictures']['0']['img_url']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" class="thumb" />
    </a>
    <?php else: ?>
    <img id="img_url" name="goods_img" src="<?php echo $this->_var['goods']['goods_img']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" class="thumb" />
    <?php endif; ?>
     <div class="blank5"></div>
     
     <?php echo $this->fetch('library/goods_gallery.lbi'); ?>
     
         <div class="blank5"></div>
		<div class="zoompic"><a href="javascript:;" onclick="window.open('gallery.php?id=<?php echo $this->_var['goods']['goods_id']; ?>'); return false;" target="_blank"><img src="themes/jd2013/images/zoompic.gif" alt="放大图片" /></a></div>
	 <div class="sharebg">

<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
<a class="bds_tsina"></a>
<a class="bds_qzone"></a>
<a class="bds_tqq"></a>
<a class="bds_renren"></a>
<a class="bds_t163"></a>
<a class="bds_kaixin001"></a>
<a class="bds_taobao"></a>
<span class="bds_more">更多</span>
<a class="shareCount"></a>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=748721" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
</div>
	 </div>
     
     <div class="textInfo">
     <form action="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
	 <div class="ntitle"><?php echo $this->_var['goods']['goods_style_name']; ?> </div>
	 <?php if ($this->_var['goods']['goods_brief']): ?>
	 <div class="brief"><?php echo $this->_var['goods']['goods_brief']; ?></div>
	 <?php endif; ?>
  <div class="info">
	  <ul>
	   <li class="clearfix">
       <?php if ($this->_var['cfg']['show_goodssn']): ?>
       <?php echo $this->_var['lang']['goods_sn']; ?><?php echo $this->_var['goods']['goods_sn']; ?>
       <?php endif; ?>
      </li>
	  <li class="clearfix">
       <?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?>
      <?php echo $this->smarty_insert_scripts(array('files'=>'lefttime.js')); ?>
      <?php echo $this->_var['lang']['promote_price']; ?><font class="shopprice"><?php echo $this->_var['goods']['promote_price']; ?></font>
      <?php echo $this->_var['lang']['residual_time']; ?>
      <font class="f4" id="leftTime"><?php echo $this->_var['lang']['please_waiting']; ?></font>
      <?php else: ?><?php echo $this->_var['lang']['shop_price']; ?><font class="shopprice" id="ECS_SHOPPRICE"><?php echo $this->_var['goods']['shop_price_formated']; ?> </font> <?php endif; ?>
      </li>

	   <li class="hpj clearfix">
       <div class="f_l onpf"><?php echo $this->_var['lang']['goods_rank']; ?><img src="themes/jd2013/images/stars<?php echo $this->_var['goods']['comment_rank']; ?>.gif" alt="comment rank <?php echo $this->_var['goods']['comment_rank']; ?>" /> <a href="#pj" style="color:#085C9B;">(已经有<?php 
$k = array (
  'name' => 'pl_sum',
  'goods_id' => $this->_var['goods']['goods_id'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>人评价)</a></div>
 </li>

     <?php if ($this->_var['goods']['goods_brand'] != "" && $this->_var['cfg']['show_brand']): ?>
       <li class="clearfix">
      <?php echo $this->_var['lang']['goods_brand']; ?><a href="<?php echo $this->_var['goods']['goods_brand_url']; ?>" ><?php echo $this->_var['goods']['goods_brand']; ?></a>
      </li>
     <?php endif; ?>
      <?php if ($this->_var['rank_prices']): ?>
      <li class="clearfix">
       <?php $_from = $this->_var['rank_prices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rank_price');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rank_price']):
?>
       <?php echo $this->_var['rank_price']['rank_name']; ?>：<font id="ECS_RANKPRICE_<?php echo $this->_var['key']; ?>"><?php echo $this->_var['rank_price']['price']; ?></font>&nbsp;&nbsp;&nbsp;&nbsp;
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </li>
      <?php endif; ?>
      <?php if ($this->_var['volume_price_list']): ?>
      <li class="clearfix">
       <font class="f1"><?php echo $this->_var['lang']['volume_price']; ?>：</font><br />
       <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#ccc">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><strong><?php echo $this->_var['lang']['number_to']; ?></strong></td>
          <td align="center" bgcolor="#FFFFFF"><strong><?php echo $this->_var['lang']['preferences_price']; ?></strong></td>

        </tr>
        <?php $_from = $this->_var['volume_price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('price_key', 'price_list');if (count($_from)):
    foreach ($_from AS $this->_var['price_key'] => $this->_var['price_list']):
?>
        <tr>
        <td align="center" bgcolor="#FFFFFF" class="shop"><?php echo $this->_var['price_list']['number']; ?></td>
        <td align="center" bgcolor="#FFFFFF" class="shop"><?php echo $this->_var['price_list']['format_price']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </table>
      </li>
      <?php endif; ?>


      <?php if ($this->_var['goods']['bonus_money']): ?>
      <li class="padd loop" style="margin-bottom:5px; border-bottom:1px dashed #ccc;">
      <?php echo $this->_var['lang']['goods_bonus']; ?><font class="shop"><?php echo $this->_var['goods']['bonus_money']; ?></font><br />
      </li>
      <?php endif; ?>
	   <?php if ($this->_var['goods']['is_shipping']): ?>
      <li class="clearfix">
      <?php echo $this->_var['lang']['goods_free_shipping']; ?><br />
      </li>
      <?php endif; ?>



      </ul>
     </div>
	   <div class="borderpadd">
       
      <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
?>
      <div class="clearfix" style="padding-bottom:5px;">
      <div class="f_l te"><?php echo $this->_var['spec']['name']; ?>：</div>
        
                    <?php if ($this->_var['spec']['attr_type'] == 1): ?>
                      <?php if ($this->_var['cfg']['goodsattr_style'] == 1): ?>
                        <div class="catt">
                        <ul>
                       <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                       <li style="border:0px;">
<a onclick="changeP('spec_<?php echo $this->_var['spec_key']; ?>','<?php echo $this->_var['value']['id']; ?>')" name="sp_url_<?php echo $this->_var['spec_key']; ?>" id="url_<?php echo $this->_var['value']['id']; ?>"  title="<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>" <?php if ($this->_var['key'] == 0): ?>class="selected"<?php endif; ?>><?php if ($this->_var['value']['pic_id']): ?><div class="f_l"><img width=30 height=30 title="<?php echo $this->_var['value']['label']; ?>" src="<?php echo $this->_var['value']['img_thumb']; ?>" onclick="change_img(this.src)"/></div><div class="f_l" style="padding-left:5px;line-height:30px;"><?php echo $this->_var['value']['label']; ?></div><?php else: ?><?php echo $this->_var['value']['label']; ?><?php endif; ?><input style="display:none" id="spec_value_<?php echo $this->_var['value']['id']; ?>" type="radio" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?>checked<?php endif; ?> /></a>
                      </li>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      </ul>
					  </div>
                        <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                        <?php else: ?>
                        <select name="spec_<?php echo $this->_var['spec_key']; ?>" onchange="changePrice()">
                          <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                          <option label="<?php echo $this->_var['value']['label']; ?>" value="<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?> <?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?><?php if ($this->_var['value']['price'] != 0): ?><?php echo $this->_var['value']['format_price']; ?><?php endif; ?></option>
                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                        <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                      <?php endif; ?>
                    <?php else: ?>
                      <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                      <label for="spec_value_<?php echo $this->_var['value']['id']; ?>">
                      <input type="checkbox" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" onclick="changePrice()" />
                      <?php echo $this->_var['value']['label']; ?> [<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>] </label><br />
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                    <?php endif; ?>
            </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      

	  
	  <script src="js/geo.js"></script>
	  <div id="serve_location">服务站点：<script type="text/javascript" ></script>
        <form name="shareip" action="/cgi-bin/feedback" method="post">
			<select class="select" name="province" id="s1">
			  <option></option>
			</select>
			<select class="select" name="city" id="s2">
			  <option></option>
			</select>
			<select class="select" name="town" id="s3">
			  <option></option>
			</select>
			<input id="address" name="address" type="hidden" value="" />
        </form>
<script>
setup();preselect('省份');promptinfo();
function promptinfo()
{
	var address = document.getElementById('address');
	var s1 = document.getElementById('s1');
	var s2 = document.getElementById('s2');
	var s3 = document.getElementById('s3');
	address.value = s1.value + s2.value + s3.value;
}

</script>

</div>
	  
	  <br>
	  
	  <div>
	  <font>请选择服务套餐：</font><br>
	  <input type='checkbox' name='VoteOption1' value=1><font style="color:rgb(200,0,0);">空调维修￥9000 质保3年</font><br>
	  <input type='checkbox' name='VoteOption1' value=2><font style="color:rgb(200,0,0);">空调保养￥1380 质保1年</font><br>
	  <input type='checkbox' name='VoteOption1' value=3><font style="color:rgb(200,0,0);">电控电子￥800 质保1年</font><br>
	  <input type='checkbox' name='VoteOption1' value=4><font style="color:rgb(200,0,0);">动力恢复￥12800 质保10万公里</font><br>
	  <input type='checkbox' name='VoteOption1' value=4><font style="color:rgb(200,0,0);">制动系统￥7600 质保3万公里</font><br>
      </div>
	  
      <div class="textInpadd clearfix">
	    <div class="snum clearfix"><div class="f_l">购买数量：</div> <a href="javascript:void(0);" onclick="goods_cut();changePrice()" class="imgl"></a><input name="number" type="text" id="number" class="inum" value="1" size="4" onblur="changePrice();get_shipping_list(forms['ECS_FORMBUY'],<?php echo $this->_var['goods']['goods_id']; ?>);"/><a href="javascript:void(0);"  onclick="goods_add();changePrice()" class="imgr"></a> &nbsp;&nbsp;商品总价：<font id="ECS_GOODS_AMOUNT" class="shop"></font></div>

		 <script language="javascript" type="text/javascript">
			function goods_cut(){
				var num_val=document.getElementById('number');
				var new_num=num_val.value;
				 if(isNaN(new_num)){alert('请输入数字');return false}
				var Num = parseInt(new_num);
				if(Num>1)Num=Num-1;
				num_val.value=Num;
			}
			function goods_add(){
				var num_val=document.getElementById('number');
				var new_num=num_val.value;
				 if(isNaN(new_num)){alert('请输入数字');return false}
				var Num = parseInt(new_num);
				Num=Num+1;
				num_val.value=Num;
			}
	    </script>
      </div>

      <div class="textInpadd clearfix">
	  <div class="f_l tmig"><a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/jd2013/images/bnt_cat1.gif" /></a></div><div class="f_l fmig"><a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/jd2013/images/bnt_colles.gif" /></a></div>
      </div>
	  </div>
      </form>

   </div>
    </div>
</div>

<div class="blank"></div>
<div class="block clearfix">
<div class="AreaL">

<div class="box_1 clearfix">
   <div class="category_all"><div class="tit">相关分类</div></div>
  <div class="category_box">
		 <?php
		 $GLOBALS['smarty']->assign('clild_list', get_clild_list($GLOBALS['smarty']->_var['parent_id']));
		?>
		 <dl>
		 <?php $_from = $this->_var['clild_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');$this->_foreach['curn'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['curn']['total'] > 0):
    foreach ($_from AS $this->_var['childer']):
        $this->_foreach['curn']['iteration']++;
?>
		 <dd><a href="<?php echo $this->_var['childer']['url']; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a></dd>
		 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		 </dl>
		 <div class="clear"></div>
	</div>
</div>

<div class="blank5"></div>
 <div class="rank">
	<div class="category_all"><div class="tit"><?php echo $this->_var['cat_name']; ?>热销排行</div></div>
    <div class="mc">
      <ul class="tab">
        <li class="hover" id="one1" onmousemove="setTab('one',1,3)">同类别</li>
        <li id="one2" onmousemove="setTab('one',2,3)">同品牌</li>
        <li id="one3" onmousemove="setTab('one',3,3)">同价位</li>
      </ul>
      <ul class="tabcon" id="con_one_1">
        <?php
		 $GLOBALS['smarty']->assign('hot_goods', get_cat_recommend_goods('hot', get_children($GLOBALS['smarty']->_var['goods']['cat_id']), 8));
		?>
        <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_item');$this->_foreach['cat_item_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_item_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_item']):
        $this->_foreach['cat_item_goods']['iteration']++;
?>
        <li
        <?php if ($this->_foreach['cat_item_goods']['iteration'] == 1): ?>
        class='fore'
        <?php endif; ?>
        > <span<?php if ($this->_foreach['cat_item_goods']['iteration'] > 3): ?> class="bg1"<?php endif; ?>><?php echo $this->_foreach['cat_item_goods']['iteration']; ?></span>
        <div class="p-img"><a href='<?php echo $this->_var['goods_item']['url']; ?>'><img src="<?php echo $this->_var['goods_item']['thumb']; ?>" width="50" height="50" onerror="this.src='themes/360buy/images/none_50.gif'"/></a></div>
        <div class="p-name"><a href='<?php echo $this->_var['goods_item']['url']; ?>' title='<?php echo htmlspecialchars($this->_var['goods_item']['name']); ?>'><?php echo $this->_var['goods_item']['short_style_name']; ?></a></div>
        <div class="p-price"><strong>
          <?php if ($this->_var['goods_item']['promote_price'] != ""): ?>
          <?php echo $this->_var['goods_item']['promote_price']; ?>
          <?php else: ?>
          <?php echo $this->_var['goods_item']['shop_price']; ?>
          <?php endif; ?>
          </strong></div>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
      <ul class="tabcon hide" id="con_one_2">
        <?php
		 $GLOBALS['smarty']->assign('hot_goods', get_cat_recommend_goods('hot', get_children($GLOBALS['smarty']->_var['goods']['cat_id']), 8, $GLOBALS['smarty']->_var['goods']['brand_id']));

		?>
        <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_item');$this->_foreach['cat_item_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_item_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_item']):
        $this->_foreach['cat_item_goods']['iteration']++;
?>
        <li

        <?php if ($this->_foreach['cat_item_goods']['iteration'] == 1): ?>
        class='fore'
        <?php endif; ?>
        > <span<?php if ($this->_foreach['cat_item_goods']['iteration'] > 3): ?> class="bg1"<?php endif; ?>><?php echo $this->_foreach['cat_item_goods']['iteration']; ?></span>
        <div class="p-img"><a href='<?php echo $this->_var['goods_item']['url']; ?>'><img src="<?php echo $this->_var['goods_item']['thumb']; ?>" width="50" height="50" onerror="this.src='themes/360buy/images/none_50.gif'"/></a></div>
        <div class="p-name"><a href='<?php echo $this->_var['goods_item']['url']; ?>' title='<?php echo htmlspecialchars($this->_var['goods_item']['name']); ?>'><?php echo $this->_var['goods_item']['short_style_name']; ?></a></div>
        <div class="p-price"><strong>
          <?php if ($this->_var['goods_item']['promote_price'] != ""): ?>
          <?php echo $this->_var['goods_item']['promote_price']; ?>
          <?php else: ?>
          <?php echo $this->_var['goods_item']['shop_price']; ?>
          <?php endif; ?>
          </strong></div>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
      <ul class="tabcon hide" id="con_one_3">
        <?php
		 $price_arr = get_goods_min_max_price($GLOBALS['smarty']->_var['goods']['goods_id']);

		 $GLOBALS['smarty']->assign('hot_goods', get_cat_recommend_goods('hot', get_children($GLOBALS['smarty']->_var['goods']['cat_id']), 8, 0, $price_arr['min'], $price_arr['max']));

		?>
        <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_item');$this->_foreach['cat_item_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_item_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_item']):
        $this->_foreach['cat_item_goods']['iteration']++;
?>
        <li

        <?php if ($this->_foreach['cat_item_goods']['iteration'] == 1): ?>
        class='fore'
        <?php endif; ?>
        > <span<?php if ($this->_foreach['cat_item_goods']['iteration'] > 3): ?> class="bg1"<?php endif; ?>><?php echo $this->_foreach['cat_item_goods']['iteration']; ?></span>
        <div class="p-img"><a href='<?php echo $this->_var['goods_item']['url']; ?>'><img src="<?php echo $this->_var['goods_item']['thumb']; ?>" width="50" height="50" onerror="this.src='themes/360buy/images/none_50.gif'"/></a></div>
        <div class="p-name"><a href='<?php echo $this->_var['goods_item']['url']; ?>' title='<?php echo htmlspecialchars($this->_var['goods_item']['name']); ?>'><?php echo $this->_var['goods_item']['short_style_name']; ?></a></div>
        <div class="p-price"><strong>
          <?php if ($this->_var['goods_item']['promote_price'] != ""): ?>
          <?php echo $this->_var['goods_item']['promote_price']; ?>
          <?php else: ?>
          <?php echo $this->_var['goods_item']['shop_price']; ?>
          <?php endif; ?>
          </strong></div>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
    </div>
  </div>
  
  <div class="blank5"></div>
<?php echo $this->fetch('library/goods_related.lbi'); ?>
<?php echo $this->fetch('library/goods_attrlinked.lbi'); ?>

<div class="box_1 clearfix" id='history_div'>
<div class="boxc">
  <div class="category_all"><div class="tit"><?php echo $this->_var['lang']['view_history']; ?></div></div>
  <div class="boxCenterList clearfix" id='history_list'>
    <?php 
$k = array (
  'name' => 'history',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
  </div>
 </div>
</div>
<div class="blank5"></div>
<script type="text/javascript">
if (document.getElementById('history_list').innerHTML.replace(/\s/g,'').length<1)
{
    document.getElementById('history_div').style.display='none';
}
else
{
    document.getElementById('history_div').style.display='block';
}
function clear_history()
{
Ajax.call('user.php', 'act=clear_history',clear_history_Response, 'GET', 'TEXT',1,1);
}
function clear_history_Response(res)
{
document.getElementById('history_list').innerHTML = '<?php echo $this->_var['lang']['no_history']; ?>';
}
</script>
    
  </div>
  
  
  <div class="AreaR">
  <?php echo $this->fetch('library/e_zh.lbi'); ?>
   
     <div class="box">
	 <div id="innergoods">
	  <div class="h3goods">
			<div id="com_b" class="history clearfix">
				<h2>商品介绍</h2>
				<h2 class="h2bg">规格参数</h2>
				<h2 class="h2bg">商品评价</h2>
				<h2 class="h2bg">售后保障</h2>
				<?php if ($this->_var['goods_article_list']): ?><h2 class="h2bg">相关文章</h2><?php endif; ?>
				<div class="f_r lirbuy"><a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/jd2013/images/rbuy.gif" /></a></div>
			</div>
		</div>
		</div>
		<script type="text/javascript">
var obj11 = document.getElementById("innergoods");
var top11 = getTop(obj11);
var isIE6 = /msie 6/i.test(navigator.userAgent);
window.onscroll = function(){
	var bodyScrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	if (bodyScrollTop > top11){
		obj11.style.position = (isIE6) ? "absolute" : "fixed";
		obj11.style.top = (isIE6) ? bodyScrollTop + "px" : "0px";
	} else {
		obj11.style.position = "static";
	}
}
function getTop(e){
	var offset = e.offsetTop;
	if(e.offsetParent != null) offset += getTop(e.offsetParent);
	return offset;
}
</script>
      <div id="com_v" style="border-top:0;"></div>
      <div id="com_h">
       <blockquote>
	   	<ul class="detail-list">
					<li title="<?php echo $this->_var['goods']['goods_style_name']; ?>">商品名称：<?php echo $this->_var['goods']['goods_style_name']; ?></li>
					<li>商品编号：<?php echo $this->_var['goods']['goods_sn']; ?></li>
					<li>品牌：<a href="<?php echo $this->_var['goods']['goods_brand_url']; ?>" target="_blank"><?php echo $this->_var['goods']['goods_brand']; ?></a></li>
					<li>上架时间：<?php echo $this->_var['goods']['add_time']; ?></li>
					<li>商品毛重：<?php echo $this->_var['goods']['goods_weight']; ?></li>
		 <?php $_from = $this->_var['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'property_group');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['property_group']):
?>
        <?php $_from = $this->_var['property_group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'property');$this->_foreach['curn'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['curn']['total'] > 0):
    foreach ($_from AS $this->_var['property']):
        $this->_foreach['curn']['iteration']++;
?>
		 <?php if ($this->_foreach['curn']['iteration'] < 11): ?>
				<li><?php echo htmlspecialchars($this->_var['property']['name']); ?>：<?php echo $this->_var['property']['value']; ?></li>
		<?php endif; ?>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
				<div class="detail-correction">

<style>
li{
	list-style:none;
}
#mhFaultAll,.subMhF,#mhFaultDetail,.subMhFdT,.topName{
	width:100%;
	position:relative;
	background:rgb(244,250,251);
	border:1px solid rgb(187,221,229);
}
.topName{
	line-height:36px;
	font-weight:bold;
	padding-left:20px;
}
#mhFaultDetail{
	padding:5px;
	margin-top:10px;
}
.subMhF,.subMhFD{
	width:92%;
}
.subMhFdT{
	width:100%;

}
.subMhFdT td,.subMhFdT th{
		border:1px solid rgb(187,221,229);
}
.subMhFdT th{
	font-weight:bold;
	text-align:center;
}
.subMhFdT input{
	width:100px;
}
.mhFault,.subMhFault,.mhFaultD,.subMhFaultD{
	position:relative;
	line-height:20px;
	padding:0px 3px;
	margin-left:20px;
	background:rgb(221,238,242);
	border:1px solid rgb(187,221,229);
	margin:5px;
	cursor:pointer;
	font-weight:900;
	height:20px;
}
.mhFault,.mhFaultD{
	text-align:center;
	width:200px;
}
.subMhFault,.subMhFaultD{
	float:left;
	font-weight:400;
}
.clear{
	clear:both;
}
</style>
<table id="mhFaultDetail">
<tr><td class="topName" id="topNameTitle" colspan="4" ><?php echo $this->_var['goods']['goods_style_name']; ?></td></tr>
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
					<td  class="matePrice"><?php echo $this->_var['subMhFault']['matePrice']; ?></td>
					<td  class="timePrice"><?php echo $this->_var['subMhFault']['timePrice']; ?></td>
					<td  class="materialsPrice"><?php echo $this->_var['subMhFault']['materialsPrice']; ?></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
		</td>
	</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<tr class="mhFD">
		<td class="mhFaultD">合计</td>
		<td  class="subMhFd">
			<table class="subMhFdT"><tr>
				<td width="30%">总计：￥<?php echo $this->_var['goods']['shop_price']; ?>元</td>
				<td class="matePrice">￥ <?php echo $this->_var['goods']['matePriceNum']; ?> 元</td>
				<td class="timePrice">￥ <?php echo $this->_var['goods']['timePriceNum']; ?> 元</td>
				<td class="materialsPrice">￥ <?php echo $this->_var['goods']['materialsPriceNum']; ?> 元</td>
			</tr></table>
		</td>
	</tr>
</table>
<script type="text/javascript">
var mate='<?php echo $this->_var['goods']['matePrice']; ?>';
var time='<?php echo $this->_var['goods']['timePrice']; ?>';
var materials='<?php echo $this->_var['goods']['materialsPrice']; ?>';
 mate=mate.split(",");
 time=time.split(",");
 materials=materials.split(",");

for(i in mate){
	$(".matePrice").eq(i).html(mate[i]);
	$(".timePrice").eq(i).html(time[i]);
	$(".materialsPrice").eq(i).html(materials[i]);
}

</script>

				</div>
        <?php echo $this->_var['goods']['goods_desc']; ?>
       </blockquote>

	    <blockquote>
 <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd">
        <?php $_from = $this->_var['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'property_group');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['property_group']):
?>
        <tr>
          <th colspan="2" bgcolor="#FFFFFF"><?php echo htmlspecialchars($this->_var['key']); ?></th>
        </tr>
        <?php $_from = $this->_var['property_group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'property');if (count($_from)):
    foreach ($_from AS $this->_var['property']):
?>
        <tr>
          <td bgcolor="#FFFFFF" align="left" width="30%" class="f1">[<?php echo htmlspecialchars($this->_var['property']['name']); ?>]</td>
          <td bgcolor="#FFFFFF" align="left" width="70%"><?php echo $this->_var['property']['value']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </table>
       </blockquote>

     <blockquote>
	 <div class="blank"></div>
     <?php echo $this->fetch('library/comments.lbi'); ?>
     </blockquote>

     <blockquote>

     </blockquote>

	 <?php if ($this->_var['goods_article_list']): ?>
     <blockquote>
     <ul class="news2">
      <?php $_from = $this->_var['goods_article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
      <li> <a href="<?php echo $this->_var['article']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['article']['title']); ?>"> <?php echo htmlspecialchars($this->_var['article']['short_title']); ?></a></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </ul>
         <div class="blank5"></div>
     </blockquote>
	 <?php endif; ?>

      </div>
    </div>
    <script type="text/javascript">
    <!--
    reg("com");
    //-->
    </script>
  <div class="blank"></div>
  
<?php echo $this->fetch('library/bought_note_guide.lbi'); ?>

 <?php echo $this->fetch('library/zxcomments.lbi'); ?>

</div>
</div>
</div>
<div class="blank"></div>
<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var goods_id = <?php echo $this->_var['goods_id']; ?>;
var goodsattr_style = <?php echo empty($this->_var['cfg']['goodsattr_style']) ? '1' : $this->_var['cfg']['goodsattr_style']; ?>;
var gmt_end_time = <?php echo empty($this->_var['promote_end_time']) ? '0' : $this->_var['promote_end_time']; ?>;
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var goodsId = <?php echo $this->_var['goods_id']; ?>;
var now_time = <?php echo $this->_var['now_time']; ?>;


onload = function(){
  changePrice();
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
}

/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice()
{
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;

  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
}

/**
 * 接收返回的信息
 */
function changePriceResponse(res)
{
  if (res.err_msg.length > 0)
  {
    alert(res.err_msg);
  }
  else
  {
    document.forms['ECS_FORMBUY'].elements['number'].value = res.qty;

    if (document.getElementById('ECS_GOODS_AMOUNT'))
      document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;
  }
}

/*
*选择信息处理
*/
function changeP(b, c) {
	var frm=document.forms['ECS_FORMBUY'];
	var cur_id="";
    document.getElementById('spec_value_' + c).checked=true;
	document.getElementById('url_' + c).className="selected";
	for (var i = 0; i < frm.elements[b].length; i++) {
		cur_id=frm.elements[b][i].id.substr(11);
        document.getElementById('url_' + cur_id).className="";
		if (frm.elements[b][i].checked)
		{
		   document.getElementById('url_' + c).className="selected";
		}
    }
	changePrice();
}
//
var btn_buy = "购买";
var is_cancel = "取消";
var select_spe = "请选择商品属性";
</script>
</html>
