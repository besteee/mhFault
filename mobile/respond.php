<?php

define('IN_ECS', true);
define('ECS_ADMIN', true);
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);

}
/* 支付方式代码 */
$pay_code = !empty($_REQUEST['code']) ? trim($_REQUEST['code']) : '';

//获取首信支付方式
if (empty($pay_code) && !empty($_REQUEST['v_pmode']) && !empty($_REQUEST['v_pstring']))
{
	$pay_code = 'cappay';
}

//获取快钱神州行支付方式
if (empty($pay_code) && ($_REQUEST['ext1'] == 'shenzhou') && ($_REQUEST['ext2'] == 'ecshop'))
{
	$pay_code = 'shenzhou';
}

/* 参数是否为空 */
if (empty($pay_code))
{
	$msg = "选用的支付方式不存在。";
}
else
{
	/* 检查code里面有没有问号 */
	if (strpos($pay_code, '?') !== false)
	{
		$arr1 = explode('?', $pay_code);
		$arr2 = explode('=', $arr1[1]);

		$_REQUEST['code'] = $arr1[0];
		$_REQUEST[$arr2[0]] = $arr2[1];
		$_GET['code'] = $arr1[0];
		$_GET[$arr2[0]] = $arr2[1];
		$pay_code = $arr1[0];
	}

	/* 判断是否启用 */
	$sql = "SELECT COUNT(*) FROM " . $ecs->table('payment') . " WHERE pay_code = '$pay_code' AND enabled = 1";
	if ($db->getOne($sql) == 0)
	{
		$msg = "您选用的支付方式已经被停用。";
	}
	else
	{
		$plugin_file = ROOT_PATH . 'includes/modules/payment/' . $pay_code . '.php';
		/* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
		if (file_exists($plugin_file))
		{
			/* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
			include_once($plugin_file);

			$payment = new $pay_code();
			$msg = (@$payment->respond()) ? "<br><br>您此次的支付操作已成功！<br><br><a href=user.php?act=user_center class=red>【返回用户中心】</a><br><br>" : "<br><br>支付操作失败，请返回重试！或者请及时和我们<a href=kefu.php>【取得联系】</a>。<br><br><a href=user.php?act=user_center class=red>【返回用户中心】</a><br><br>";
		}
		else
		{
			$msg = "选用的支付方式不存在。";
		}
	}
}

$smarty->assign('message', $msg);
$smarty->display('respond.dwt');

?>