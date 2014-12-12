<?php 
   require_once("themes/".$GLOBALS['_CFG']['template']."/diyfile.php");
   $this->assign('TemplatePath','themes/'.$GLOBALS['_CFG']['template']);
?>
<script type="text/javascript">
var isWidescreen=screen.width>=1280;
if (isWidescreen){document.getElementsByTagName("body")[0].className="w1210";}
</script>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div id="shortcut-2013">
	<div class="w">
		<ul class="fl lh">
			<li class="fore1 ld"><b></b><a href="javascript:addToFavorite()" rel="nofollow">收藏猛虎</a>
			</li>
		</ul>
		<ul class="fr lh">
		   <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
			<li class="fore1"><span id="ECS_MEMBERZONE"><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span></li>
			<li class="fore2 ld">
				<s></s>
				<a href="user.php?act=order_list" rel="nofollow">我的订单</a>
			</li>
			<li class="fore3 ld">
				<s></s>
				<a href="#" target="_blank">手机猛虎</a>
			</li>
			<li class="fore4 ld menu" id="biz-service" onMouseOver="this.className='fore4 ld menu hover'" onMouseOut="this.className='fore4 ld menu'">
				<s></s>
				<span class="outline"></span>
				<span class="blank"></span>
				客户服务
				<b></b>
				<div class="dd">
					<div><a href="#" target="_blank">常见问题</a></div>
					<div><a href="#" target="_blank" rel="nofollow">售后服务</a></div>
					<div><a href="#" target="_blank" rel="nofollow">在线客服</a></div>
					<div><a href="#" target="_blank" rel="nofollow">投诉中心</a></div>
					<div><a href="#" target="_blank">客服邮箱</a></div>
				</div>
			</li>
			<!--li class="fore5 ld menu" id="site-nav" onMouseOver="this.className='fore5 ld menu hover'" onMouseOut="this.className='fore5 ld menu'">
				<s></s>
				<span class="outline"></span>
				<span class="blank"></span>
				网站导航
				<b></b>
				<div class="dd lh">
					<dl class="item fore1">
						<dt>特色栏目</dt>
						<dd>
							<div><a target="_blank" href="#">为我推荐</a></div>
							<div><a target="_blank" href="#">视频购物</a></div>
							<div><a target="_blank" href="#">猛虎社区</a></div>
							<div><a target="_blank" href="#">校园频道</a></div>
							<div><a target="_blank" href="#">在线读书</a></div>
							<div><a target="_blank" href="#">装机大师</a></div>
							<div><a target="_blank" href="#">礼品卡</a></div>
						</dd>
					</dl>
					<dl class="item fore2">
						<dt>企业服务</dt>
						<dd>
							<div><a target="_blank" href="#">企业客户</a></div>
							<div><a target="_blank" href="#">办公直通车</a></div>
						</dd>
					</dl>
					<dl class="item fore3">
						<dt>旗下网站</dt>
						<dd>
							<div><a target="_blank" href="#">360TOP</a></div>
							<div><a target="_blank" href="#">迷你挑</a></div>
							<div><a target="_blank" href="#">English Site</a></div>
						</dd>
					</dl>
				</div>
			</li-->
		</ul>
		<span class="clr"></span>
	</div>
</div>
<div id="o-header-2013">
	<div class="w" id="header-2013">
		<div id="logo-2013" class="ld"><a href="index.php"><b></b><img src="themes/jd2013/images/logo.gif" height="70px"></a></div>
		<div id="search-2013">
			<div class="i-search ld">
				<ul id="shelper" class="hide">
				</ul>
				<div class="form">
				<form id=searchForm name=searchForm onSubmit="return checkSearchForm()" action="search.php" method=get>
					<input type="text" class="text" accesskey="s" id="key" name="keywords" autocomplete="off" onkeydown="javascript:if(event.keyCode==13) search('key');">
					<input type="submit" value="搜索" class="button">
					</form>
				</div>
			</div>
			<!--div id="hotwords"><strong>热门搜索：</strong><?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?><a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>"><?php echo $this->_var['val']; ?></a><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></div-->
		</div>
		
		<div id="my360buy-2013">
			<dl onMouseOver="this.className='hover'" onMouseOut="this.className=''">
				<dt class="ld"><s></s><a href="user.php">会员中心</a><b></b></dt>
				<dd>
				<div class="prompt">	
				<span class="fl"><?php 
