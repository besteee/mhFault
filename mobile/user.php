<?php

/**
 * ECSHOP 用户中心
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: user.php 16643 2009-09-08 07:02:13Z liubo $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'mobile/includes/lib_wxch.php');
/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);
}
$act = isset($_GET['act']) ? $_GET['act'] : '';
$user_id = $_SESSION['user_id'];

/* 用户登陆 */
if ($act == 'do_login')
{
	$user_name = !empty($_POST['username']) ? $_POST['username'] : '';
	$pwd = !empty($_POST['pwd']) ? $_POST['pwd'] : '';
	$gourl = !empty($_POST['gourl']) ? $_POST['gourl'] : '';
	
	$remember = isset($_POST['remember']) ? $_POST['remember'] : 0;
	//记住用户名字
	if(!empty($remember)){
		setcookie("ECS[reuser_name]", $user_name, time() + 31536000, '/');
	}
	$reuser_name= isset($_COOKIE['ECS']['reuser_name']) ? $_COOKIE['ECS']['reuser_name'] : '';
	if(!empty($reuser_name)){
		$smarty->assign('reuser_name', $reuser_name);
	}
	
	if (empty($user_name) || empty($pwd))
	{
		ecs_header("Location:user.php\n");
		$login_faild = 1;
	}
	else
	{
		if ($user->check_user($user_name, $pwd) > 0)
		{
			$user->set_session($user_name);
			$user->set_cookie($user_name);
			update_user_info();
	        recalculate_price();
			//优化登陆跳转
			if($gourl){
				ecs_header("Location:$gourl\n");
				exit;
			}else{
				$sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') . " WHERE session_id = '" . SESS_ID . "' " . "AND parent_id = 0 AND is_gift = 0 AND rec_type = 0";
				if ($db->getOne($sql) > 0){
					ecs_header("Location:cart.php\n");
					exit;
				}else{
					ecs_header("Location:user.php\n");
					exit;
				}
			}
		}
		else
		{
			$login_faild = 1;
		}
	}
	$smarty->assign('login_faild', $login_faild);
	$smarty->display('login.dwt');
	exit;
}

/* 微信用户自动登陆 */
elseif ($act == 'weixin_login')
{
	$user_name = !empty($_REQUEST['username']) ? $_GET['username'] : '';
	$pwd = !empty($_GET['pwd']) ? $_GET['pwd'] : '';
	$gourl = !empty($_GET['gourl']) ? $_GET['gourl'] : '';
	
	$remember = isset($_GET['remember']) ? $_GET['remember'] : 0;
	//记住用户名字
	if(!empty($remember)){
		setcookie("ECS[reuser_name]", $user_name, time() + 31536000, '/');
	}
	$reuser_name= isset($_COOKIE['ECS']['reuser_name']) ? $_COOKIE['ECS']['reuser_name'] : '';
	if(!empty($reuser_name)){
		$smarty->assign('reuser_name', $reuser_name);
	}
	
	if (empty($user_name) || empty($pwd))
	{
		ecs_header("Location:user.php\n");
		$login_faild = 1;
	}
	else
	{
		if ($user->check_user($user_name, $pwd) > 0)
		{
			$user->set_session($user_name);
			$user->set_cookie($user_name);
			update_user_info();
			//优化登陆跳转
			if($gourl){
				ecs_header("Location:$gourl\n");
				exit;
			}else{
				$sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') . " WHERE session_id = '" . SESS_ID . "' " . "AND parent_id = 0 AND is_gift = 0 AND rec_type = 0";
				if ($db->getOne($sql) > 0){
					ecs_header("Location:cart.php\n");
					exit;
				}else{
					ecs_header("Location:user.php\n");
					exit;
				}
			}
		}
		else
		{
			$login_faild = 1;
		}
	}
	$smarty->assign('login_faild', $login_faild);
	$smarty->display('login.dwt');
	exit;
}

