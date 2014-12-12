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
 * $Author: testyang $
 * $Id: goods.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'mobile/includes/lib_wxch.php');

$goods_id = !empty($_GET['id']) ? intval($_GET['id']) : '';
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);

}
/*------------------------------------------------------ */
//-- 改变属性、数量时重新计算商品价格
/*------------------------------------------------------ */

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'price')
{
    include('includes/cls_json.php');

    $json   = new JSON;
    $res    = array('err_msg' => '', 'result' => '', 'qty' => 1);

    $attr_id    = isset($_REQUEST['attr']) ? explode(',', $_REQUEST['attr']) : array();
    $number     = (isset($_REQUEST['number'])) ? intval($_REQUEST['number']) : 1;

    if ($goods_id == 0)
    {
        $res['err_msg'] = "没有找到指定的商品或者没有找到指定的商品属性。";
        $res['err_no']  = 1;
    }
    else
    {
        if ($number == 0)
        {
            $res['qty'] = $number = 1;
        }
        else
        {
            $res['qty'] = $number;
        }

        $shop_price  = get_final_price($goods_id, $number, true, $attr_id);
        $res['result'] = price_format($shop_price * $number);
    }

    die($json->encode($res));
}

$_LANG['kilogram'] = '千克';
$_LANG['gram'] = '克';
$_LANG['home'] = '首页';
$_LANG['goods_attr'] = '';
$smarty->assign('goods_id', $goods_id);
$goods_info = get_goods_info($goods_id);
if ($goods_info === false)
{
   /* 如果没有找到任何记录则跳回到首页 */
   ecs_header("Location: ./\n");
   exit;
}
$goods_info['goods_name'] = encode_output($goods_info['goods_name']);
$goods_info['goods_brief'] = encode_output($goods_info['goods_brief']);
$goods_info['promote_price'] = encode_output($goods_info['promote_price']);
$goods_info['market_price'] = encode_output($goods_info['market_price']);
$goods_info['shop_price'] = encode_output($goods_info['shop_price']);
$goods_info['shop_price_formated'] = encode_output($goods_info['shop_price_formated']);
$goods_info['goods_number'] = encode_output($goods_info['goods_number']);
$smarty->assign('goods_info', $goods_info);
$shop_price   = $goods_info['shop_price'];
$smarty->assign('rank_prices',		 get_user_rank_prices($goods_id, $shop_price));	// 会员等级价格
$smarty->assign('goods_info2',		 get_goods_info2($goods_id));
$smarty->assign('related_goods',		 get_linked_goods($goods_id));
        $properties = get_goods_properties($goods_id);  // 获得商品的规格和属性

        $smarty->assign('properties',          $properties['pro']);                              // 商品属性
$smarty->assign('footer', get_footer());

/* 查看商品图片操作 */
if ($act == 'view_img')
{
	$smarty->assign('goods_desc' , $goods_info['goods_desc']);
	$smarty->display('goods_img.dwt');
	exit();
}

/* 检查是否有商品品牌 */
if (!empty($goods_info['brand_id']))
{
	$brand_name = $db->getOne("SELECT brand_name FROM " . $ecs->table('brand') . " WHERE brand_id={$goods_info['brand_id']}");
	$smarty->assign('brand_name', encode_output($brand_name));
}
/* 显示分类名称 */
$cat_array = get_parent_cats($goods_info['cat_id']);
krsort($cat_array);
$cat_str = '';
foreach ($cat_array as $key => $cat_data)
{
	$cat_array[$key]['cat_name'] = encode_output($cat_data['cat_name']);
	$cat_str .= "<a href='category.php?c_id={$cat_data['cat_id']}'>" . encode_output($cat_data['cat_name']) . "</a>-&gt;";
}
$smarty->assign('cat_array', $cat_array);


$properties = get_goods_properties($goods_id);  // 获得商品的规格和属性
$smarty->assign('specification',	   $properties['spe']);  // 商品规格


$comment = assign_comment($goods_id, 0);
$smarty->assign('comment', $comment);

$goods_gallery = get_goods_gallery($goods_id);
$smarty->assign('picturesnum', count($goods_gallery));// 相册数
$smarty->assign('pictures', $goods_gallery);// 商品相册
$smarty->assign('now_time',  gmtime()); // 当前系统时间
$smarty->display('goods.dwt');

/**
 * 获得指定商品的各会员等级对应的价格
 *
 * @access  public
 * @param   integer	 $goods_id
 * @return  array
 */
function get_user_rank_prices($goods_id, $shop_price)
{
	$sql = "SELECT rank_id, IFNULL(mp.user_price, r.discount * $shop_price / 100) AS price, r.rank_name, r.discount " .
			'FROM ' . $GLOBALS['ecs']->table('user_rank') . ' AS r ' .
			'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . " AS mp ".
				"ON mp.goods_id = '$goods_id' AND mp.user_rank = r.rank_id " .
			"WHERE r.show_price = 1 OR r.rank_id = '$_SESSION[user_rank]'";
	$res = $GLOBALS['db']->query($sql);

	$arr = array();
	while ($row = $GLOBALS['db']->fetchRow($res))
	{

		$arr[$row['rank_id']] = array(
						'rank_name' => htmlspecialchars($row['rank_name']),
						'price'	 => price_format($row['price']));
	}

	return $arr;
}


?>