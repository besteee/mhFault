<?php
/** 完美实现qq帐号登录ecshop插件
 * $Author: phplife qq:40499756 914091457 email:admin@topit.cn ydhcxh@126.com $
 * 版权所有 2010-2020 顶亿网，并保留所有权利。
 * 网站地址: http://www.topit.cn
 * 插件安装说明:http://ecshop.topit.cn/ecshop-plugin/ecshop_login_with_qq_account_v2.0-233.html
 * 插件会不断更新 新版下载发布地址：http://bbs.topit.cn/thread-829-1-1.html
 * 此插件您可以自由使用，但请保留此开发者的相关信息，
*/
define('IN_ECS', true);
require_once('../../includes/init.php');
define('API_PATH', rtrim(str_replace('\\', '/', dirname(__FILE__)),'/').'/');
require_once(API_PATH . 'api_func.php');
$api_name = get_app_name();
$api_tpl = 'api_tpl.lbi';
$api_url = rtrim($ecs->url(),'/');
$site_url = str_replace('/api/'.$api_name,'',$api_url);
/***
define("QQDEBUG", true);
if (defined("QQDEBUG") && QQDEBUG)
{
    @ini_set("error_reporting", E_ALL);
    @ini_set("display_errors", TRUE);
}
***/
$smarty->direct_output = true;
$smarty->force_compile = true;
$smarty->template_dir   = ROOT_PATH . 'api/'.$api_name;

$act = isset($_REQUEST['act'] )? trim($_REQUEST['act']):'';

if(!file_exists( ROOT_PATH . '/data/' . $api_name . '_config.php'))
{
  
  if(!in_array($act,array('login','act_login','config','')))
  { 
	 show_api_message($api_name.'配文件丢失，请先配置后再使用!','配置'.$api_name.'接口参数', $php_self .'?act=config', 'error');  
  }
  $api_config =array();
}
else
{
   $api_config = api_read_static_cache($api_name .'_config');
}

$smarty->assign('act', $act);
$smarty->assign('api_url', $api_url);
$smarty->assign('site_url', $site_url);

if($act =='login')
{
        if ((intval($_CFG['captcha']) & CAPTCHA_ADMIN) && gd_version() > 0)
		{
			$smarty->assign('gd_version', gd_version());
			$smarty->assign('random',     mt_rand());
		}
		die($smarty->fetch($api_tpl));
		break;
}