elseif ($act == 'order_list')
{
	if(!$_SESSION['user_id']){
		$smarty->assign('footer', get_footer());
		$smarty->display('login.dwt');
		exit;
	}
	$record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('order_info'). " WHERE user_id = {$_SESSION['user_id']}");
	if ($record_count > 0){
		include_once(ROOT_PATH . 'includes/lib_transaction.php');
		$page_num = '10';
		$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$pages = ceil($record_count / $page_num);
		if ($page <= 0)
		{
			$page = 1;
		}
		if ($pages == 0)
		{
			$pages = 1;
		}
		if ($page > $pages)
		{
			$page = $pages;
		}
		$pagebar = get_wap_pager($record_count, $page_num, $page, 'user.php?act=order_list', 'page');
		$smarty->assign('pagebar' , $pagebar);
		/* 订单状态 */
		$_LANG['os'][OS_UNCONFIRMED] = '未确认';
		$_LANG['os'][OS_CONFIRMED] = '已确认';
		$_LANG['os'][OS_SPLITED] = '已确认';
		$_LANG['os'][OS_SPLITING_PART] = '已确认';
		$_LANG['os'][OS_CANCELED] = '已取消';
		$_LANG['os'][OS_INVALID] = '无效';
		$_LANG['os'][OS_RETURNED] = '退货';

		$_LANG['ss'][SS_UNSHIPPED] = '未发货';
		$_LANG['ss'][SS_PREPARING] = '配货中';
		$_LANG['ss'][SS_SHIPPED] = '已发货';
		$_LANG['ss'][SS_RECEIVED] = '收货确认';
		$_LANG['ss'][SS_SHIPPED_PART] = '已发货(部分商品)';
		$_LANG['ss'][SS_SHIPPED_ING] = '配货中'; // 已分单

		$_LANG['ps'][PS_UNPAYED] = '未付款';
		$_LANG['ps'][PS_PAYING] = '付款中';
		$_LANG['ps'][PS_PAYED] = '已付款';
		$_LANG['cancel'] = '取消订单';
		$_LANG['pay_money'] = '付款';
		$_LANG['view_order'] = '查看订单';
		$_LANG['received'] = '确认收货';
		$_LANG['ss_received'] = '已完成';
		$_LANG['confirm_received'] = '你确认已经收到货物了吗？';
		$_LANG['confirm_cancel'] = '您确认要取消该订单吗？取消后此订单将视为无效订单';

		$orders = get_user_orders($_SESSION['user_id'], $page_num, $page_num * ($page - 1));
		if (!empty($orders))
		{
			foreach ($orders as $key => $val)
			{
				$orders[$key]['total_fee'] = encode_output($val['total_fee']);
			}
		}
		//$merge  = get_user_merge($_SESSION['user_id']);

		$smarty->assign('orders', $orders);
	}
	$smarty->display('order_list.dwt');
	exit;
}
/* 订单详情 */
elseif($act=='order_detail'){
	if(!$_SESSION['user_id']){
		$smarty->display('login.dwt');
		exit;
	}
	$id= isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
	include_once(ROOT_PATH . 'includes/lib_transaction.php');
	include_once(ROOT_PATH . 'includes/lib_payment.php');
	include_once(ROOT_PATH . 'includes/lib_order.php');
	include_once(ROOT_PATH . 'includes/lib_clips.php');
	/* 订单详情 */
	$order = get_order_detail($id, $_SESSION['user_id']);

	if ($order === false)
	{
		exit("对不起，该订单不存在");
	}
	require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
	/* 订单商品 */
	$goods_list = order_goods2($id);
	if (empty($goods_list))
	{
	$tips = '<br><br>无效错误订单<br><br><a href=user.php?act=order_list class=red>返回我的订单</a>';
	$smarty->assign('tips', $tips);
	$smarty->display('order_done.dwt');
	exit();
	}
	foreach ($goods_list AS $key => $value)
	{
		$goods_list[$key]['market_price'] = price_format($value['market_price'], false);
		$goods_list[$key]['goods_price']  = price_format($value['goods_price'], false);
		$goods_list[$key]['subtotal']	 = price_format($value['subtotal'], false);
	}

	/* 订单 支付 配送 状态语言项 */
	$order['order_status'] = $_LANG['os'][$order['order_status']];
	$order['pay_status'] = $_LANG['ps'][$order['pay_status']];
	$order['shipping_status'] = $_LANG['ss'][$order['shipping_status']];
	$smarty->assign('order',	  $order);
	$smarty->assign('goods_list', $goods_list);
	$smarty->assign('lang',	   $_LANG);
	$smarty->assign('footer', get_footer());
	$smarty->display('order_info.dwt');
	exit();
}
/* 取消订单 */
elseif ($act == 'cancel_order')
{
	if(!$_SESSION['user_id']){
		$smarty->assign('footer', get_footer());
		$smarty->display('login.dwt');
		exit;
	}
	include_once(ROOT_PATH . 'includes/lib_transaction.php');
	include_once(ROOT_PATH . 'includes/lib_order.php');

	$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
	if (cancel_order($order_id, $_SESSION['user_id']))
	{
		ecs_header("Location: user.php?act=order_list\n");
		exit;
	}
}

