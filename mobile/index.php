<?php

/**
 * ECSHOP mobile首页
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: index.php 15013 2010-03-25 09:31:42Z liuhui $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'mobile/includes/lib_wxch.php');

/* 推荐商品 */
$best_goods = get_recommend_goods_wap('best',10);
$best_num = count($best_goods);
$smarty->assign('best_num' , $best_num);
if ($best_num > 0)
{
    $i = 0;
    foreach  ($best_goods as $key => $best_data)
    {
        $best_goods[$key]['shop_price'] = encode_output($best_data['shop_price']);
        $best_goods[$key]['name'] = encode_output($best_data['name']);
        /*if ($i > 2)
        {
            break;
        }*/
        $i++;
    }
    $smarty->assign('best_goods' , $best_goods);
}

/* 热门商品 */
$hot_goods = get_recommend_goods('hot');
$hot_num = count($hot_goods);
$smarty->assign('hot_num' , $hot_num);
if ($hot_num > 0)
{
    $i = 0;
    foreach  ($hot_goods as $key => $hot_data)
    {
        $hot_goods[$key]['shop_price'] = encode_output($hot_data['shop_price']);
        $hot_goods[$key]['name'] = encode_output($hot_data['name']);
        /*if ($i > 2)
        {
            break;
        }*/
        $i++;
    }
    $smarty->assign('hot_goods' , $hot_goods);
}

/* 最新商品 */
$new_goods = get_recommend_goods('new');
$new_num = count($new_goods);
$smarty->assign('new_num' , $new_num);
if ($new_num > 0)
{
    $i = 0;
    foreach  ($new_goods as $key => $new_data)
    {
        $new_goods[$key]['shop_price'] = encode_output($new_data['shop_price']);
        $new_goods[$key]['name'] = encode_output($new_data['name']);
        /*if ($i > 2)
        {
            break;
        }*/
        $i++;
    }
    $smarty->assign('new_goods' , $new_goods);
}

/* 促销商品 */
$promote_goods = get_promote_goods_wap();
$promote_num = count($promote_goods);
$smarty->assign('promote_num' , $promote_num);
if ($promote_num > 0)
{
    $i = 0;
    foreach ($promote_goods as $key => $promote_data)
    {
        $promote_goods[$key]['shop_price'] = encode_output($promote_data['shop_price']);
        $promote_goods[$key]['name'] = encode_output($promote_data['name']);
        /*if ($i > 2)
        {
            break;
        }*/
        $i++;
    }
    $smarty->assign('promote_goods' , $promote_goods);
}

$pcat_array = get_categories_tree();
if (!empty($pcat_array))
{
	foreach ($pcat_array as $key => $pcat_data)
	{
		$pcat_array[$key]['name'] = encode_output($pcat_data['name']);
		if ($pcat_data['cat_id'])
		{
			if (count($pcat_data['cat_id']) > 3)
			{
				$pcat_array[$key]['cat_id'] = array_slice($pcat_data['cat_id'], 0, 3);
			}
			foreach ($pcat_array[$key]['cat_id'] as $k => $v)
			{
				$pcat_array[$key]['cat_id'][$k]['name'] = encode_output($v['name']);
			}
		}
	}
	$smarty->assign('pcat_array' , $pcat_array);
}
$brands_array = get_brands();
if (!empty($brands_array))
{
	if (count($brands_array) > 3)
	{
		$brands_array = array_slice($brands_array, 0, 10);
	}
	foreach ($brands_array as $key => $brands_data)
	{
		$brands_array[$key]['brand_name'] = encode_output($brands_data['brand_name']);
	}
	$smarty->assign('brand_array', $brands_array);
}

$article_array = $db->GetALLCached("SELECT article_id, title FROM " . $ecs->table("article") . " WHERE cat_id != 0 AND is_open = 1 AND open_type = 0 ORDER BY article_id DESC LIMIT 0,4");
//$article_array = get_cat_articles(3);
if (!empty($article_array))
{
	foreach ($article_array as $key => $article_data)
	{
		$article_array[$key]['title'] = encode_output($article_data['title']);
	}
	$smarty->assign('article_array', $article_array);
}
if ($_SESSION['user_id'] > 0)
{
	$smarty->assign('user_name', $_SESSION['user_name']);
}

if (!empty($GLOBALS['_CFG']['search_keywords']))
{
	$searchkeywords = explode(',', trim($GLOBALS['_CFG']['search_keywords']));
}
else
{
	$searchkeywords = array();
}
$smarty->assign('searchkeywords', $searchkeywords);

$smarty->assign('wap_logo', $_CFG['wap_logo']);
$smarty->assign('footer', get_footer());
$smarty->display("index.dwt");

/**
 * 获得文章分类下的文章列表
 *
 * @access  public
 * @param   integer     $cat_id
 * @param   integer     $page
 * @param   integer     $size
 *
 * @return  array
 */
function get_cat_articles($cat_id, $page = 1, $size = 20 ,$requirement='')
{
    //取出所有非0的文章
    if ($cat_id == '-1')
    {
        $cat_str = 'cat_id > 0';
    }
    else
    {
        $cat_str = get_article_children($cat_id);
    }
    //增加搜索条件，如果有搜索内容就进行搜索    
    if ($requirement != '')
    {
        $sql = 'SELECT article_id, title, author, add_time, file_url, open_type' .
               ' FROM ' .$GLOBALS['ecs']->table('article') .
               ' WHERE is_open = 1 AND title like \'%' . $requirement . '%\' ' .
               ' ORDER BY article_type DESC, article_id DESC';
    }
    else 
    {
        
        $sql = 'SELECT article_id, title, author, add_time, file_url, open_type' .
               ' FROM ' .$GLOBALS['ecs']->table('article') .
               ' WHERE is_open = 1 AND ' . $cat_str .
               ' ORDER BY article_type DESC, article_id DESC';
    }

    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page-1) * $size);

    $arr = array();
    if ($res)
    {
        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            $article_id = $row['article_id'];

            $arr[$article_id]['id']          = $article_id;
            $arr[$article_id]['title']       = $row['title'];
            $arr[$article_id]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ? sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
            $arr[$article_id]['author']      = empty($row['author']) || $row['author'] == '_SHOPHELP' ? $GLOBALS['_CFG']['shop_name'] : $row['author'];
            $arr[$article_id]['url']         = $row['open_type'] != 1 ? build_uri('article', array('aid'=>$article_id), $row['title']) : trim($row['file_url']);
            $arr[$article_id]['add_time']    = date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        }
    }

    return $arr;
}

?>
