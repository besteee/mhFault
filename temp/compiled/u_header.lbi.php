<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div id="shortcut-2013">
	<div class="w">
		<ul class="fl lh">
			<li class="fore1 ld"><b></b><a href="javascript:addToFavorite()" rel="nofollow">收藏京东</a>
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
			<li class="fore5 ld menu" id="site-nav" onMouseOver="this.className='fore5 ld menu hover'" onMouseOut="this.className='fore5 ld menu'">
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
							<div><a target="_blank" href="#">京东社区</a></div>
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
			</li>
		</ul>
		<span class="clr"></span>
	</div>
</div>