/* 确认收货 */
elseif ($act == 'affirm_received')
{
	if(!$_SESSION['user_id']){
		$smarty->assign('footer', get_footer());
		$smarty->display('login.dwt');
		exit;
	}
	include_once(ROOT_PATH . 'includes/lib_transaction.php');

	$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
	$_LANG['buyer'] = '买家';
	if (affirm_received($order_id, $_SESSION['user_id']))
	{
		ecs_header("Location: user.php?act=order_list\n");
		exit;
	}

}

/* 个人资料页面 */
elseif ($act == 'profile')
{
	if(!$_SESSION['user_id']){
		$smarty->assign('footer', get_footer());
		$smarty->display('login.dwt');
		exit;
	}
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    $user_info = get_profile($user_id);
    /* 取出注册扩展字段 */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);

    $sql = 'SELECT reg_field_id, content ' .
           'FROM ' . $ecs->table('reg_extend_info') .
           " WHERE user_id = $user_id";
    $extend_info_arr = $db->getAll($sql);

    $temp_arr = array();
    foreach ($extend_info_arr AS $val)
    {
        $temp_arr[$val['reg_field_id']] = $val['content'];
    }

    foreach ($extend_info_list AS $key => $val)
    {
        switch ($val['id'])
        {
            case 1:     $extend_info_list[$key]['content'] = $user_info['msn']; break;
            case 2:     $extend_info_list[$key]['content'] = $user_info['qq']; break;
            case 3:     $extend_info_list[$key]['content'] = $user_info['office_phone']; break;
            case 4:     $extend_info_list[$key]['content'] = $user_info['home_phone']; break;
            case 5:     $extend_info_list[$key]['content'] = $user_info['mobile_phone']; break;
            default:    $extend_info_list[$key]['content'] = empty($temp_arr[$val['id']]) ? '' : $temp_arr[$val['id']] ;
        }
    }

    $smarty->assign('extend_info_list', $extend_info_list);

    /* 密码提示问题 */
    $smarty->assign('passwd_questions', $_LANG['passwd_questions']);

    $smarty->assign('profile', $user_info);
    $smarty->display('profile.dwt');
}