elseif($act =='act_login')
{
        require_once(ROOT_PATH . ADMIN_PATH .'/includes/lib_main.php');
		if (!empty($_SESSION['captcha_word']) && (intval($_CFG['captcha']) & CAPTCHA_ADMIN))
		{
			include_once(ROOT_PATH . 'includes/cls_captcha.php');

			/* 检查验证码是否正确 */
			$validator = new captcha();
			if (!empty($_POST['captcha']) && !$validator->check_word($_POST['captcha']))
			{
				show_api_message('验证码错误','管理员登录', $php_self.'?act=login','error');
			}
		}

		$_POST['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
		$_POST['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';

		$sql="SELECT * FROM ". $ecs->table('admin_user') ."WHERE user_name = '" . $_POST['username']."'";
		$admin_user =$db->getRow($sql);

		$is_suc =  isset($admin_user['ec_salt'])?  $admin_user['password'] ==md5(md5($_POST['password']).$admin_user['ec_salt']):$admin_user['password']==md5($_POST['password']);
		if ($is_suc)
		{
			// 检查是否为供货商的管理员 所属供货商是否有效
			if (!empty($row['suppliers_id']))
			{
				$supplier_is_check = suppliers_list_info(' is_check = 1 AND suppliers_id = ' . $admin_user['suppliers_id']);
				if (empty($supplier_is_check))
				{
					show_api_message('您输入的帐号暂时不可用。', '管理员登录', $php_self.'?act=login','error');
				}
			}

			// 登录成功
			set_admin_session($admin_user['user_id'], $admin_user['user_name'], $admin_user['action_list'], $admin_user['last_login']);
			$_SESSION['suppliers_id'] = $admin_user['suppliers_id'];


			// 更新最后登录时间和IP
			$db->query("UPDATE " .$ecs->table('admin_user').
					 " SET last_login='" . gmtime() . "', last_ip='" . real_ip() . "'".
					 " WHERE user_id='$_SESSION[admin_id]'");

			show_api_message('登录成功', '开始配置接口参数', $php_self.'?act=config','info');
		}
		else
		{
			show_api_message('登录失败', '重新登录', $php_self.'?act=login','error');
		}
		break;
}

elseif($act =='config')
{
	  if(! check_privilege())
	    {
	      show_api_message('登录后才能配置接口参数','管理员登录', $php_self.'?act=login','error');
	    }
		if(isset($_POST['submit']))
	    {
		   if(empty($_POST['qq_appid']) || empty($_POST['qq_appkey']))
			{
		      show_api_message('参数不能为空','重新配置', $php_self.'?act=config','error');
		   }
		   $arr = array();
		   $arr['qq_appid'] = trim($_POST['qq_appid']);
		   $arr['qq_appkey'] = trim($_POST['qq_appkey']);
		   $arr['qqconnect_allow'] = intval($_POST['qqconnect_allow']);
		   $arr['qq_bind_type'] = intval($_POST['qq_bind_type']);
		   $arr['qq_user_rank'] = intval($_POST['qq_user_rank']);
		   $arr['qq_allow_weibo'] = intval($_POST['qq_allow_weibo']);
		   $arr['qq_allow_space'] = intval($_POST['qq_allow_space']);

		   $field_names = $db->getCol('DESC ' . $ecs->table('users'));
		   if(!in_array('nick_name', $field_names))
		   {
		     $db->query("alter table " . $ecs->table('users') . " add nick_name varchar(120) not null default '' ");
			 $db->query("alter table " . $ecs->table('users') . " add index nick_name (nick_name) ");
		   }

		   if(!in_array('qq_openid', $field_names))
		   {
		     $db->query("alter table " . $ecs->table('users') . " add qq_openid varchar(64) not null default '' ");
			 $db->query("alter table " . $ecs->table('users') . " add index qq_openid (qq_openid) ");
		   }
		   
		   api_write_static_cache($api_name .'_config',$arr);
           show_api_message('配置成功','查看本置参数', $php_self.'?act=config','error');
		}         
		$smarty->assign('api_config', $api_config);

		$sql = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
		$rs = $db->query($sql);
		$ranks = array();
		while ($row = $db->fetchRow($rs))
		{
			$ranks[$row['rank_id']] = $row['rank_name'];
		}
		$smarty->assign('user_ranks',   $ranks);
        die($smarty->fetch($api_tpl));

}
elseif($act =='login_callback')
{
	

	require(API_PATH . "qq_func.php");
	require(API_PATH . "init_config.php");
	//QQ登录成功后的回调地址,主要保存access token
    
	qq_callback();

	//获取用户标示id
	get_openid();
	if(empty($_SESSION["openid"]))
	{
	  die('get openid error');
	}
	$qq_user = get_qq_user_info();

	if($qq_user && $qq_user['ret']==0 && !empty($_SESSION['openid']))
	{
			
		    
			$qq_user_info = $db->getRow("select user_id, user_name from " . $ecs->table('users') . " where   qq_openid='$_SESSION[openid]' ");
            if(! $qq_user_info)
			{
			        include_once(ROOT_PATH . 'includes/lib_passport.php');
					require(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/user.php');
                    $j=20;
					do
				    {
						$username = 'qq';
						for($i = 0; $i < 12; $i++)
						{
							$username .= mt_rand(0, 9);
						}
						$j--;
					}while( $db->getOne("select count(*) from " . $ecs->table('users'). " where user_name='$username' ") && $j>0);

					$password = md5(gmtime());
					$email    = $username .'@temp.com';

					if (register($username, $password, $email) !== false)
					{ 
                        $qq_openid = $_SESSION['openid'];
						$nick_name    = addslashes($qq_user['nickname']);
						$reg_time = gmtime();
						$ip       = real_ip();					
						$sex = $qq_user['gender'] =='男'?1:( $qq_user['gender'] == '女' ? 2 : 0 );
						$fld_rank ='';
						if(!empty($api_config['qq_user_rank'])) $fld_rank = "`user_rank`='$api_config[qq_user_rank]', ";
						$db->query ( ' update  ' . $ecs->table ( "users" ) . " set `qq_openid`='$qq_openid', $fld_rank `nick_name`='$nick_name', `reg_time`='$reg_time', `last_ip`='$ip', `sex`='$sex' where user_id='{$_SESSION[user_id]}'");
						$user_id   = $_SESSION['user_id'];
						$user_name = $username;
					}
					else
				    {
						show_api_message('用qq帐号登录失败', '回到网站首页', $site_url,'error');
					}
					
								   
			}
		    else
			{
			         $user_id = $qq_user_info['user_id'];
					 $user_name = $qq_user_info['user_name'];
					 update_user_info ();
			         recalculate_price ();
			}
			$sex = $qq_user['gender'] =='男'?1:( $qq_user['gender'] == '女' ? 2 : 0 );
			$db->query ( ' update ' . $ecs->table ( "users" ) . " set nick_name='" . addslashes($qq_user['nickname']) . "', sex='$sex' where user_id='$user_id' " );
			$time = gmtime() + 3600 * 24 * 30;
			setcookie("ECS[qq_nickname]",  $qq_user['nickname'],   $time, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
            setcookie("ECS[qq_vip]",  $qq_user['vip'],   $time, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
			setcookie("ECS[qq_level]",  $qq_user['level'],   $time, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
            setcookie("ECS[qq_figureurl]", $qq_user['figureurl'], $time, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
			setcookie("ECS[qq_figureurl_1]", $qq_user['figureurl_1'], $time, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
			setcookie("ECS[qq_figureurl_2]", $qq_user['figureurl_2'], $time, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
			$_SESSION['user_id'] = $user_id;
			$GLOBALS ['user']->set_session( $user_name );
			$GLOBALS ['user']->set_cookie($user_name, true);
			if(empty($qq_user_info) &&  $api_config['qq_bind_type'] ==1)
		    {
               header("Location: interface.php?act=qq_bind_user");
			   die();
			}

			if(isset($_SESSION['qq_login_from_url']) && !empty($_SESSION['qq_login_from_url']))
			{
			   if(strpos($_SESSION['qq_login_from_url'],'flow.php') !==false )
			   {
			     header("Location: /flow.php?step=checkout");
				 die();
			   }
			   if(strpos($_SESSION['qq_login_from_url'],'user.php?act=logout') !==false )
			   {
			     header("Location: /index.php");
				 die();
			   }
			   header("Location: ".$_SESSION['qq_login_from_url']);
			}
			else
			{
			   header("Location: ".$site_url .'/index.php');
			   exit;
			}
	}
	else 
	{
			# For testing purposes, if there was an error, let's kill the script
			if(isset($qq_user['vip']))
		    {
			   show_api_message($qq_user['msg'], '回到网站首页', $site_url,'error');
			}
			die();
	}
}
elseif($act =='qq_bind_user')
{
   /* 载入语言文件 */
   require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
   include_once(ROOT_PATH . 'includes/lib_passport.php');
   if(empty($_SESSION["openid"]))
   {
      show_api_message('非法的绑定操作', '回到网站首页', $site_url,'error');
   }
   $qq_user_info = $db->getRow("select user_id, user_name, qq_openid, nick_name, sex, user_rank from " . $ecs->table('users') . " where   user_id='$_SESSION[user_id]' ");
   if(isset($_REQUEST['by_login']) && $_REQUEST['by_login'] != '')
   {
   
   

   }
   if(isset($_REQUEST['by_reg']) && $_REQUEST['by_reg'] != '')
   {
        
		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $email    = isset($_POST['email']) ? trim($_POST['email']) : '';

		if (strlen($username) < 3)
        {
            show_api_message($_LANG['passport_js']['username_shorter']);
        }

        if (strlen($password) < 6)
        {
            show_api_message($_LANG['passport_js']['password_shorter']);
        }

        if (strpos($password, ' ') > 0)
        {
            show_api_message($_LANG['passwd_balnk']);
        }		

		/* 验证码检查 */
        if ((intval($_CFG['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0)
        {
            if (empty($_POST['captcha']))
            {
                show_api_message($_LANG['invalid_captcha'], $_LANG['sign_up'], $api_url.'/intefrace.php?act=qq_bind_user', 'error');
            }

            /* 检查验证码 */
            include_once('includes/cls_captcha.php');

            $validator = new captcha();
            if (!$validator->check_word($_POST['captcha']))
            {
                show_api_message($_LANG['invalid_captcha'], $_LANG['sign_up'], $api_url.'/intefrace.php?act=qq_bind_user', 'error');
            }
        }

		if (register($username, $password, $email, array()) !== false)
        {
            $sql = 'UPDATE ' . $ecs->table('users') . " SET `qq_openid`='$qq_user_info[qq_openid]', `nick_name`='$qq_user_info[nick_name]', `sex`='$qq_user_info[sex]', user_rank='$qq_user_info[user_rank]' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
			 /* 通过插件来删除用户 */
			$users =& init_users();
			$users->remove_user($qq_user_info['user_name']); //已经删除用户所有数据
			/* 判断是否需要自动发送注册邮件 */
            if ($GLOBALS['_CFG']['member_email_validate'] && $GLOBALS['_CFG']['send_verify_email'])
            {
                send_regiter_hash($_SESSION['user_id']);
            }
            $ucdata = empty($user->ucdata)? "" : $user->ucdata;
            show_api_message(sprintf($_LANG['register_success'], $username . $ucdata), array('回到网站首页', $_LANG['profile_lnk']), array($site_url, $site_url.'/user.php'), 'info');
		}
		else
	    {
		  show_api_message('注册失败', '重新注册绑定', $api_url.'/intefrace.php?act=qq_bind_user','error');  
		}
   
   }
   
   if(empty($qq_user_info) || empty($qq_user_info['qq_openid']))
   {
      show_api_message('用户信息错误或非qq登录会员', '回到网站首页', $site_url,'error');
   }
   
   $smarty->assign('template_dir',   $_CFG['template']);
   $smarty->assign('lang',       $_LANG);
   die($smarty->fetch($api_tpl));
}
else
{
   if(empty($api_config['qq_appid']) || empty($api_config['qq_appkey']))
   {
     die('配置文件丢失,请联系网站管理员,电话:' .$_CFG['service_phone'].',email:'.$_CFG['service_email']);
   }
   if(! $api_config['qqconnect_allow'])
   {
      show_api_message('qq登录已关闭', '回到网站首页', $site_url,'error');
   }
   require(API_PATH . "qq_func.php");
   require(API_PATH . "init_config.php");
   
   $_SESSION['qq_login_from_url'] = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
   //用户点击qq登录按钮调用此函数
   qq_login($_SESSION["appid"], $_SESSION["scope"], $_SESSION["callback"]);
}
?>
