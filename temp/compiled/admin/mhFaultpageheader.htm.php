<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_var['lang']['cp_home']; ?><?php if ($this->_var['ur_here']): ?> - <?php echo $this->_var['ur_here']; ?> <?php endif; ?></title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles/general.css" rel="stylesheet" type="text/css" />
<link href="styles/main.css" rel="stylesheet" type="text/css" />
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
	padding:5px 10%;
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

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/jquery-1.11.0.min.js')); ?>
<script language="JavaScript">
<!--
// 这里把JS用到的所有语言都赋值到这里
<?php $_from = $this->_var['lang']['js_languages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
//-->
</script>
</head>
<body>

<h1>
<?php if ($this->_var['action_link']): ?>
<span class="action-span"><a href="<?php echo $this->_var['action_link']['href']; ?>"><?php echo $this->_var['action_link']['text']; ?></a></span>
<?php endif; ?>
<?php if ($this->_var['action_link2']): ?>
<span class="action-span"><a href="<?php echo $this->_var['action_link2']['href']; ?>"><?php echo $this->_var['action_link2']['text']; ?></a>&nbsp;&nbsp;</span>
<?php endif; ?>
<span class="action-span1"><a href="index.php?act=main"><?php echo $this->_var['lang']['cp_home']; ?></a> </span><span id="search_id" class="action-span1"><?php if ($this->_var['ur_here']): ?> - <?php echo $this->_var['ur_here']; ?> <?php endif; ?></span><span id="search_id" class="action-span1"> - 
 </span>
<div style="clear:both"></div>
</h1>