/* 修改个人资料的处理 */
elseif ($act == 'act_edit_profile')
{
	if(!$_SESSION['user_id']){
		$smarty->assign('footer', get_footer());
		$smarty->display('login.dwt');
		exit;
	}
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    $birthday = trim($_POST['birthdayYear']) .'-'. trim($_POST['birthdayMonth']) .'-'.
    trim($_POST['birthdayDay']);
    $email = trim($_POST['email']);
    $other['msn'] = $msn = isset($_POST['extend_field1']) ? trim($_POST['extend_field1']) : '';
    $other['qq'] = $qq = isset($_POST['extend_field2']) ? trim($_POST['extend_field2']) : '';
    $other['office_phone'] = $office_phone = isset($_POST['extend_field3']) ? trim($_POST['extend_field3']) : '';
    $other['home_phone'] = $home_phone = isset($_POST['extend_field4']) ? trim($_POST['extend_field4']) : '';
    $other['mobile_phone'] = $mobile_phone = isset($_POST['extend_field5']) ? trim($_POST['extend_field5']) : '';
    $sel_question = empty($_POST['sel_question']) ? '' : compile_str($_POST['sel_question']);
    $passwd_answer = isset($_POST['passwd_answer']) ? compile_str(trim($_POST['passwd_answer'])) : '';

    /* 更新用户扩展字段的数据 */
    $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有扩展字段的id
    $fields_arr = $db->getAll($sql);

    foreach ($fields_arr AS $val)       //循环更新扩展用户信息
    {
        $extend_field_index = 'extend_field' . $val['id'];
        if(isset($_POST[$extend_field_index]))
        {
            $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr(htmlspecialchars($_POST[$extend_field_index]), 0, 99) : htmlspecialchars($_POST[$extend_field_index]);
            $sql = 'SELECT * FROM ' . $ecs->table('reg_extend_info') . "  WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            if ($db->getOne($sql))      //如果之前没有记录，则插入
            {
                $sql = 'UPDATE ' . $ecs->table('reg_extend_info') . " SET content = '$temp_field_content' WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            }
            else
            {
                $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . " (`user_id`, `reg_field_id`, `content`) VALUES ('$user_id', '$val[id]', '$temp_field_content')";
            }
            $db->query($sql);
        }
    }

    /* 写入密码提示问题和答案 */
    if ($passwd_answer<>null || $sel_question<>null)
	{
        $sql = 'UPDATE ' . $ecs->table('users') . " SET `passwd_question`='$sel_question', `passwd_answer`='$passwd_answer'  WHERE `user_id`='" . $_SESSION['user_id'] . "'";
        $db->query($sql);
    }

    $profile  = array(
        'user_id'  => $user_id,
        'email'    => isset($_POST['email']) ? trim($_POST['email']) : '',
        'sex'      => isset($_POST['sex'])   ? intval($_POST['sex']) : 0,
        'birthday' => $birthday,
        'other'    => isset($other) ? $other : array()
        );


    if (edit_profile($profile))
    {
		echo"<SCRIPT LANGUAGE='javascript'>alert('".$_LANG['edit_profile_success']."');location.href='user.php'</SCRIPT>";
    }
    else
    {
        if ($user->error == ERR_EMAIL_EXISTS)
        {
            $msg = sprintf($_LANG['email_exist'], $profile['email']);
        }
        else
        {
            $msg = $_LANG['edit_profile_failed'];
        }
		echo"<SCRIPT LANGUAGE='javascript'>alert('".$msg."');history.go(-1);</SCRIPT>";
    }
}

/* 修改会员密码 */
elseif ($act == 'act_edit_password')
{
	if(!$_SESSION['user_id']){
		$smarty->assign('footer', get_footer());
		$smarty->display('login.dwt');
		exit;
	}
    include_once(ROOT_PATH . 'includes/lib_passport.php');

    $old_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : null;
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $comfirm_password = isset($_POST['comfirm_password']) ? trim($_POST['comfirm_password']) : '';
    $user_id      = isset($_POST['uid'])  ? intval($_POST['uid']) : $user_id;
    $code         = isset($_POST['code']) ? trim($_POST['code'])  : '';

    if (strlen($new_password) < 6 || strlen($comfirm_password) < 6 )
    {
    $f = 5;
 	$smarty->assign('f', $f);
    $smarty->display('profile.dwt');
    exit;
    } elseif (md5($new_password)<>md5($comfirm_password)){
    $f = 6;
 	$smarty->assign('f', $f);
    $smarty->display('profile.dwt');
    exit;
	}

    $user_info = $user->get_profile_by_id($user_id); //论坛记录

    if (($user_info && (!empty($code) && md5($user_info['user_id'] . $_CFG['hash_code'] . $user_info['reg_time']) == $code)) || ($_SESSION['user_id']>0 && $_SESSION['user_id'] == $user_id && $user->check_user($_SESSION['user_name'], $old_password)))
    {
		
        if ($user->edit_user(array('username'=> (empty($code) ? $_SESSION['user_name'] : $user_info['user_name']), 'old_password'=>$old_password, 'password'=>$new_password), empty($code) ? 0 : 1))
        {
			$sql="UPDATE ".$ecs->table('users'). "SET `ec_salt`='0' WHERE user_id= '".$user_id."'";
			$db->query($sql);
            $user->logout();
			$user->logout();
			$Loaction = 'user.php';
			ecs_header("Location: $Loaction\n");
        }
        else
        {
            $f = 4;
        }
    }
    else
    {
        $f = 4;
    }
	$smarty->assign('f', $f);
    $smarty->display('profile.dwt');
}

/* 退出会员中心 */
elseif ($act == 'logout')
{
	if (!isset($back_act) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
	{
		$back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? './index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
	}
	$user->logout();
	$Loaction = 'index.php';
	ecs_header("Location: $Loaction\n");

}
/* 显示会员注册界面 */
elseif ($act == 'register')
{
	if (!isset($back_act) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
	{
		$back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? './index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
	}
	//
	if($_SESSION['user_id'] > 0){
		echo '<meta http-equiv="refresh" content="0;URL='.$back_act.'" />';
		exit;
	}
	/* 取出注册扩展字段 */
	$sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 ORDER BY dis_order, id';
	$extend_info_list = $db->getAll($sql);
	$smarty->assign('extend_info_list', $extend_info_list);
	/* 密码找回问题 */
	$_LANG['passwd_questions']['friend_birthday'] = '我最好朋友的生日？';
	$_LANG['passwd_questions']['old_address']	 = '我儿时居住地的地址？';
	$_LANG['passwd_questions']['motto']		   = '我的座右铭是？';
	$_LANG['passwd_questions']['favorite_movie']  = '我最喜爱的电影？';
	$_LANG['passwd_questions']['favorite_song']   = '我最喜爱的歌曲？';
	$_LANG['passwd_questions']['favorite_food']   = '我最喜爱的食物？';
	$_LANG['passwd_questions']['interest']		= '我最大的爱好？';
	$_LANG['passwd_questions']['favorite_novel']  = '我最喜欢的小说？';
	$_LANG['passwd_questions']['favorite_equipe'] = '我最喜欢的运动队？';
	/* 密码提示问题 */
	$smarty->assign('passwd_questions', $_LANG['passwd_questions']);
	$smarty->assign('footer', get_footer());
	$smarty->display('user_passport.dwt');
}
/* 注册会员的处理 */
elseif ($act == 'act_register')
{
		include_once(ROOT_PATH . 'includes/lib_passport.php');

		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$password = isset($_POST['password']) ? trim($_POST['password']) : '';
		$email	= isset($_POST['email']) ? trim($_POST['email']) : '';
		$other['msn'] = isset($_POST['extend_field1']) ? $_POST['extend_field1'] : '';
		$other['qq'] = isset($_POST['extend_field2']) ? $_POST['extend_field2'] : '';
		$other['office_phone'] = isset($_POST['extend_field3']) ? $_POST['extend_field3'] : '';
		$other['home_phone'] = isset($_POST['extend_field4']) ? $_POST['extend_field4'] : '';
		$other['mobile_phone'] = isset($_POST['extend_field5']) ? $_POST['extend_field5'] : '';
		$sel_question = empty($_POST['sel_question']) ? '' : compile_str($_POST['sel_question']);
		$passwd_answer = isset($_POST['passwd_answer']) ? compile_str(trim($_POST['passwd_answer'])) : '';

		$back_act = isset($_POST['back_act']) ? trim($_POST['back_act']) : '';

		if (m_register($username, $password, $email, $other) !== false)
		{
			/*把新注册用户的扩展信息插入数据库*/
			$sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有自定义扩展字段的id
			$fields_arr = $db->getAll($sql);

			$extend_field_str = '';	//生成扩展字段的内容字符串
			foreach ($fields_arr AS $val)
			{
				$extend_field_index = 'extend_field' . $val['id'];
				if(!empty($_POST[$extend_field_index]))
				{
					$temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
					$extend_field_str .= " ('" . $_SESSION['user_id'] . "', '" . $val['id'] . "', '" . compile_str($temp_field_content) . "'),";
				}
			}
			$extend_field_str = substr($extend_field_str, 0, -1);

			if ($extend_field_str)	  //插入注册扩展数据
			{
				$sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . ' (`user_id`, `reg_field_id`, `content`) VALUES' . $extend_field_str;
				$db->query($sql);
			}

			/* 写入密码提示问题和答案 */
			if (!empty($passwd_answer) && !empty($sel_question))
			{
				$sql = 'UPDATE ' . $ecs->table('users') . " SET `passwd_question`='$sel_question', `passwd_answer`='$passwd_answer'  WHERE `user_id`='" . $_SESSION['user_id'] . "'";
				$db->query($sql);
			}

			$ucdata = empty($user->ucdata)? "" : $user->ucdata;
			$Loaction = 'index.php';
			ecs_header("Location: $Loaction\n");
		}
}
/* 增加收货地址 */
elseif ($act == 'add_address')
{
	include_once('includes/lib_transaction.php');        
	 /* 取得国家列表、商店所在国家、商店所在国家的省列表 */
	$smarty->assign('country_list',       get_regions());
	$smarty->assign('shop_country',       $_CFG['shop_country']);
	$smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));
    $consignee_list = get_consignee_list($_SESSION['user_id']);
	/* 取得每个收货地址的省市区列表 */
	$province_list = array();
	$city_list = array();
	$district_list = array();
	foreach ($consignee_list as $region_id => $consignee)
	{
		$consignee['country']  = isset($consignee['country'])  ? intval($consignee['country'])  : 0;
		$consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
		$consignee['city']     = isset($consignee['city'])     ? intval($consignee['city'])     : 0;

		$province_list = get_regions(1, $consignee['country']);
		$city_list     = get_regions(2, $consignee['province']);
		$district_list = get_regions(3, $consignee['city']);
	}
	$smarty->assign('province_list', $province_list);
	$smarty->assign('city_list',     $city_list);
	$smarty->assign('district_list', $district_list);	
	$smarty->assign('action', "user.php?act=add_edit_address");
	$smarty->assign('fun', 'add');
	$smarty->display('address_list.dwt');
}
/* 收货地址列表 */
elseif ($act == 'address_list')
{
	include_once('includes/lib_transaction.php');        
	 /* 取得国家列表、商店所在国家、商店所在国家的省列表 */
	$smarty->assign('country_list',       get_regions());
	$smarty->assign('shop_country',       $_CFG['shop_country']);
	$smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));
    $consignee_list = get_consignee_list($_SESSION['user_id']);
	/* 取得每个收货地址的省市区列表 */
	$province_list = array();
	$city_list = array();
	$district_list = array();
	foreach ($consignee_list as $region_id => $consignee)
	{
		$consignee['country']  = isset($consignee['country'])  ? intval($consignee['country'])  : 0;
		$consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
		$consignee['city']     = isset($consignee['city'])     ? intval($consignee['city'])     : 0;

		$province_list = get_regions(1, $consignee['country']);
		$city_list     = get_regions(2, $consignee['province']);
		$district_list = get_regions(3, $consignee['city']);
	}
	$smarty->assign('province_list', $province_list);
	$smarty->assign('city_list',     $city_list);
	$smarty->assign('district_list', $district_list);	
	$smarty->assign('consignee', $consignee_list);
    $smarty->assign('action', "user.php?act=act_edit_address");
    $smarty->assign('subval', '修改送货地址');
    $smarty->assign('fun', 'list');
    $smarty->display('address_list.dwt');
}
/*更新收获地址*/
elseif ($act == 'act_edit_address'){
	
	global $db;
	include_once('includes/lib_transaction.php');
	
	if(empty($_POST['country']) || empty($_POST['province']) || empty($_POST['city']) || empty($_POST['district']))
    {
        echo '<script language=javascript>alert("配送区域不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['address']))
    {
        echo '<script language=javascript>alert("收货地址不可为空！");history.go(-1);</script>';
        exit;
    }
	if(empty($_POST['consignee']))
    {
        echo '<script language=javascript>alert("收货人姓名不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['tel']))
    {
        echo '<script language=javascript>alert("联系电话不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['mobile']))
    {
        echo '<script language=javascript>alert("联系手机不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['email']))
    {
        echo '<script language=javascript>alert("电子邮箱不可为空！");history.go(-1);</script>';
        exit;
    }
	/*
	 * 保存收货人信息
	 */
	$consignee = array(
		'user_id'		=> $_SESSION['user_id'],
		'address_id'    => empty($_POST['address_id']) ? 0  : intval($_POST['address_id']),
		'consignee'     => empty($_POST['consignee'])  ? '' : trim($_POST['consignee']),
		'country'       => empty($_POST['country'])    ? '' : $_POST['country'],
		'province'      => empty($_POST['province'])   ? '' : $_POST['province'],
		'city'          => empty($_POST['city'])       ? '' : $_POST['city'],
		'district'      => empty($_POST['district'])   ? '' : $_POST['district'],
		'email'         => empty($_POST['email'])      ? '' : $_POST['email'],
		'address'       => empty($_POST['address'])    ? '' : $_POST['address'],
		'zipcode'       => empty($_POST['zipcode'])    ? '' : make_semiangle(trim($_POST['zipcode'])),
		'tel'           => empty($_POST['tel'])        ? '' : make_semiangle(trim($_POST['tel'])),
		'mobile'        => empty($_POST['mobile'])     ? '' : make_semiangle(trim($_POST['mobile'])),
		'sign_building' => empty($_POST['sign_building']) ? '' : $_POST['sign_building'],
		'best_time'     => empty($_POST['best_time'])  ? '' : $_POST['best_time'],
		'default_id'    => empty($_POST['default_id'])  ? '0' : $_POST['default_id'],
	);
	
	$result = update_address($consignee);
	
	$GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('user_address') . " SET default_id = 0 WHERE default_id != 1 ");
	
	if($result){
        echo '<script language=javascript>alert("修改收货地址成功");location.href="user.php?act=address_list";</script>';
	}
	else{
        echo '<script language=javascript>alert("修改失败");history.go(-1);</script>';
	}
	if ($_SESSION['user_id'] > 0)
    {
        $smarty->assign('user_name', $_SESSION['user_name']);
    }
}
/*增加收获地址*/
elseif ($act == 'add_edit_address'){
	
	global $db;
	include_once('includes/lib_transaction.php');
	
	if(empty($_POST['country']) || empty($_POST['province']) || empty($_POST['city']) || empty($_POST['district']))
    {
        echo '<script language=javascript>alert("配送区域不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['address']))
    {
        echo '<script language=javascript>alert("收货地址不可为空！");history.go(-1);</script>';
        exit;
    }
	if(empty($_POST['consignee']))
    {
        echo '<script language=javascript>alert("收货人姓名不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['tel']))
    {
        echo '<script language=javascript>alert("联系电话不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['mobile']))
    {
        echo '<script language=javascript>alert("联系手机不可为空！");history.go(-1);</script>';
        exit;
    }
    if(empty($_POST['email']))
    {
        echo '<script language=javascript>alert("电子邮箱不可为空！");history.go(-1);</script>';
        exit;
    }
	/*
	 * 保存收货人信息
	 */
	$consignee = array(
		'user_id'		=> $_SESSION['user_id'],
		'address_id'    => empty($_POST['address_id']) ? 0  : intval($_POST['address_id']),
		'consignee'     => empty($_POST['consignee'])  ? '' : trim($_POST['consignee']),
		'country'       => empty($_POST['country'])    ? '' : $_POST['country'],
		'province'      => empty($_POST['province'])   ? '' : $_POST['province'],
		'city'          => empty($_POST['city'])       ? '' : $_POST['city'],
		'district'      => empty($_POST['district'])   ? '' : $_POST['district'],
		'email'         => empty($_POST['email'])      ? '' : $_POST['email'],
		'address'       => empty($_POST['address'])    ? '' : $_POST['address'],
		'zipcode'       => empty($_POST['zipcode'])    ? '' : make_semiangle(trim($_POST['zipcode'])),
		'tel'           => empty($_POST['tel'])        ? '' : make_semiangle(trim($_POST['tel'])),
		'mobile'        => empty($_POST['mobile'])     ? '' : make_semiangle(trim($_POST['mobile'])),
		'sign_building' => empty($_POST['sign_building']) ? '' : $_POST['sign_building'],
		'best_time'     => empty($_POST['best_time'])  ? '' : $_POST['best_time'],
	);
	
	$result = update_address($consignee);
	if($result){
        echo '<script language=javascript>alert("增加收货地址成功");location.href="user.php?act=address_list";</script>';
	}
	else{
        echo '<script language=javascript>alert("增加收货地址失败");history.go(-1);</script>';
	}
	if ($_SESSION['user_id'] > 0)
    {
        $smarty->assign('user_name', $_SESSION['user_name']);
    }
}
/* 删除收货人信息*/
elseif ($act == 'drop_address')
{
	include_once('includes/lib_transaction.php');

	$consignee_id = intval($_GET['id']);

	if (drop_consignee($consignee_id))
	{
		ecs_header("Location: user.php?act=address_list\n");
		exit;
	}
}
/* 添加收藏商品(ajax) */
elseif ($act == 'collect')
{
	include_once(ROOT_PATH .'includes/cls_json.php');
	$json = new JSON();
	$result = array('error' => 0, 'message' => '');
	$goods_id = $_GET['id'];

	if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0)
	{
		$result['error'] = 1;
		$result['message'] = "由于您还没有登录，因此您还不能使用该功能。";
		die($json->encode($result));
	}
	else
	{
		/* 检查是否已经存在于用户的收藏夹 */
		$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('collect_goods') .
			" WHERE user_id='$_SESSION[user_id]' AND goods_id = '$goods_id'";
		if ($GLOBALS['db']->GetOne($sql) > 0)
		{
			$result['error'] = 1;
			$result['message'] = "该商品已经存在于您的收藏夹中。";
			die($json->encode($result));
		}
		else
		{
			$time = gmtime();
			$sql = "INSERT INTO " .$GLOBALS['ecs']->table('collect_goods'). " (user_id, goods_id, add_time)" .
					"VALUES ('$_SESSION[user_id]', '$goods_id', '$time')";

			if ($GLOBALS['db']->query($sql) === false)
			{
				$result['error'] = 1;
				$result['message'] = $GLOBALS['db']->errorMsg();
				die($json->encode($result));
			}
			else
			{
				$result['error'] = 0;
				$result['message'] = "该商品已经成功地加入了您的收藏夹。";
				die($json->encode($result));
			}
		}
	}
}
/* 用户中心 */
else
{
	if ($_SESSION['user_id'] > 0)
	{
		show_user_center();
	}
	else
	{
		$reuser_name= isset($_COOKIE['ECS']['reuser_name']) ? $_COOKIE['ECS']['reuser_name'] : '';
		if(!empty($reuser_name)){
			$smarty->assign('reuser_name', $reuser_name);
		}
		$smarty->assign('footer', get_footer());
		$smarty->display('login.dwt');
		exit;
	}
}

/**
 * 用户中心显示
 */
function show_user_center()
{
    include_once(ROOT_PATH .'includes/lib_clips.php');
	$best_goods = get_recommend_goods('best');
	if (count($best_goods) > 0)
	{
		foreach  ($best_goods as $key => $best_data)
		{
			$best_goods[$key]['shop_price'] = encode_output($best_data['shop_price']);
			$best_goods[$key]['name'] = encode_output($best_data['name']);
		}
	}
	//22:18 2013-7-16
	$rank_name = $GLOBALS['db']->getOne('SELECT rank_name FROM ' . $GLOBALS['ecs']->table('user_rank') . ' WHERE rank_id = '.$_SESSION['user_rank']);
	$GLOBALS['smarty']->assign('info', get_user_default($_SESSION['user_id']));
	$GLOBALS['smarty']->assign('rank_name', $rank_name);
	$GLOBALS['smarty']->assign('user_info', get_user_info());
	$GLOBALS['smarty']->assign('best_goods' , $best_goods);
	$GLOBALS['smarty']->assign('footer', get_footer());
	$GLOBALS['smarty']->display('user.dwt');
}

/**
 * 手机注册
 */
function m_register($username, $password, $email, $other = array())
{
	/* 检查username */
	if (empty($username))
	{
		echo '<script>alert("用户名必须填写！");window.location.href="user.php?act=register"; </script>';
		return false;
	}
	if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
	{
		echo '<script>alert("用户名错误！");window.location.href="user.php?act=register"; </script>';
		return false;
	}

	/* 检查是否和管理员重名 */
	if (admin_registered($username))
	{
		echo '<script>alert("此用户已存在！");window.location.href="user.php?act=register"; </script>';
		return false;
	}

	if (!$GLOBALS['user']->add_user($username, $password, $email))
	{
		echo '<script>alert("注册失败！");window.location.href="user.php?act=register"; </script>';
		//注册失败
		return false;
	}
	else
	{
		//注册成功

		/* 设置成登录状态 */
		$GLOBALS['user']->set_session($username);
		$GLOBALS['user']->set_cookie($username);
	}

		//定义other合法的变量数组
		$other_key_array = array('msn', 'qq', 'office_phone', 'home_phone', 'mobile_phone');
		$update_data['reg_time'] = local_strtotime(local_date('Y-m-d H:i:s'));
		if ($other)
		{
			foreach ($other as $key=>$val)
			{
				//删除非法key值
				if (!in_array($key, $other_key_array))
				{
					unset($other[$key]);
				}
				else
				{
					$other[$key] =  htmlspecialchars(trim($val)); //防止用户输入javascript代码
				}
			}
			$update_data = array_merge($update_data, $other);
		}
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'), $update_data, 'UPDATE', 'user_id = ' . $_SESSION['user_id']);

		update_user_info();	  // 更新用户信息
        $Loaction = 'user.php?act=user_center';
        ecs_header("Location: $Loaction\n");
		return true;

}
?>