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
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);
}
/* 载入语言文件 */

require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
$user_id = $_SESSION['user_id'] ? $_SESSION['user_id'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';

/* 用户中心 */
if ($user_id <= 0){
	$smarty->assign('footer', get_footer());
	$smarty->assign('gourl', "favorites.php");
	$smarty->display('login.dwt');
	exit;
}
/* 删除收藏的商品 */
if ($act == 'delete_collection'){
	include_once(ROOT_PATH . 'includes/lib_clips.php');

	$collection_id = isset($_GET['collection_id']) ? intval($_GET['collection_id']) : 0;

	if ($collection_id > 0){
		$db->query('DELETE FROM ' .$ecs->table('collect_goods'). " WHERE rec_id='$collection_id' AND user_id ='$user_id'" );
	}
	$smarty->assign('fav_faild', 1);
	$smarty->assign('tips', '该商品已从收藏夹中删除！');
}

include_once(ROOT_PATH . 'includes/lib_clips.php');
$record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('collect_goods'). " WHERE user_id='$user_id' ORDER BY add_time DESC");
if($record_count){
	$page_num = '10';
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
	$pagebar = get_wap_pager($record_count, $page_num, $page, 'favorites.php', 'page');
	$smarty->assign('pagebar' , $pagebar);

	$pagebar = get_wap_pager($record_count, $page_num, $page, 'user.php?act=order_list', 'page');
	$goods_list = get_m_collection_goods($user_id, $page_num, $page_num * ($page - 1));
	$smarty->assign('goods_list', $goods_list);
}
$smarty->display('favorites.dwt');

/**
 *  获取指定用户的收藏商品列表
 *
 * @access  public
 * @param   int	 $user_id		用户ID
 * @param   int	 $num			列表最大数量
 * @param   int	 $start		  列表其实位置
 *
 * @return  array   $arr
 */
function get_m_collection_goods($user_id, $num = 10, $start = 0){
	$sql = 'SELECT g.goods_thumb, g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price, '.
				"IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
				'g.promote_price, g.promote_start_date,g.promote_end_date, c.rec_id, c.is_attention' .
			' FROM ' . $GLOBALS['ecs']->table('collect_goods') . ' AS c' .
			" LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ".
				"ON g.goods_id = c.goods_id ".
			" LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
				"ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
			" WHERE c.user_id = '$user_id' ORDER BY c.rec_id DESC";
	$res = $GLOBALS['db'] -> selectLimit($sql, $num, $start);

	$goods_list = array();
	while ($row = $GLOBALS['db']->fetchRow($res)){
		if ($row['promote_price'] > 0){
			$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
		}else{
			$promote_price = 0;
		}

		$goods_list[$row['goods_id']]['rec_id']			= $row['rec_id'];
		$goods_list[$row['goods_id']]['goods_thumb']	= $row['goods_thumb'];
		$goods_list[$row['goods_id']]['is_attention']	= $row['is_attention'];
		$goods_list[$row['goods_id']]['goods_id']		= $row['goods_id'];
		$goods_list[$row['goods_id']]['goods_name']		= $row['goods_name'];
		$goods_list[$row['goods_id']]['market_price']	= price_format($row['market_price']);
		$goods_list[$row['goods_id']]['shop_price']		= price_format($row['shop_price']);
		$goods_list[$row['goods_id']]['promote_price']	= ($promote_price > 0) ? price_format($promote_price) : '';
		$goods_list[$row['goods_id']]['url']			= build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
	}
	return $goods_list;
}
?>