<?php

/**
 * ECSHOP 商品页
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: order.php 15013 2008-10-23 09:31:42Z liuhui $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');
require(ROOT_PATH . 'includes/lib_payment.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/common.php');

$flow_type = 0;
$_LANG['gram'] = '克';
$_LANG['kilogram'] = '千克';
$tips = '订单提交成功！';

if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);
}

if($_REQUEST['act'] == 'order_lise')
{
	if($_POST['isinput']==1 || empty($_POST['address_id'])){
		//19:21 2013-7-16
		$_POST['country'] = 1;//默认国家
		if(empty($_POST['province']) || empty($_POST['city'])){
			echo '配送区域不可为空！';
			exit;
		}
		if(empty($_POST['consignee']))
		{
			echo '收货人姓名不可为空！';
			exit;
		}
		if(empty($_POST['address']))
		{
			echo '详细地址不可为空！';
			exit;
		}
		if(empty($_POST['tel']))
		{
			echo '电话不可为空！';
			exit;
		}
		if(empty($_POST['email']))
		{
			echo '电子邮箱不可为空！';
			exit;
		}
		/*
		 * 保存收货人信息
		 */
		$consignee = array(
			'address_id'	=> empty($_POST['address_id']) ? 0  : intval($_POST['address_id']),
			'consignee'	 => empty($_POST['consignee'])  ? '' : compile_str(trim($_POST['consignee'])),
			'country'	   => empty($_POST['country'])	? '' : intval($_POST['country']),
			'province'	  => empty($_POST['province'])   ? '' : intval($_POST['province']),
			'city'		  => empty($_POST['city'])	   ? '' : intval($_POST['city']),
			'district'	  => empty($_POST['district'])   ? '' : intval($_POST['district']),
			'email'		 => empty($_POST['email'])	  ? '' : compile_str($_POST['email']),
			'address'	   => empty($_POST['address'])	? '' : compile_str($_POST['address']),
			'zipcode'	   => empty($_POST['zipcode'])	? '' : compile_str(make_semiangle(trim($_POST['zipcode']))),
			'tel'		   => empty($_POST['tel'])		? '' : compile_str(make_semiangle(trim($_POST['tel']))),
			'mobile'		=> empty($_POST['mobile'])	 ? '' : compile_str(make_semiangle(trim($_POST['mobile']))),
			'sign_building' => empty($_POST['sign_building']) ? '' : compile_str($_POST['sign_building']),
			'best_time'	 => empty($_POST['best_time'])  ? '' : compile_str($_POST['best_time']),
		);

		if ($_SESSION['user_id'] > 0)
		{
			include_once(ROOT_PATH . 'includes/lib_transaction.php');

			/* 如果用户已经登录，则保存收货人信息 */
			$consignee['user_id'] = $_SESSION['user_id'];
			save_consignee($consignee, true);
		}
	}else{
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('user_address') . " WHERE user_id = '$_SESSION[user_id]' AND address_id = '$_POST[address_id]'";
		$consignee = $db->getRow($sql);
	}
	
	/* 保存到session */
	$_SESSION['flow_consignee'] = stripslashes_deep($consignee);

	/* 检查购物车中是否有商品 */
	$sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') .
		" WHERE session_id = '" . SESS_ID . "' " .
		"AND parent_id = 0 AND is_gift = 0 AND rec_type = '$flow_type'";

	if ($db->getOne($sql) == 0)
	{
		$tips = '您的购物车中没有商品';
	}

	$consignee = get_consignee($_SESSION['user_id']);
	
	//14:07 2013-07-17
	$where = "1";
	if($consignee['city']){
		$where = " region_id = '$consignee[city]'";
	}
	if($consignee['district']){
		$where .= " OR region_id = '$consignee[district]'";
	}
	$sql = 'SELECT region_name FROM ' . $GLOBALS['ecs']->table('region') . " WHERE ".$where;
	$rnarr = $db->GetAll($sql);
	@$consignee['address'] = $rnarr[0]['region_name'].' '.$rnarr[1]['region_name'].' '.$consignee['address'];
	//end
	
	$_SESSION['flow_consignee'] = $consignee;
	$smarty->assign('consignee', $consignee);

	/* 对商品信息赋值 */
	$cart_goods_list = cart_goods_list($flow_type); // 取得商品列表，计算合计
	$smarty->assign('goods_list', $cart_goods_list);
	/*
	 * 取得订单信息
	 */
	$order = flow_order_info();
	$smarty->assign('order', $order);

	$_LANG['shopping_money'] = '购物金额小计 %s';
	$_LANG['than_market_price'] = '比市场价 %s 节省了 %s (%s)';
	/*
	 * 计算订单的费用
	 */
	$total = order_fee($order, $cart_goods_list, $consignee);
	$smarty->assign('total', $total);
	$smarty->assign('shopping_money', sprintf($_LANG['shopping_money'], $total['formated_goods_price']));
	$smarty->assign('market_price_desc', sprintf($_LANG['than_market_price'], $total['formated_market_price'], $total['formated_saving'], $total['save_rate']));

	/* 取得配送列表 */
	$region			= array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']);
	$shipping_list	 = available_shipping_list($region);
	$cart_weight_price = cart_weight_price($flow_type);
	$insure_disabled   = true;
	$cod_disabled	  = true;

	// 查看购物车中是否全为免运费商品，若是则把运费赋为零
	$sql = 'SELECT count(*) FROM ' . $ecs->table('cart') . " WHERE `session_id` = '" . SESS_ID. "' AND `extension_code` != 'package_buy' AND `is_shipping` = 0";
	$shipping_count = $db->getOne($sql);

	foreach ($shipping_list AS $key => $val)
	{
		$shipping_cfg = unserialize_config($val['configure']);
		$shipping_fee = ($shipping_count == 0 AND $cart_weight_price['free_shipping'] == 1) ? 0 : shipping_fee($val['shipping_code'], unserialize($val['configure']),
		$cart_weight_price['weight'], $cart_weight_price['amount'], $cart_weight_price['number']);

		$shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee, false);
		$shipping_list[$key]['shipping_fee']		= $shipping_fee;
		$shipping_list[$key]['free_money']		  = price_format($shipping_cfg['free_money'], false);
		$shipping_list[$key]['insure_formated']	 = strpos($val['insure'], '%') === false ?
			price_format($val['insure'], false) : $val['insure'];

	}

	$smarty->assign('shipping_list',   $shipping_list);
	$smarty->assign('insure_disabled', $insure_disabled);
	$smarty->assign('cod_disabled',	$cod_disabled);
	
		/* 取得支付列表 */
	if ($order['shipping_id'] == 0)
	{
		$cod		= true;
		$cod_fee	= 0;
	}
	else
	{
		$shipping = shipping_info($order['shipping_id']);
		$cod = $shipping['support_cod'];

		if ($cod)
		{
			/* 如果是团购，且保证金大于0，不能使用货到付款 */
			if ($flow_type == CART_GROUP_BUY_GOODS)
			{
				$group_buy_id = $_SESSION['extension_id'];
				if ($group_buy_id <= 0)
				{
					show_message('error group_buy_id');
				}
				$group_buy = group_buy_info($group_buy_id);
				if (empty($group_buy))
				{
					show_message('group buy not exists: ' . $group_buy_id);
				}

				if ($group_buy['deposit'] > 0)
				{
					$cod = false;
					$cod_fee = 0;

					/* 赋值保证金 */
					$smarty->assign('gb_deposit', $group_buy['deposit']);
				}
			}

			if ($cod)
			{
				$shipping_area_info = shipping_area_info($order['shipping_id'], $region);
				$cod_fee			= $shipping_area_info['pay_fee'];
			}
		}
		else
		{
			$cod_fee = 0;
		}
	}

	// 给货到付款的手续费加<span id>，以便改变配送的时候动态显示
	$payment_list = available_payment_list(1, $cod_fee);
	if(isset($payment_list))
	{
		foreach ($payment_list as $key => $payment)
		{
			if ($payment['is_cod'] == '1')
			{
				$payment_list[$key]['format_pay_fee'] = '<span id="ECS_CODFEE">' . $payment['format_pay_fee'] . '</span>';
			}
			/* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
			if ($payment['pay_code'] == 'yeepayszx' && $total['amount'] > 300)
			{
				unset($payment_list[$key]);
			}
			/* 如果有余额支付 */
			if ($payment['pay_code'] == 'balance')
			{
				/* 如果未登录，不显示 */
				if ($_SESSION['user_id'] == 0)
				{
					unset($payment_list[$key]);
				}
				else
				{
					if ($_SESSION['flow_order']['pay_id'] == $payment['pay_id'])
					{
						$smarty->assign('disable_surplus', 1);
					}
				}
			}
		}
	}
	$smarty->assign('payment_list', $payment_list);

    /* 取得包装与贺卡 */
    if ($total['real_goods_count'] > 0)
    {
        /* 只有有实体商品,才要判断包装和贺卡 */
        if (!isset($_CFG['use_package']) || $_CFG['use_package'] == '1')
        {
            /* 如果使用包装，取得包装列表及用户选择的包装 */
            $smarty->assign('pack_list', pack_list());
        }

        /* 如果使用贺卡，取得贺卡列表及用户选择的贺卡 */
        if (!isset($_CFG['use_card']) || $_CFG['use_card'] == '1')
        {
            $smarty->assign('card_list', card_list());
        }
    }

	$user_info = user_info($_SESSION['user_id']);

	/* 如果使用余额，取得用户余额 */
	if ((!isset($_CFG['use_surplus']) || $_CFG['use_surplus'] == '1')
		&& $_SESSION['user_id'] > 0
		&& $user_info['user_money'] > 0)
	{
		// 能使用余额
		$smarty->assign('allow_use_surplus', 1);
		$smarty->assign('your_surplus', $user_info['user_money']);
	}

    /* 如果使用积分，取得用户可用积分及本订单最多可以使用的积分 */
    if ((!isset($_CFG['use_integral']) || $_CFG['use_integral'] == '1')
        && $_SESSION['user_id'] > 0
        && $user_info['pay_points'] > 0
        && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS))
    {
        // 能使用积分
        $smarty->assign('allow_use_integral', 1);
        $smarty->assign('order_max_integral', flow_available_points());  // 可用积分
        $smarty->assign('your_integral',      $user_info['pay_points']); // 用户积分
    }

    /* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
    if ((!isset($_CFG['use_bonus']) || $_CFG['use_bonus'] == '1')
        && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS))
    {
        // 取得用户可用红包
        $user_bonus = user_bonus($_SESSION['user_id'], $total['goods_price']);
        if (!empty($user_bonus))
        {
            foreach ($user_bonus AS $key => $val)
            {
                $user_bonus[$key]['bonus_money_formated'] = price_format($val['type_money'], false);
            }
            $smarty->assign('bonus_list', $user_bonus);
        }

        // 能使用红包
        $smarty->assign('allow_use_bonus', 1);
    }

    /* 如果使用缺货处理，取得缺货处理列表 */
    if (!isset($_CFG['use_how_oos']) || $_CFG['use_how_oos'] == '1')
    {
        if (is_array($GLOBALS['_LANG']['oos']) && !empty($GLOBALS['_LANG']['oos']))
        {
            $smarty->assign('how_oos_list', $GLOBALS['_LANG']['oos']);
        }
    }

    /* 如果能开发票，取得发票内容列表 */
    if ((!isset($_CFG['can_invoice']) || $_CFG['can_invoice'] == '1')
        && isset($_CFG['invoice_content'])
        && trim($_CFG['invoice_content']) != '' && $flow_type != CART_EXCHANGE_GOODS)
    {
        $inv_content_list = explode("\n", str_replace("\r", '', $_CFG['invoice_content']));
        $smarty->assign('inv_content_list', $inv_content_list);

        $inv_type_list = array();
        foreach ($_CFG['invoice_type']['type'] as $key => $type)
        {
            if (!empty($type))
            {
                $inv_type_list[$type] = $type . ' [' . floatval($_CFG['invoice_type']['rate'][$key]) . '%]';
            }
        }
        $smarty->assign('inv_type_list', $inv_type_list);
    }

    /* 保存 session */
    $_SESSION['flow_order'] = $order;

	$smarty->assign('footer', get_footer());
	$smarty->display('order.dwt');
	exit;
}
elseif ($_REQUEST['act'] == 'select_shipping')
{
    /*------------------------------------------------------ */
    //-- 改变配送方式
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */

    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods))
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();

        $order['shipping_id'] = intval($_REQUEST['shipping']);
        $regions = array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']);
        $shipping_info = shipping_area_info($order['shipping_id'], $regions);

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* 取得可以得到的积分和红包 */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['cod_fee']     = $shipping_info['pay_fee'];
        if (strpos($result['cod_fee'], '%') === false)
        {
            $result['cod_fee'] = price_format($result['cod_fee'], false);
        }
        $result['need_insure'] = ($shipping_info['insure'] > 0 && !empty($order['need_insure'])) ? 1 : 0;
        $result['content']     = $smarty->fetch('order_total.dwt');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['act'] == 'select_insure')
{
    /*------------------------------------------------------ */
    //-- 选定/取消配送的保价
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */
    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods))
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();

        $order['need_insure'] = intval($_REQUEST['insure']);

        /* 保存 session */
        $_SESSION['flow_order'] = $order;

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* 取得可以得到的积分和红包 */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('/order_total.dwt');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['act'] == 'select_pack')
{
    /*------------------------------------------------------ */
    //-- 改变商品包装
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */
    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();

        $order['pack_id'] = intval($_REQUEST['pack']);

        /* 保存 session */
        $_SESSION['flow_order'] = $order;

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* 取得可以得到的积分和红包 */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('order_total.dwt');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['act'] == 'select_card')
{
    /*------------------------------------------------------ */
    //-- 改变贺卡
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */
    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();

        $order['card_id'] = intval($_REQUEST['card']);

        /* 保存 session */
        $_SESSION['flow_order'] = $order;

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* 取得可以得到的积分和红包 */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $order['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('order_total.dwt');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['act'] == 'select_payment')
{
    /*------------------------------------------------------ */
    //-- 改变支付方式
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0, 'payment' => 1);

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */
    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods))
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();

        $order['pay_id'] = intval($_REQUEST['payment']);
        $payment_info = payment_info($order['pay_id']);
        $result['pay_code'] = $payment_info['pay_code'];

        /* 保存 session */
        $_SESSION['flow_order'] = $order;

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* 取得可以得到的积分和红包 */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('order_total.dwt');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['act'] == 'change_surplus')
{
    /*------------------------------------------------------ */
    //-- 改变余额
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');

    $surplus   = floatval($_GET['surplus']);
    $user_info = user_info($_SESSION['user_id']);

    if ($user_info['user_money'] + $user_info['credit_line'] < $surplus)
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物类型 */
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 获得收货人信息 */
        $consignee = get_consignee($_SESSION['user_id']);

        /* 对商品信息赋值 */
        $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

        if (empty($cart_goods))
        {
            $result['error'] = '您的购物车中没有商品！';
        }
        else
        {
            /* 取得订单信息 */
            $order = flow_order_info();
            $order['surplus'] = $surplus;

            /* 计算订单的费用 */
            $total = order_fee($order, $cart_goods, $consignee);
            $smarty->assign('total', $total);

            /* 团购标志 */
            if ($flow_type == CART_GROUP_BUY_GOODS)
            {
                $smarty->assign('is_group_buy', 1);
            }

            $result['content'] = $smarty->fetch('order_total.dwt');
        }
    }

    $json = new JSON();
    die($json->encode($result));
}
elseif ($_REQUEST['act'] == 'change_bonus')
{
    /*------------------------------------------------------ */
    //-- 改变红包
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');
    $result = array('error' => '', 'content' => '');

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */
    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();

        $bonus = bonus_info(intval($_GET['bonus']));

        if ((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || $_GET['bonus'] == 0)
        {
            $order['bonus_id'] = intval($_GET['bonus']);
        }
        else
        {
            $order['bonus_id'] = 0;
            $result['error'] = '您选择的红包并不存在。';
        }

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('order_total.dwt');
    }

    $json = new JSON();
    die($json->encode($result));
}
/* 验证红包序列号 */
elseif ($_REQUEST['act'] == 'validate_bonus')
{
    $bonus_sn = trim($_REQUEST['bonus_sn']);
    if (is_numeric($bonus_sn))
    {
        $bonus = bonus_info(0, $bonus_sn);
    }
    else
    {
        $bonus = array();
    }

//    if (empty($bonus) || $bonus['user_id'] > 0 || $bonus['order_id'] > 0)
//    {
//        die($_LANG['bonus_sn_error']);
//    }
//    if ($bonus['min_goods_amount'] > cart_amount())
//    {
//        die(sprintf($_LANG['bonus_min_amount_error'], price_format($bonus['min_goods_amount'], false)));
//    }
//    die(sprintf($_LANG['bonus_is_ok'], price_format($bonus['type_money'], false)));
    $bonus_kill = price_format($bonus['type_money'], false);

    include_once('includes/cls_json.php');
    $result = array('error' => '', 'content' => '');

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */
    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = '您的购物车中没有商品！';
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();


        if (((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || ($bonus['type_money'] > 0 && empty($bonus['user_id']))) && $bonus['order_id'] <= 0)
        {
            //$order['bonus_kill'] = $bonus['type_money'];
            $now = gmtime();
            if ($now > $bonus['use_end_date'])
            {
                $order['bonus_id'] = '';
                $result['error']='该红包已经过了使用期！';
            }
            else
            {
                $order['bonus_id'] = $bonus['bonus_id'];
                $order['bonus_sn'] = $bonus_sn;
            }
        }
        else
        {
            //$order['bonus_kill'] = 0;
            $order['bonus_id'] = '';
            $result['error'] = '您选择的红包并不存在。';
        }

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);

        if($total['goods_price']<$bonus['min_goods_amount'])
        {
         $order['bonus_id'] = '';
         /* 重新计算订单 */
         $total = order_fee($order, $cart_goods, $consignee);
         $result['error'] = sprintf('订单商品金额没有达到使用该红包的最低金额 %s', price_format($bonus['min_goods_amount'], false));
        }

        $smarty->assign('total', $total);

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('order_total.dwt');
    }
    $json = new JSON();
    die($json->encode($result));
}
elseif ($_REQUEST['act'] == 'change_integral')
{
    /*------------------------------------------------------ */
    //-- 改变积分
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');

    $points    = floatval($_GET['points']);
    $user_info = user_info($_SESSION['user_id']);

    /* 取得订单信息 */
    $order = flow_order_info();

    $flow_points = flow_available_points();  // 该订单允许使用的积分
    $user_points = $user_info['pay_points']; // 用户的积分总数

    if ($points > $user_points)
    {
        $result['error'] = '您使用的积分不能超过您现有的积分。';
    }
    elseif ($points > $flow_points)
    {
        $result['error'] = sprintf("您使用的积分不能超过%d", $flow_points);
    }
    else
    {
        /* 取得购物类型 */
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

        $order['integral'] = $points;

        /* 获得收货人信息 */
        $consignee = get_consignee($_SESSION['user_id']);

        /* 对商品信息赋值 */
        $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

        if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
        {
            $result['error'] = '您的购物车中没有商品！';
        }
        else
        {
            /* 计算订单的费用 */
            $total = order_fee($order, $cart_goods, $consignee);
            $smarty->assign('total',  $total);
            $smarty->assign('config', $_CFG);

            /* 团购标志 */
            if ($flow_type == CART_GROUP_BUY_GOODS)
            {
                $smarty->assign('is_group_buy', 1);
            }

            $result['content'] = $smarty->fetch('order_total.dwt');
            $result['error'] = '';
        }
    }

    $json = new JSON();
    die($json->encode($result));
}
elseif ($_REQUEST['act'] == 'change_needinv')
{
    /*------------------------------------------------------ */
    //-- 改变发票的设置
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');
    $result = array('error' => '', 'content' => '');
    $json = new JSON();
    $_GET['inv_type'] = !empty($_GET['inv_type']) ? json_str_iconv(urldecode($_GET['inv_type'])) : '';
    $_GET['invPayee'] = !empty($_GET['invPayee']) ? json_str_iconv(urldecode($_GET['invPayee'])) : '';
    $_GET['inv_content'] = !empty($_GET['inv_content']) ? json_str_iconv(urldecode($_GET['inv_content'])) : '';

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* 获得收货人信息 */
    $consignee = get_consignee($_SESSION['user_id']);

    /* 对商品信息赋值 */
    $cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = '您的购物车中没有商品！';
        die($json->encode($result));
    }
    else
    {
        /* 取得购物流程设置 */
        $smarty->assign('config', $_CFG);

        /* 取得订单信息 */
        $order = flow_order_info();

        if (isset($_GET['need_inv']) && intval($_GET['need_inv']) == 1)
        {
            $order['need_inv']    = 1;
            $order['inv_type']    = trim(stripslashes($_GET['inv_type']));
            $order['inv_payee']   = trim(stripslashes($_GET['inv_payee']));
            $order['inv_content'] = trim(stripslashes($_GET['inv_content']));
        }
        else
        {
            $order['need_inv']    = 0;
            $order['inv_type']    = '';
            $order['inv_payee']   = '';
            $order['inv_content'] = '';
        }

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        die($smarty->fetch('order_total.dwt'));
    }
}
elseif($_REQUEST['act'] = 'done')
{
	/*------------------------------------------------------ */
	//-- 完成所有订单操作，提交到数据库
	/*------------------------------------------------------ */

    include_once('includes/lib_clips.php');
    include_once('includes/lib_payment.php');

    /* 取得购物类型 */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

	/* 检查购物车中是否有商品 */
	$sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') .
		" WHERE session_id = '" . SESS_ID . "' " .
		"AND parent_id = 0 AND is_gift = 0 AND rec_type = '$flow_type'";
	if ($db->getOne($sql) == 0)
	{
        $result['error'] = '您的购物车中没有商品！';
	}

	/* 检查商品库存 */
	/* 如果使用库存，且下订单时减库存，则减少库存 */
	if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
	{
		$cart_goods_stock = get_cart_goods();
		$_cart_goods_stock = array();
		foreach ($cart_goods_stock['goods_list'] as $value)
		{
			$_cart_goods_stock[$value['rec_id']] = $value['goods_number'];
		}
		flow_cart_stock($_cart_goods_stock);
		unset($cart_goods_stock, $_cart_goods_stock);
	}

	$consignee = get_consignee($_SESSION['user_id']);

	$_POST['how_oos'] = isset($_POST['how_oos']) ? intval($_POST['how_oos']) : 0;
	$_POST['card_message'] = isset($_POST['card_message']) ? htmlspecialchars($_POST['card_message']) : '';
	$_POST['inv_type'] = !empty($_POST['inv_type']) ? htmlspecialchars($_POST['inv_type']) : '';
	$_POST['inv_payee'] = isset($_POST['inv_payee']) ? htmlspecialchars($_POST['inv_payee']) : '';
	$_POST['inv_content'] = isset($_POST['inv_content']) ? htmlspecialchars($_POST['inv_content']) : '';
	$_POST['postscript'] = isset($_POST['postscript']) ? htmlspecialchars($_POST['postscript']) : '';

	$order = array(
        'shipping_id'     => intval($_POST['shipping']),
        'pay_id'          => intval($_POST['payment']),
        'pack_id'         => isset($_POST['pack']) ? intval($_POST['pack']) : 0,
        'card_id'         => isset($_POST['card']) ? intval($_POST['card']) : 0,
        'card_message'    => trim($_POST['card_message']),
        'surplus'         => isset($_POST['surplus']) ? floatval($_POST['surplus']) : 0.00,
        'integral'        => isset($_POST['integral']) ? intval($_POST['integral']) : 0,
        'bonus_id'        => isset($_POST['bonus']) ? intval($_POST['bonus']) : 0,
        'need_inv'        => empty($_POST['need_inv']) ? 0 : 1,
        'inv_type'        => $_POST['inv_type'],
        'inv_payee'       => trim($_POST['inv_payee']),
        'inv_content'     => $_POST['inv_content'],
        'postscript'      => trim($_POST['postscript']),
        'how_oos'         => isset($_LANG['oos'][$_POST['how_oos']]) ? addslashes($_LANG['oos'][$_POST['how_oos']]) : '',
        'need_insure'     => isset($_POST['need_insure']) ? intval($_POST['need_insure']) : 0,
        'user_id'         => $_SESSION['user_id'],
        'add_time'        => gmtime(),
        'order_status'    => OS_UNCONFIRMED,
        'shipping_status' => SS_UNSHIPPED,
        'pay_status'      => PS_UNPAYED,
        'agency_id'       => get_agency_by_regions(array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']))
		);
	/* 扩展信息 */
	if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS)
	{
		$order['extension_code'] = $_SESSION['extension_code'];
		$order['extension_id'] = $_SESSION['extension_id'];
	}
	else
	{
		$order['extension_code'] = '';
		$order['extension_id'] = 0;
	}

	/* 检查积分余额是否合法 */
	$user_id = $_SESSION['user_id'];
	if ($user_id > 0)
	{
		$user_info = user_info($user_id);

		$order['surplus'] = min($order['surplus'], $user_info['user_money'] + $user_info['credit_line']);
		if ($order['surplus'] < 0)
		{
			$order['surplus'] = 0;
		}

		// 查询用户有多少积分
		$flow_points = flow_available_points();  // 该订单允许使用的积分
		$user_points = $user_info['pay_points']; // 用户的积分总数

		$order['integral'] = min($order['integral'], $user_points, $flow_points);
		if ($order['integral'] < 0)
		{
			$order['integral'] = 0;
		}
	}
	else
	{
		$order['surplus']  = 0;
		$order['integral'] = 0;
	}

    /* 检查红包是否存在 */
    if ($order['bonus_id'] > 0)
    {
        $bonus = bonus_info($order['bonus_id']);

        if (empty($bonus) || $bonus['user_id'] != $user_id || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart_amount(true, $flow_type))
        {
            $order['bonus_id'] = 0;
        }
    }
    elseif (isset($_POST['bonus_sn']))
    {
     	$flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        $bonus_sn = trim($_POST['bonus_sn']);
        $bonus = bonus_info(0, $bonus_sn);
        $now = gmtime();
        if (empty($bonus) || $bonus['user_id'] > 0 || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart_amount(true, $flow_type) || $now > $bonus['use_end_date'])
        {
        }
        else
        {
            if ($user_id > 0)
            {
                $sql = "UPDATE " . $ecs->table('user_bonus') . " SET user_id = '$user_id' WHERE bonus_id = '$bonus[bonus_id]' LIMIT 1";
                $db->query($sql);
            }
            $order['bonus_id'] = $bonus['bonus_id'];
            $order['bonus_sn'] = $bonus_sn;
        }
    }

    /* 订单中的商品 */
	$cart_goods = cart_goods($flow_type);

	if (empty($cart_goods))
	{
		$tips = '您的购物车中没有商品';
		$smarty->assign('footer', get_footer());
		$smarty->assign('tips', $tips);
		$smarty->display('order_done.dwt');
		exit;
	}


	/* 收货人信息 */
	foreach ($consignee as $key => $value)
	{
		$order[$key] = addslashes($value);
	}

    /* 订单中的总额 */
    $total = order_fee($order, $cart_goods, $consignee);
    $order['bonus']        = $total['bonus'];
    $order['goods_amount'] = $total['goods_price'];
    $order['discount']     = $total['discount'];
    $order['surplus']      = $total['surplus'];
    $order['tax']          = $total['tax'];

    // 购物车中的商品能享受红包支付的总额
    $discount_amout = compute_discount_amount();
    // 红包和积分最多能支付的金额为商品总额
    $temp_amout = $order['goods_amount'] - $discount_amout;
    if ($temp_amout <= 0)
    {
        $order['bonus_id'] = 0;
    }

	/* 配送方式 */
	if ($order['shipping_id'] > 0)
	{
		$shipping = shipping_info($order['shipping_id']);
		$order['shipping_name'] = addslashes($shipping['shipping_name']);
	}
	$order['shipping_fee'] = $total['shipping_fee'];
	$order['insure_fee']   = $total['shipping_insure'];

	/* 支付方式 */
	if ($order['pay_id'] > 0)
	{
		$payment = payment_info($order['pay_id']);
		$order['pay_name'] = addslashes($payment['pay_name']);
	}
    $order['pay_fee'] = $total['pay_fee'];
    $order['cod_fee'] = $total['cod_fee'];

    /* 商品包装 */
    if ($order['pack_id'] > 0)
    {
        $pack               = pack_info($order['pack_id']);
        $order['pack_name'] = addslashes($pack['pack_name']);
    }
    $order['pack_fee'] = $total['pack_fee'];

    /* 祝福贺卡 */
    if ($order['card_id'] > 0)
    {
        $card               = card_info($order['card_id']);
        $order['card_name'] = addslashes($card['card_name']);
    }
    $order['card_fee']      = $total['card_fee'];

	$order['integral_money']   = $total['integral_money'];
	$order['integral']		 = $total['integral'];

	if ($order['extension_code'] == 'exchange_goods')
	{
		$order['integral_money']   = 0;
		$order['integral']		 = $total['exchange_integral'];
	}

	$order['from_ad']		  = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
	$order['referer']		  = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';
	
	$order['order_amount']  = number_format($total['amount'], 2, '.', '');
	/* 如果全部使用余额支付，检查余额是否足够 */
	if ($payment['pay_code'] == 'balance' && $order['order_amount'] > 0)
	{
		if($order['surplus'] >0) //余额支付里如果输入了一个金额
		{
			$order['order_amount'] = $order['order_amount'] + $order['surplus'];
			$order['surplus'] = 0;
		}
		if ($order['order_amount'] > ($user_info['user_money'] + $user_info['credit_line']))
		{
			$tips = '您的余额不足以支付整个订单，请选择其他支付方式';
			$smarty->assign('footer', get_footer());
			$smarty->assign('tips', $tips);
			$smarty->display('order_done.dwt');
			exit;
		}
		else
		{
			$order['surplus'] = $order['order_amount'];
			$order['order_amount'] = 0;
		}
	}
	
	/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
	if ($order['order_amount'] <= 0)
	{
		$order['order_status'] = OS_CONFIRMED;
		$order['confirm_time'] = gmtime();
		$order['pay_status']   = PS_PAYED;
		$order['pay_time']	 = gmtime();
		$order['order_amount'] = 0;
	}

	$order['integral_money']   = $total['integral_money'];
	$order['integral']		 = $total['integral'];

	if ($order['extension_code'] == 'exchange_goods')
	{
		$order['integral_money']   = 0;
		$order['integral']		 = $total['exchange_integral'];
	}

	$order['from_ad']		  = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
	$order['referer']		  = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';

	/* 记录扩展信息 */
	if ($flow_type != CART_GENERAL_GOODS)
	{
		$order['extension_code'] = $_SESSION['extension_code'];
		$order['extension_id'] = $_SESSION['extension_id'];
	}

	$affiliate = unserialize($_CFG['affiliate']);


	/* 插入订单表 */
	$error_no = 0;
	do
	{
		$order['order_sn'] = get_order_sn(); //获取新订单号
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');

		$error_no = $GLOBALS['db']->errno();

		if ($error_no > 0 && $error_no != 1062)
		{
			die($GLOBALS['db']->errorMsg());
		}
	}
	while ($error_no == 1062); //如果是订单号重复则重新提交数据

	$new_order_id = $db->insert_id();
	$order['order_id'] = $new_order_id;
	
    /* 插入订单商品 */
    $sql = "INSERT INTO " . $ecs->table('order_goods') . "( " .
                "order_id, goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
                "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id) ".
            " SELECT '$new_order_id', goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
                "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id".
            " FROM " .$ecs->table('cart') .
            " WHERE session_id = '".SESS_ID."' AND rec_type = '$flow_type'";
    $db->query($sql);

	/* 处理余额、积分、红包 */
	if ($order['user_id'] > 0 && $order['surplus'] > 0)
	{
		log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, sprintf('支付订单 %s', $order['order_sn']));
	}
	if ($order['user_id'] > 0 && $order['integral'] > 0)
	{
		log_account_change($order['user_id'], 0, 0, 0, $order['integral'] * (-1), sprintf('支付订单 %s', $order['order_sn']));
	}
    if ($order['bonus_id'] > 0 && $temp_amout > 0)
    {
        use_bonus($order['bonus_id'], $new_order_id);
    }
	/* 如果使用库存，且下订单时减库存，则减少库存 */
	if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
	{
		change_order_goods_storage($order['order_id'], true, SDT_PLACE);
	}


	/* 清空购物车 */
	clear_cart($flow_type);
	/* 清除缓存，否则买了商品，但是前台页面读取缓存，商品数量不减少 */
	clear_all_files();

	if(!empty($order['shipping_name']))
	{
		$order['shipping_name']=trim(stripcslashes($order['shipping_name']));
	}
	/* 取得支付信息，生成支付代码 */
	if ($order['order_amount'] > 0)
	{
		$payment = payment_info($order['pay_id']);

		include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');

		$pay_obj	= new $payment['pay_code'];
		$order['log_id'] = insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);
		$pay_online = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));

		$order['pay_desc'] = $payment['pay_desc'];

		$smarty->assign('pay_online', $pay_online);
	}

	/* 订单信息 */
	$smarty->assign('order', $order);
	$smarty->assign('total', $total);
	$smarty->assign('goods_list', $cart_goods);
	$smarty->assign('order_submit_back', sprintf('您可以 %s 或去 %s', '<a href="index.php">返回首页</a>', '<a href="user.php">用户中心</a>')); // 返回提示

	unset($_SESSION['flow_consignee']); // 清除session中保存的收货人信息
	unset($_SESSION['flow_order']);
	unset($_SESSION['direct_shopping']);

    if ($_SESSION['user_id'] > 0)
    {
        $smarty->assign('user_name', $_SESSION['user_name']);
    }
	$smarty->assign('footer', get_footer());
	
	$smarty->assign('tips', $tips);
	$smarty->display('order_done.dwt');
	exit;

}


