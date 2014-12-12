<?php

/**
 * ECSHOP 品牌专区
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: testyang $
 * $Id: brands.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);
}
$b_id = !empty($_GET['b_id']) ? intval($_GET['b_id']) : 0;
$get_sort  = !empty($_REQUEST['sort']) ? $_GET['sort'] : 'goods_id';
$get_order  = !empty($_REQUEST['order']) ? $_GET['order'] : 'DESC';
if ($b_id > 0)
{
    if ($get_sort == 'shop_price' && $get_order == 'DESC')
    {
       $order_rule = 'ORDER BY g.shop_price DESC, g.sort_order';
    }
    elseif($get_sort == 'shop_price' && $get_order == 'ASC')
    {
       $order_rule = 'ORDER BY g.shop_price ASC, g.sort_order';
    }
	elseif($get_sort == 'click_count' && $get_order == 'DESC')
	{
       $order_rule = 'ORDER BY g.click_count DESC, g.sort_order';
	}
	elseif($get_sort == 'click_count' && $get_order == 'ASC')
	{
       $order_rule = 'ORDER BY g.click_count ASC, g.sort_order';
	}
	elseif($get_sort == 'goods_id' && $get_order == 'DESC')
	{
       $order_rule = 'ORDER BY g.goods_id DESC, g.sort_order';
	}
	elseif($get_sort == 'goods_id' && $get_order == 'ASC')
	{
       $order_rule = 'ORDER BY g.goods_id ASC, g.sort_order';
	}
	else
	{
       $order_rule = 'ORDER BY g.goods_id desc, g.sort_order';
	}
	$brands_array = assign_brand_goods($b_id, 0, 0, $order_rule);
	$brands_array['brand']['name'] = encode_output($brands_array['brand']['name']);
	$smarty->assign('brands_array' , $brands_array);
	$num = count($brands_array['goods']);
	if ($num > 0)
	{
		$page_num = '10';
		$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$pages = ceil($num / $page_num);
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
		$i = 1;
		foreach ($brands_array['goods'] as $goods_data)
		{
			if (($i > ($page_num * ($page - 1 ))) && ($i <= ($page_num * $page)))
			{
				$price = empty($goods_info['promote_price_org']) ? $goods_data['shop_price'] : $goods_data['promote_price'];
				$data[] = array('i' => $i , 'price' => encode_output($price) , 'id' => $goods_data['id'] , 'name' => encode_output($goods_data['name']), 'thumb' => $goods_data['thumb'], 'goods_img' => $goods_data['goods_img']);// 10:34 2013-7-27
			}
			$i++;
		}
		$smarty->assign('goods_data', $data);
		$pagebar = get_wap_pager($num, $page_num, $page, 'brands.php?b_id=' . $b_id.'&sort='.(empty($get_sort)?0:$get_sort).'&order='.(empty($get_order)?0:$get_order), 'page');
		$smarty->assign('pagebar', $pagebar);
	}
}

$brands_array = get_brands();
if (count($brands_array) > 1){
	foreach ($brands_array as $key => $brands_data){
		$brands_array[$key]['brand_name'] =  encode_output($brands_data['brand_name']);
	}
	$smarty->assign('brand_id', $b_id);
	$smarty->assign('other_brands', $brands_array);
}

$smarty->assign('sort', $get_sort);
$smarty->assign('order', $get_order);
$smarty->assign('footer', get_footer());
$smarty->display('brands.dwt');

?>