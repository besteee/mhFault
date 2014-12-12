<?php

/**
 * ECSHOP 商品分类页
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: testyang $
 * $Id: category.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');

$c_id = !empty($_GET['c_id']) ? intval($_GET['c_id']) : 0;
$get_sort  = !empty($_REQUEST['sort']) ? $_GET['sort'] : 'goods_id';
$get_order  = !empty($_REQUEST['order']) ? $_GET['order'] : 'DESC';

if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);

}
if ($c_id <= 0)
{
	$pcat_array = get_categories_tree();
	if (!empty($pcat_array))
	{
		foreach ($pcat_array as $key => $pcat_data)
		{
			$pcat_array[$key]['name'] = encode_output($pcat_data['name']);
			if ($pcat_data['cat_id'])
			{
				foreach ($pcat_data['cat_id'] as $k => $v)
				{
					$pcat_array[$key]['cat_id'][$k]['name'] = encode_output($v['name']);
				}
			}
		}
		$smarty->assign('cat_array' , $pcat_array);
		$smarty->assign('all_cat' , 1);
	}
}
else
{
	$cat_array = get_categories_tree($c_id);
	$smarty->assign('c_id', $c_id);
	$cat_name = $db->getOne('SELECT cat_name FROM ' . $ecs->table('category') . ' WHERE cat_id=' . $c_id);
	$smarty->assign('cat_name', encode_output($cat_name));
	if (!empty($cat_array[$c_id]['cat_id']))
	{
		foreach ($cat_array[$c_id]['cat_id'] as $key => $child_data)
		{
			$cat_array[$c_id]['cat_id'][$key]['name'] = encode_output($child_data['name']);
		}
		$smarty->assign('cat_children', $cat_array[$c_id]['cat_id']);
	}

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

	$cat_goods = assign_cat_goods($c_id, 0, 'wap', $order_rule);
	$num = count($cat_goods['goods']);
	if ($num > 0)
	{
		$page_num = '6';
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
		foreach ($cat_goods['goods'] as $goods_data)
		{
			if (($i > ($page_num * ($page - 1 ))) && ($i <= ($page_num * $page)))
			{
				$price = !empty($goods_data['promote_price']) ? $goods_data['promote_price'] : $goods_data['shop_price'];
				//$wml_data .= "<a href='goods.php?id={$goods_data['id']}'>".encode_output($goods_data['name'])."</a>[".encode_output($price)."]<br/>";
				$data[] = array('i' => $i , 'price' => encode_output($price) , 'id' => $goods_data['id'] , 'name' => encode_output($goods_data['name']), 'thumb' => $goods_data['thumb'], 'goods_img' => $goods_data['goods_img']);//16:41 2013-07-16
			}
			$i++;
		}
		$smarty->assign('goods_data', $data);
		$pagebar = get_wap_pager($num, $page_num, $page, 'category.php?c_id='.$c_id.'&sort='.(empty($get_sort)?0:$get_sort).'&order='.(empty($get_order)?0:$get_order), 'page');
		$smarty->assign('pagebar', $pagebar);
	}

	$pcat_array = get_parent_cats($c_id);
	if (!empty($pcat_array[1]['cat_name']))
	{
		$pcat_array[1]['cat_name'] = encode_output($pcat_array[1]['cat_name']);
		$smarty->assign('pcat_array', $pcat_array[1]);
	}

	$smarty->assign('cat_array', $cat_array);
}
$smarty->assign('sort', $get_sort);
$smarty->assign('order', $get_order);
$smarty->assign('footer', get_footer());
$smarty->assign('footer', get_footer());
$smarty->display('category.dwt');

?>