function flow_available_points()
{
	$sql = "SELECT SUM(g.integral * c.goods_number) ".
			"FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('goods') . " AS g " .
			"WHERE c.session_id = '" . SESS_ID . "' AND c.goods_id = g.goods_id AND c.is_gift = 0 AND g.integral > 0 " .
			"AND c.rec_type = '" . CART_GENERAL_GOODS . "'";

	$val = intval($GLOBALS['db']->getOne($sql));

	return integral_of_value($val);
}

/**
 * 检查订单中商品库存
 *
 * @access  public
 * @param   array   $arr
 *
 * @return  void
 */
function flow_cart_stock($arr)
{
	foreach ($arr AS $key => $val)
	{
		$val = intval(make_semiangle($val));
		if ($val <= 0)
		{
			continue;
		}

		$sql = "SELECT `goods_id`, `goods_attr_id`, `extension_code` FROM" .$GLOBALS['ecs']->table('cart').
			   " WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
		$goods = $GLOBALS['db']->getRow($sql);

		$sql = "SELECT g.goods_name, g.goods_number, c.product_id ".
				"FROM " .$GLOBALS['ecs']->table('goods'). " AS g, ".
					$GLOBALS['ecs']->table('cart'). " AS c ".
				"WHERE g.goods_id = c.goods_id AND c.rec_id = '$key'";
		$row = $GLOBALS['db']->getRow($sql);

		//系统启用了库存，检查输入的商品数量是否有效
		if (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] != 'package_buy')
		{
			if ($row['goods_number'] < $val)
			{
				show_message(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
				$row['goods_number'], $row['goods_number']));
				exit;
			}

			/* 是货品 */
			$row['product_id'] = trim($row['product_id']);
			if (!empty($row['product_id']))
			{
				$sql = "SELECT product_number FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '" . $goods['goods_id'] . "' AND product_id = '" . $row['product_id'] . "'";
				$product_number = $GLOBALS['db']->getOne($sql);
				if ($product_number < $val)
				{
					show_message(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
					$row['goods_number'], $row['goods_number']));
					exit;
				}
			}
		}
		elseif (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] == 'package_buy')
		{
			if (judge_package_stock($goods['goods_id'], $val))
			{
				show_message($GLOBALS['_LANG']['package_stock_insufficiency']);
				exit;
			}
		}
	}

}
?>