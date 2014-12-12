<?php

/**
 * ECSHOP 列出所有分类及品牌
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: catalog.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

if (!$smarty->is_cached('catalog.dwt'))
{
    /* 取出所有分类 */
    $cat_list = cat_list(0, 0, false);

    foreach ($cat_list AS $key=>$val)
    {
        if ($val['is_show'] == 0)
        {
            unset($cat_list[$key]);
        }
    }


    assign_template();
    assign_dynamic('catalog');
    $position = assign_ur_here(0, $_LANG['catalog']);
    $smarty->assign('page_title', $position['title']);   // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']); // 当前位置

    $smarty->assign('cata_categories',   catalog_categories_tree()); // 分类树
    $smarty->assign('helps',      get_shop_help()); // 网店帮助
    $smarty->assign('cat_list',   $cat_list);       // 分类列表
    $smarty->assign('brand_list', get_brands());    // 所以品牌赋值
    $smarty->assign('promotion_info', get_promotion_info());
}

$smarty->display('catalog.dwt');

/**
 * 计算指定分类的商品数量
 *
 * @access public
 * @param   integer     $cat_id
 *
 * @return void
 */
function calculate_goods_num($cat_list, $cat_id)
{
    $goods_num = 0;

    foreach ($cat_list AS $cat)
    {
        if ($cat['parent_id'] == $cat_id && !empty($cat['goods_num']))
        {
            $goods_num += $cat['goods_num'];
        }
    }

    return $goods_num;
}


/**
* 获得指定分类同级的所有分类以及该分类下的子分类
*
* @access  public
* @param   integer     $cat_id     分类编号
* @return  array
*/
function catalog_categories_tree($cat_id = 0)
{
    if ($cat_id > 0)
    {
        $sql = 'SELECT parent_id FROM ' . $GLOBALS['ecs']->table('category') . " WHERE cat_id = '$cat_id'";
        $parent_id = $GLOBALS['db']->getOne($sql);
    }
    else
    {
        $parent_id = 0;
    }
    /*
     判断当前分类中全是是否是底级分类，
     如果是取出底级分类上级分类，
     如果不是取当前分类及其下的子分类
    */
    $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('category') . " WHERE parent_id = '$parent_id' AND is_show = 1 ";
    if ($GLOBALS['db']->getOne($sql) || $parent_id == 0)
    {
        /* 获取当前分类及其子分类 */
        $sql = 'SELECT cat_id,cat_name ,parent_id,is_show ' .
                'FROM ' . $GLOBALS['ecs']->table('category') .
                "WHERE parent_id = '$parent_id' AND is_show = 1 ORDER BY sort_order ASC, cat_id ASC";
        $res = $GLOBALS['db']->getAll($sql);

   $sql = "SELECT cat_id, COUNT(*) AS goods_num " .
   " FROM " . $GLOBALS['ecs']->table('goods') . " AS g " .
   " GROUP BY cat_id";

    $res2 = $GLOBALS['db']->getAll($sql);
    $newres = array();
    foreach($res2 AS $row)
    {
     $newres[$row['cat_id']] = $row['goods_num'];
    }

        foreach ($res AS $row)
        {
            if ($row['is_show'])
            {
                $cat_arr[$row['cat_id']]['id']   = $row['cat_id'];
                $cat_arr[$row['cat_id']]['num']  = !empty($newres[$row['cat_id']]) ? $newres[$row['cat_id']] : 0;
                $cat_arr[$row['cat_id']]['name'] = $row['cat_name'];
                $cat_arr[$row['cat_id']]['url']  = build_uri('category', array('cid' => $row['cat_id']), $row['cat_name']);
                if (isset($row['cat_id']) != NULL)
                {
                    $cat_arr[$row['cat_id']]['cat_id'] = catalog_child_tree($row['cat_id']);
                }
            }
        }
    }
    if(isset($cat_arr))
    {
        return $cat_arr;
    }
}

function catalog_child_tree($tree_id = 0)
{
    $three_arr = array();
    $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('category') . " WHERE parent_id = '$tree_id' AND is_show = 1 ";
    if ($GLOBALS['db']->getOne($sql) || $tree_id == 0)
    {
        $child_sql = 'SELECT cat_id, cat_name, parent_id, is_show ' .
                'FROM ' . $GLOBALS['ecs']->table('category') .
                "WHERE parent_id = '$tree_id' AND is_show = 1 ORDER BY sort_order ASC, cat_id ASC";
        $res = $GLOBALS['db']->getAll($child_sql);


   $sql = "SELECT cat_id, COUNT(*) AS goods_num " .
   " FROM " . $GLOBALS['ecs']->table('goods') . " AS g " .
   " GROUP BY cat_id";
    $res2 = $GLOBALS['db']->getAll($sql);
    $newres = array();
    foreach($res2 AS $row)
    {
     $newres[$row['cat_id']] = $row['goods_num'];
    }

        foreach ($res AS $row)
        {
            if ($row['is_show'])
        $three_arr[$row['cat_id']]['num']  = !empty($newres[$row['cat_id']]) ? $newres[$row['cat_id']] : 0;
               $three_arr[$row['cat_id']]['id']   = $row['cat_id'];
               $three_arr[$row['cat_id']]['name'] = $row['cat_name'];
               $three_arr[$row['cat_id']]['url']  = build_uri('category', array('cid' => $row['cat_id']), $row['cat_name']);
               if (isset($row['cat_id']) != NULL)
                   {
                       $three_arr[$row['cat_id']]['cat_id'] = catalog_child_tree($row['cat_id']);
            }
        }
    }
    return $three_arr;
}
?>