$k = array (
  'name' => 'member_info1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>	
				<span class="fr"></span>
				</div>
				<div class="uclist">
				<ul class="fore1 fl">	
				<li><a target="_blank" href="#">待处理订单<span id="num-unfinishedorder"></span></a></li>
				<li><a target="_blank" href="#">咨询回复<span id="num-consultation"></span></a></li>					
				<li><a target="_blank" href="#">降价商品<span id="num-reduction"></span></a></li>					
				<li><a target="_blank" href="#">优惠券<span id="num-ticket"></span></a></li>				
				</ul>				
				<ul class="fore2 fl">					
				<li><a target="_blank" href="#">我的订单&nbsp;&gt;</a></li>					
				<li><a target="_blank" href="#">我的关注&nbsp;&gt;</a></li>					
				<li><a target="_blank" href="#">我的积分&nbsp;&gt;</a></li>					
				<li><a target="_blank" href="#">为我推荐&nbsp;&gt;</a></li>				
				</ul>			
				</div>
				<div class="viewlist">	
				<div class="smt">
				<h4>最近浏览的商品：</h4>
				<div style="float:right;padding-right:9px;"><a style="border:0;color:#005EA7" onclick="clear_history()" target="_blank">清空浏览历史&nbsp;&gt;</a></div>				</div>			<div class="smc" id="jduc-viewlist">					
				<div style="display: none;" class="loading-style1"><b></b>加载中，请稍候...</div>					
				<ul style="display: block;" class="lh hide" id='history_div'>
				 <div class="clearfix" id='history_list'>
    <?php 
$k = array (
  'name' => 'history1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
  </div>
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
				</ul>				
				</div>			
				</dd>
			</dl>
		</div>
		
		<div id="settleup-2013">
			<dl id="ECS_CARTINFO" onMouseOver="this.className='hover'" onMouseOut="this.className=''">
				<?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
			</dl>
		</div>
		
	</div>
	
	<div class="blank"></div>
	<div class="w">
		<div id="nav-2013">
			<div id="categorys-2013">
			 <div onmouseover="this.className='allsorthover'" onmouseout="this.className=''">
				<div class="mt ld"><h2 class="bgr"><a href="catalog.php">全部商品分类<b></b></a></h2></div>
			<div class="mceu lynone">   
			<?php $this->assign('categories', get_categories_tree());?>
			 <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['cur'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cur']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['cur']['iteration']++;
?>
          <?php if ($this->_foreach['cur']['iteration'] < 14): ?>      
			<div class="item<?php if ($this->_foreach['cur']['iteration'] == 1): ?> fore<?php endif; ?>" onMouseOver="this.className='item<?php if ($this->_foreach['cur']['iteration'] == 1): ?> fore<?php endif; ?> hover'" onMouseOut="this.className='item<?php if ($this->_foreach['cur']['iteration'] == 1): ?> fore<?php endif; ?>'"> 
			<span><h3><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></h3><s></s></span>          
			 <div class="i-mc">                            
			 <div class="subitem"> 
			  <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['childcur'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['childcur']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['childcur']['iteration']++;
?>           
			       <dl class="fore1">             
				     <dt> <a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></dt>                    
					     <dd>
						 <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?>
						 <em><a href="<?php echo $this->_var['childer']['url']; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a></em>
						 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						 </dd>                  
					  </dl> 
					 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>   	                  
				
				</div>   
				    <div class="cat-right-con fr">      
					  <dl class="categorys-promotions">           
					   <dt>促销活动</dt>          
					     <dd>               
						  <ul>                  
						    <li>
							 <?php $this->assign('cate1',get_adv('菜单_分类图片1',$this->_var['cat'][id]));?>
							 <?php echo $this->_var['cate1']; ?>
							</li>
							<li>
							 <?php $this->assign('cate2',get_adv('菜单_分类图片2',$this->_var['cat'][id]));?>
							 <?php echo $this->_var['cate2']; ?>
							</li>              
					  </ul> 
					  </dd> 
					 </dl>
					<dl class="categorys-brands">               
				 <dt>推荐品牌出版商</dt>          
				   <dd>              
				     <ul>                   
					   <?php $this->assign('brand_nav', get_brands($GLOBALS['smarty']->_var['cat']['id']));?>
                    <?php $_from = $this->_var['brand_nav']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brandnav');$this->_foreach['brand_foreach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brand_foreach']['total'] > 0):
    foreach ($_from AS $this->_var['brandnav']):
        $this->_foreach['brand_foreach']['iteration']++;
?>
                    <?php if (($this->_foreach['brand_foreach']['iteration'] - 1) < 15): ?>
                    <li><a href="<?php echo $this->_var['brandnav']['url']; ?>"><?php echo htmlspecialchars($this->_var['brandnav']['brand_name']); ?></a></li> 
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	   
					   </ul>   
				 </dd>       
				  </dl>
				
				</div> 
				</div>
				</div>    
			  <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			</div>
			</div>
			<!--广告a style="float:right;width:141px;height:40px;background:url(themes/jd2013/images/jd2013/rad.jpg) no-repeat 0 0;" href="#" target="_blank" title="">&nbsp;</a-->
				<ul id="navitems-2013">
					<li<?php if ($this->_var['navigator_list']['config']['index'] == 1): ?> class="curr"<?php endif; ?>><a href="index.php"><?php echo $this->_var['lang']['home']; ?></a></li>
					<?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
					  <li <?php if ($this->_var['nav']['active'] == 1): ?> class="curr"<?php endif; ?>><a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank"<?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></li>
					 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
		</div>
	</div>
</div>
