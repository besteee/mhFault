<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
define('IN_ECS', true);
define('ECS_ADMIN', true);
require(dirname(dirname(dirname(__FILE__))) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');
/* 支付方式代码 */
$pay_code = 'alipaywap';

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$result = $_GET['result'];


    /**
     * 响应操作
     */
    function respond()
    {
        if (!empty($_POST))
        {
            foreach($_POST as $key => $data)
            {
                $_GET[$key] = $data;
            }
        }
        $payment  = 'alipaywap';
        $order_sn = trim($_GET['out_trade_no']);


		
        $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('order_info') ." WHERE order_sn = '$order_sn'";
        $order    = $GLOBALS['db']->getRow($sql);
        $order_id = $order['order_id'];
		
        $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('pay_log') ." WHERE order_id = '$order_id'";
        $pay_log    = $GLOBALS['db']->getRow($sql);
        $log_id = $pay_log['log_id'];
		
		
		if ($_GET['result'] == 'success')
        {
            /* 改变订单状态 */
            order_paid($log_id, 2);

            return true;
        }
        else
        {
            return false;
        }
    }
	//判断该笔订单是否在商户网站中已经做过处理
		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		//如果有做过处理，不执行商户的业务程序

		$plugin_file = ROOT_PATH . 'includes/modules/payment/' . $pay_code . '.php';
		/* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
		if (file_exists($plugin_file))
		{
			/* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
			include_once($plugin_file);

			$payment = new $pay_code();
			$msg = (respond()) ? "<br><br>支付成功，我们将尽快为您发货。<br><br><a href=../user.php?act=order_list class=red>【返回我的订单】</a><br><br>" : "<br><br>本次支付失败，请及时和我们<a href=kefu.php>【取得联系】</a>。<br><br><a href=../user.php?act=order_list class=red>【返回我的订单】</a><br><br>";
		}
		else
		{
			$msg = "选用的支付方式不存在。";
		}

		
	echo $msg;

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "<br><br>支付失败，请及时<a href=kefu.php>【取得联系】</a>。<br><br><a href=user.php?act=order_list class=red>【返回我的订单】</a><br><br>";
}
?>
        <title>系统提示</title>
	</head>
    <body>
    </body>
</html>