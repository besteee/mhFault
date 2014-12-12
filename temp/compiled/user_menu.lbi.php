<div id="myjd">	
<div class="mt">		
<h2><a href="user.php">会员中心</a></h2>	</div>	
	<div class="mc">
		<dl>
			<dt>故障诊断</dt>
			<dd>
				<div class="item"><a href="user.php?act=faultDiy">套餐定制</a></div>
			</dd>
		</dl>
		<dl>		
			<dt>订单中心<b></b></dt>		
				<dd>				
				<div class="item<?php if ($this->_var['action'] == 'order_list'): ?> curr<?php endif; ?>"><a rel="nofollow" href="user.php?act=order_list"><?php echo $this->_var['lang']['label_order']; ?></a><img src="themes/jd2013/images/icon_new.png" style="position:absolute;margin-top:2px;margin-left:3px"></div>
				<div class="item<?php if ($this->_var['action'] == 'address_list'): ?> curr<?php endif; ?>"><a href="user.php?act=address_list"}><?php echo $this->_var['lang']['label_address']; ?></a></div>
				<div class="item<?php if ($this->_var['action'] == 'track_packages'): ?> curr<?php endif; ?>"><a href="user.php?act=track_packages"><?php echo $this->_var['lang']['label_track_packages']; ?></a></div>
				<div class="item<?php if ($this->_var['action'] == 'collection_list'): ?> curr<?php endif; ?>"><a href="user.php?act=collection_list"><?php echo $this->_var['lang']['label_collection']; ?></a></div>
				<div class="item<?php if ($this->_var['action'] == 'comment_list'): ?> curr<?php endif; ?>"><a href="user.php?act=comment_list"><?php echo $this->_var['lang']['label_comment']; ?></a></div>	
				<div class="item<?php if ($this->_var['action'] == 'booking_list'): ?> curr<?php endif; ?>"><a href="user.php?act=booking_list"><?php echo $this->_var['lang']['label_booking']; ?></a></div>
				</dd>
		</dl>	
		
			<dl>		
			<dt>会员信息<b></b></dt>		
				<dd>				
				<div class="item <?php if ($this->_var['action'] == 'message_list'): ?> curr<?php endif; ?>"><a href="user.php?act=message_list"><?php echo $this->_var['lang']['label_message']; ?></a></div>
					  <div class="item <?php if ($this->_var['action'] == 'tag_list'): ?> curr<?php endif; ?>"><a href="user.php?act=tag_list"><?php echo $this->_var['lang']['label_tag']; ?></a></div>
					  <div class="item <?php if ($this->_var['action'] == 'account_log'): ?> curr<?php endif; ?>"><a href="user.php?act=account_log"><?php echo $this->_var['lang']['label_user_surplus']; ?></a></div>
					  <?php if ($this->_var['show_transform_points']): ?>
					  <div class="item <?php if ($this->_var['action'] == 'transform_points'): ?> curr<?php endif; ?>"><a href="user.php?act=transform_points"><?php echo $this->_var['lang']['label_transform_points']; ?></a></div>
					  <?php endif; ?>					
					  <div class="item <?php if ($this->_var['action'] == 'bonus'): ?> curr<?php endif; ?>"><a href="user.php?act=bonus">我的代金券</a></div>
				<?php if ($this->_var['affiliate']['on'] == 1): ?><div class="item <?php if ($this->_var['action'] == 'affiliate'): ?> curr<?php endif; ?>"><a href="user.php?act=affiliate"><?php echo $this->_var['lang']['label_affiliate']; ?></a></div><?php endif; ?>
			</dd>
		</dl>	
		
		<dl>		
			<dt>帐户中心<b></b></dt>		
				<dd>				
				  <div class="item <?php if ($this->_var['action'] == 'default'): ?> curr<?php endif; ?>"><a href="user.php?act=default"><?php echo $this->_var['lang']['label_welcome']; ?></a></div>
			 	 <div class="item <?php if ($this->_var['action'] == 'profile'): ?> curr<?php endif; ?>"><a href="user.php?act=profile"><?php echo $this->_var['lang']['label_profile']; ?></a></div>
			</dd>
		</dl>	
			
				
			</div>
			</div>
			<div class="blank"></div>
			