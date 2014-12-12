<div id="append_parent"></div>
<?php if ($this->_var['user_info']): ?>
<?php echo $this->_var['lang']['hello']; ?>，<font class="f1"><?php echo $this->_var['user_info']['username']; ?></font>，<?php echo $this->_var['lang']['welcome_return']; ?>！
<a href="user.php"><?php echo $this->_var['lang']['user_center']; ?></a>|
 <a href="user.php?act=logout"><?php echo $this->_var['lang']['user_logout']; ?></a>
<?php else: ?>
 您好，请<a href="user.php">登录</a>，&nbsp;<a href="user.php?act=register">免费注册</a>
<?php endif; ?>
