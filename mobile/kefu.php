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
session_start();

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');
/* 载入语言文件 */

require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);
}

$smarty->assign('shop_name',     $GLOBALS['_CFG']['shop_name']);
$smarty->assign('shop_address',     $GLOBALS['_CFG']['shop_address']);
$smarty->assign('qq',     $GLOBALS['_CFG']['qq']);
$smarty->assign('ww',     $GLOBALS['_CFG']['ww']);
$smarty->assign('skype',     $GLOBALS['_CFG']['skype']);
$smarty->assign('ym',     $GLOBALS['_CFG']['ym']);
$smarty->assign('msn',     $GLOBALS['_CFG']['msn']);

$smarty->assign('service_email',     $GLOBALS['_CFG']['service_email']);
$smarty->assign('service_phone',     $GLOBALS['_CFG']['service_phone']);




/* 用户中心 */
//if ($_SESSION['user_id'] > 0){
//	$smarty->display('kefu.dwt');
//}else{
//	$smarty->assign('footer', get_footer());
//	$smarty->display('login.dwt');
//}
$smarty->display('kefu.dwt');

?>