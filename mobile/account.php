<?php
session_start();
define('IN_ECS', true);
define('ECS_ADMIN', true);
require(dirname(__FILE__) . '/includes/init.php');
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);
}
/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

$user_id = $_SESSION['user_id'] ? $_SESSION['user_id'] : '';
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'account_log';

/* 用户中心 */
if ($user_id <= 0){
	$smarty->assign('footer', get_footer());
	$smarty->assign('gourl', "account.php");
	$smarty->display('login.dwt');
	exit;
}
/* 会员充值和提现申请记录 */
if ($act == 'account_log'){
	include_once(ROOT_PATH . 'includes/lib_clips.php');

	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

	/* 获取记录条数 */
	$sql = "SELECT COUNT(*) FROM " .$ecs->table('user_account').
		   " WHERE user_id = '$user_id'" .
		   " AND process_type " . db_create_in(array(SURPLUS_SAVE, SURPLUS_RETURN));
	$record_count = $db->getOne($sql);
	if($record_count){
		$page_num = '8';
		$page = !empty($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
		$pages = ceil($record_count / $page_num);
		if ($page <= 0){
			$page = 1;
		}
		if ($pages == 0){
			$pages = 1;
		}
		if ($page > $pages){
			$page = $pages;
		}
		$pagebar = get_wap_pager($record_count, $page_num, $page, 'account.php', 'page');
		$smarty->assign('pagebar' , $pagebar);
		//获取余额记录
		$account_log = get_m_account_log($user_id, $page_num, $page_num * ($page - 1));
		$smarty->assign('account_log', $account_log);
	}
	//print_r($account_log);
	//获取剩余余额
	$surplus_amount = get_user_surplus($user_id);
	if (empty($surplus_amount)){
		$surplus_amount = 0;
	}
	//模板赋值
	$smarty->assign('surplus_amount', price_format($surplus_amount, false));
	$smarty->assign('act', 'account_log');
	$smarty->display('account.dwt');
}
/* 会员账目明细界面 */
elseif ($act == 'account_detail')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    $account_type = 'user_money';

    /* 获取记录条数 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('account_log').
           " WHERE user_id = '$user_id'" .
           " AND $account_type <> 0 ";
    $record_count = $db->getOne($sql);

    //分页函数
	if($record_count){
		$page_num = '8';
		$page = !empty($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
		$pages = ceil($record_count / $page_num);
		if ($page <= 0){
			$page = 1;
		}
		if ($pages == 0){
			$pages = 1;
		}
		if ($page > $pages){
			$page = $pages;
		}
		$pagebar = get_wap_pager($record_count, $page_num, $page, 'account.php', 'page');
		$smarty->assign('pagebar' , $pagebar);
	}

    //获取剩余余额
    $surplus_amount = get_user_surplus($user_id);
    if (empty($surplus_amount))
    {
        $surplus_amount = 0;
    }

    //获取余额记录
    $account_log = array();
    $sql = "SELECT * FROM " . $ecs->table('account_log') .
           " WHERE user_id = '$user_id'" .
           " AND $account_type <> 0 " .
           " ORDER BY log_id DESC";
	$page_num = '8';
    $res = $GLOBALS['db']->selectLimit($sql, $page_num);
    while ($row = $db->fetchRow($res))
    {
        $row['change_time'] = local_date($_CFG['date_format'], $row['change_time']);
        $row['type'] = $row[$account_type] > 0 ? $_LANG['account_inc'] : $_LANG['account_dec'];
        $row['user_money'] = price_format(abs($row['user_money']), false);
        $row['frozen_money'] = price_format(abs($row['frozen_money']), false);
        $row['rank_points'] = abs($row['rank_points']);
        $row['pay_points'] = abs($row['pay_points']);
        $row['short_change_desc'] = sub_str($row['change_desc'], 60);
        $row['amount'] = $row[$account_type];
        $account_log[] = $row;
    }

    //模板赋值
    $smarty->assign('surplus_amount', price_format($surplus_amount, false));
    $smarty->assign('account_log',    $account_log);
	$smarty->assign('act', 'account_detail');
	$smarty->display('account.dwt');
}
/* 删除会员余额 */
elseif ($act == 'cancel')
{
	include_once(ROOT_PATH . 'includes/lib_clips.php');

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	if ($id == 0 || $user_id == 0)
	{
		header("Location: account.php?act=account_log\n");
		exit;
	}
	$result = del_user_account($id, $user_id);
	if ($result)
	{
		header("Location: account.php?act=account_log\n");
		exit;
	}
}
/* 会员通过帐目明细列表进行再付款的操作 */
elseif ($act == 'pay')
{
	include_once(ROOT_PATH . 'includes/lib_clips.php');
	include_once(ROOT_PATH . 'includes/lib_payment.php');
	include_once(ROOT_PATH . 'includes/lib_order.php');

	//变量初始化
	$surplus_id = isset($_GET['id'])  ? intval($_GET['id'])  : 0;
	$payment_id = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

	if ($surplus_id == 0)
	{
		ecs_header("Location: account.php?act=account_log\n");
		exit;
	}

	//如果原来的支付方式已禁用或者已删除, 重新选择支付方式
	if ($payment_id == 0)
	{
		ecs_header("Location: account.php?act=account_deposit&id=".$surplus_id."\n");
		exit;
	}

	//获取单条会员帐目信息
	$order = array();
	$order = get_surplus_info($surplus_id);

	//支付方式的信息
	$payment_info = array();
	$payment_info = payment_info($payment_id);
	
	//获取剩余余额
	$surplus_amount = get_user_surplus($user_id);
	if (empty($surplus_amount)){
		$surplus_amount = 0;
	}
	$smarty->assign('surplus_amount', price_format($surplus_amount, false));
	
	/* 如果当前支付方式没有被禁用，进行支付的操作 */
	if (!empty($payment_info))
	{
		//取得支付信息，生成支付代码
		$payment = unserialize_config($payment_info['pay_config']);

		//生成伪订单号
		$order['order_sn'] = $surplus_id;

		//获取需要支付的log_id
		$order['log_id'] = get_paylog_id($surplus_id, $pay_type = PAY_SURPLUS);

		$order['user_name']	  = $_SESSION['user_name'];
		$order['surplus_amount'] = $order['amount'];

		//计算支付手续费用
		$payment_info['pay_fee'] = pay_fee($payment_id, $order['surplus_amount'], 0);

		//计算此次预付款需要支付的总金额
		$order['order_amount']   = $order['surplus_amount'] + $payment_info['pay_fee'];

		//如果支付费用改变了，也要相应的更改pay_log表的order_amount
		$order_amount = $db->getOne("SELECT order_amount FROM " .$ecs->table('pay_log')." WHERE log_id = '$order[log_id]'");
		if ($order_amount <> $order['order_amount'])
		{
			$db->query("UPDATE " .$ecs->table('pay_log').
					   " SET order_amount = '$order[order_amount]' WHERE log_id = '$order[log_id]'");
		}

		/* 调用相应的支付方式文件 */
		include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');

		/* 取得在线支付方式的支付按钮 */
		$pay_obj = new $payment_info['pay_code'];
		$payment_info['pay_button'] = $pay_obj->get_code($order, $payment);

		/* 模板赋值 */
		$smarty->assign('payment', $payment_info);
		$smarty->assign('order', $order);
		$smarty->assign('pay_fee', price_format($payment_info['pay_fee'], false));
		$smarty->assign('amount', price_format($order['surplus_amount'], false));
		$smarty->assign('act', 'act_account');
		$smarty->display('account.dwt');
	}
	/* 重新选择支付方式 */
	else
	{
		include_once(ROOT_PATH . 'includes/lib_clips.php');

		$smarty->assign('payment', get_online_payment_list());
		$smarty->assign('order',   $order);
		$smarty->assign('act',  'account_deposit');
		$smarty->display('account.dwt');
	}
}
/* 会员预付款界面 */
elseif ($act == 'account_deposit')
{
	include_once(ROOT_PATH . 'includes/lib_clips.php');

	$surplus_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$account	= get_surplus_info($surplus_id);
	
	//获取剩余余额
	$surplus_amount = get_user_surplus($user_id);
	if (empty($surplus_amount)){
		$surplus_amount = 0;
	}
	$smarty->assign('surplus_amount', price_format($surplus_amount, false));
	
	$smarty->assign('payment', get_online_payment_list(false));
	$smarty->assign('order', $account);
	$smarty->assign('act', 'account_deposit');
	$smarty->display('account.dwt');
}
/* 对会员余额申请的处理 */
elseif ($act == 'act_account')
{
	include_once(ROOT_PATH . 'includes/lib_clips.php');
	include_once(ROOT_PATH . 'includes/lib_order.php');
	$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
	if ($amount <= 0)
	{
		exit("请在“金额”栏输入大于0的数字");
	}
	//获取剩余余额
	$surplus_amount = get_user_surplus($user_id);
	if (empty($surplus_amount)){
		$surplus_amount = 0;
	}
	$smarty->assign('surplus_amount', price_format($surplus_amount, false));
	
	/* 变量初始化 */
	$surplus = array(
			'user_id' => $user_id,
			'rec_id' => !empty($_POST['rec_id']) ? intval($_POST['rec_id']) : 0,
			'process_type' => isset($_POST['surplus_type']) ? intval($_POST['surplus_type']) : 0,
			'payment_id' => isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0,
			'user_note' => isset($_POST['user_note']) ? trim($_POST['user_note']) : '',
			'amount' => $amount
	);

	/* 提款申请的处理 */
	if ($surplus['process_type'] == 1)
	{
		/* 判断是否有足够的余额的进行退款的操作 */
		$sur_amount = get_user_surplus($user_id);
		if ($amount > $sur_amount)
		{
			exit("您要申请提现的金额超过了您现有的余额，此操作将不可进行！");
		}

		//插入会员账目明细
		$amount = '-'.$amount;
		$surplus['payment'] = '';
		$surplus['rec_id']  = insert_user_account($surplus, $amount);

		/* 如果成功提交 */
		if ($surplus['rec_id'] > 0)
		{
			exit("您的提现申请已成功提交，请等待管理员的审核！");
		}
		else
		{
			exit("此次操作失败，请返回重试！");
		}
	}
	/* 如果是会员预付款，跳转到下一步，进行线上支付的操作 */
	else
	{
		if ($surplus['payment_id'] <= 0)
		{
			exit("请选择支付方式");
		}

		include_once(ROOT_PATH .'includes/lib_payment.php');

		//获取支付方式名称
		$payment_info = array();
		$payment_info = payment_info($surplus['payment_id']);
		$surplus['payment'] = $payment_info['pay_name'];

		if ($surplus['rec_id'] > 0)
		{
			//更新会员账目明细
			$surplus['rec_id'] = update_user_account($surplus);
		}
		else
		{
			//插入会员账目明细
			$surplus['rec_id'] = insert_user_account($surplus, $amount);
		}

		//取得支付信息，生成支付代码
		$payment = unserialize_config($payment_info['pay_config']);

		//生成伪订单号, 不足的时候补0
		$order = array();
		$order['order_sn']	   = $surplus['rec_id'];
		$order['user_name']	  = $_SESSION['user_name'];
		$order['surplus_amount'] = $amount;

		//计算支付手续费用
		$payment_info['pay_fee'] = pay_fee($surplus['payment_id'], $order['surplus_amount'], 0);

		//计算此次预付款需要支付的总金额
		$order['order_amount']   = $amount + $payment_info['pay_fee'];

		//记录支付log
		$order['log_id'] = insert_pay_log($surplus['rec_id'], $order['order_amount'], $type=PAY_SURPLUS, 0);

		/* 调用相应的支付方式文件 */
		include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');

		/* 取得在线支付方式的支付按钮 */
		$pay_obj = new $payment_info['pay_code'];
		$payment_info['pay_button'] = $pay_obj->get_code($order, $payment);

		/* 模板赋值 */
		$smarty->assign('payment', $payment_info);
		$smarty->assign('pay_fee', price_format($payment_info['pay_fee'], false));
		$smarty->assign('amount', price_format($amount, false));
		$smarty->assign('order', $order);
		$smarty->assign('act', 'act_account');
		$smarty->display('account.dwt');
	}
}
/**
 * 查询会员余额的操作记录
 *
 * @access  public
 * @param   int	 $user_id	会员ID
 * @param   int	 $num		每页显示数量
 * @param   int	 $start	  开始显示的条数
 * @return  array
 */
function get_m_account_log($user_id, $num, $start)
{
	$account_log = array();
	$sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('user_account').
		   " WHERE user_id = '$user_id'" .
		   " AND process_type " . db_create_in(array(SURPLUS_SAVE, SURPLUS_RETURN)) .
		   " ORDER BY add_time DESC";
	$res = $GLOBALS['db']->selectLimit($sql, $num, $start);

	if ($res)
	{
		while ($rows = $GLOBALS['db']->fetchRow($res))
		{
			$rows['add_time']		 = local_date($GLOBALS['_CFG']['date_format'], $rows['add_time']);
			$rows['admin_note']	   = nl2br(htmlspecialchars($rows['admin_note']));
			$rows['short_admin_note'] = ($rows['admin_note'] > '') ? sub_str($rows['admin_note'], 30) : 'N/A';
			$rows['user_note']		= nl2br(htmlspecialchars($rows['user_note']));
			$rows['short_user_note']  = ($rows['user_note'] > '') ? sub_str($rows['user_note'], 30) : 'N/A';
			$rows['pay_status']	   = ($rows['is_paid'] == 0) ? $GLOBALS['_LANG']['un_confirm'] : $GLOBALS['_LANG']['is_confirm'];
			$rows['amount']		   = price_format(abs($rows['amount']), false);

			/* 会员的操作类型： 冲值，提现 */
			if ($rows['process_type'] == 0)
			{
				$rows['type'] = $GLOBALS['_LANG']['surplus_type_0'];
			}
			else
			{
				$rows['type'] = $GLOBALS['_LANG']['surplus_type_1'];
			}

			/* 支付方式的ID */
			$sql = 'SELECT pay_id FROM ' .$GLOBALS['ecs']->table('payment').
				   " WHERE pay_name = '$rows[payment]' AND enabled = 1";
			$pid = $GLOBALS['db']->getOne($sql);

			/* 如果是预付款而且还没有付款, 允许付款 */
			if (($rows['is_paid'] == 0) && ($rows['process_type'] == 0))
			{
				$rows['handle'] = '<a href="account.php?act=pay&id='.$rows['id'].'&pid='.$pid.'">'.$GLOBALS['_LANG']['pay'].'</a>';
			}

			$account_log[] = $rows;
		}

		return $account_log;
	}
	else
	{
		 return false;
	}
}
?>