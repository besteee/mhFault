<div class="w" >
	<div id="service-2013" class="clearfix">
	   <?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['curn'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['curn']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['curn']['iteration']++;
?>
		<dl class="fore<?php echo $this->_foreach['curn']['iteration']; ?>">
			<dt><b></b><strong><?php echo $this->_var['help_cat']['cat_name']; ?></strong></dt>
			<dd>
                      <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_0_56791900_1418266297');if (count($_from)):
    foreach ($_from AS $this->_var['item_0_56791900_1418266297']):
?>
                       <div><a href="<?php echo $this->_var['item_0_56791900_1418266297']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['item_0_56791900_1418266297']['title']); ?>"><?php echo $this->_var['item_0_56791900_1418266297']['short_title']; ?></a></div>
                     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</dd>
		</dl>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		<dl class="fore4" style="width:200px;">
			<dt><b></b><strong>联系我们</strong></dt>
			<dd>
                                             <div><p style="font-size:20px;font-weight:bold; line-height:30px;">400-886-0577
					          <p>(售后专线：023-61978128)<br>
						  <p style="font-size:12px;">服务时间：周一到周日09:00-22:00  </div>
                     			</dd>
		</dl>

		<div class="fr"><div class="sm" id="branch-office">
	<div class="smt">
		<h3>猛虎自营覆盖区县</h3>
	</div>
	<div class="smc">
		<p>猛虎已向全国1000个区县提供自营配送服务，支持货到付款、POS机刷卡和售后上门服务。</p>
		<p class="ar"><a href="#" target="_blank">查看详情&nbsp;></a></p>
	</div>
</div>
</div>
		<span class="clr"></span>
	</div>
</div>
<div class="w" style="text-align:center;"><img src="themes/jd2013/images/foot_ourAdvantage.jpg"></div>
<div class="w">
	<div id="footer-2013">
		<div class="links">  <?php if ($this->_var['navigator_list']['bottom']): ?>
               <?php $_from = $this->_var['navigator_list']['bottom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_0_56823100_1418266297');$this->_foreach['nav_bottom_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_bottom_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav_0_56823100_1418266297']):
        $this->_foreach['nav_bottom_list']['iteration']++;
?>
                   <a href="<?php echo $this->_var['nav_0_56823100_1418266297']['url']; ?>" <?php if ($this->_var['nav_0_56823100_1418266297']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav_0_56823100_1418266297']['name']; ?></a>
                    <?php if (! ($this->_foreach['nav_bottom_list']['iteration'] == $this->_foreach['nav_bottom_list']['total'])): ?>
                       |
                    <?php endif; ?>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              <?php endif; ?></div>
		<div class="copyright"> <?php echo $this->_var['copyright']; ?><br />
 <?php echo $this->_var['shop_address']; ?> <?php echo $this->_var['shop_postcode']; ?>
 <?php if ($this->_var['service_phone']): ?>
      Tel: <?php echo $this->_var['service_phone']; ?>
 <?php endif; ?>
 <?php if ($this->_var['service_email']): ?>
      E-mail: <?php echo $this->_var['service_email']; ?><br />
 <?php endif; ?> <?php if ($this->_var['icp_number']): ?>
		        <a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $this->_var['icp_number']; ?></a>
                <?php endif; ?> <?php if ($this->_var['stats_code']): ?><?php echo $this->_var['stats_code']; ?><?php endif; ?></div>
		 <div class="authentication"><a href="#" target="_blank"><img src="themes/jd2013/images/footer_1.gif"></a> <a href="#" target="_blank"><img src="themes/jd2013/images/footer_2.jpg"></a> <a href="#" target="_blank"><img src="themes/jd2013/images/footer_3.jpg"></a> <a href="#" target="_blank"><img src="themes/jd2013/images/footer_4.gif"></a></div>
	</div>
</div>
