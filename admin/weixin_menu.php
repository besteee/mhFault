<?php

/**
 * ECSHOP 菜单管理程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: weixin_menu.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc = new exchange($ecs->table("weixin_menu"), $db, 'cat_id', 'cat_name');
/* act操作项的初始化 */
$_REQUEST['act'] = trim($_REQUEST['act']);
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}

/**
 * 获得指定分类下的子分类的数组
 *
 * @access  public
 * @param   int     $cat_id     分类的ID
 * @param   int     $selected   当前选中分类的ID
 * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
 * @param   int     $level      限定返回的级数。为0时返回所有级数
 * @return  mix
 */
function weixin_menu_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0)
{
    static $res = NULL;

    if ($res === NULL)
    {
        $data = read_static_cache('weixin');
        if ($data === false)
        {
            $sql = "SELECT c.*, COUNT(s.cat_id) AS has_children, COUNT(a.article_id) AS aricle_num ".
               ' FROM ' . $GLOBALS['ecs']->table('weixin_menu') . " AS c".
               " LEFT JOIN " . $GLOBALS['ecs']->table('weixin_menu') . " AS s ON s.parent_id=c.cat_id".
               " LEFT JOIN " . $GLOBALS['ecs']->table('article') . " AS a ON a.cat_id=c.cat_id".
               " GROUP BY c.cat_id ".
               " ORDER BY parent_id, sort_order ASC";
            $res = $GLOBALS['db']->getAll($sql);
            write_static_cache('weixin', $res);
        }
        else
        {
            $res = $data;
        }
    }

    if (empty($res) == true)
    {
        return $re_type ? '' : array();
    }

    $options = options_weixin($cat_id, $res); // 获得指定分类下的子分类的数组

    /* 截取到指定的缩减级别 */
    if ($level > 0)
    {
        if ($cat_id == 0)
        {
            $end_level = $level;
        }
        else
        {
            $first_item = reset($options); // 获取第一个元素
            $end_level  = $first_item['level'] + $level;
        }

        /* 保留level小于end_level的部分 */
        foreach ($options AS $key => $val)
        {
            if ($val['level'] >= $end_level)
            {
                unset($options[$key]);
            }
        }
    }

    $pre_key = 0;
    foreach ($options AS $key => $value)
    {
        $options[$key]['has_children'] = 1;
        if ($pre_key > 0)
        {
            if ($options[$pre_key]['cat_id'] == $options[$key]['parent_id'])
            {
                $options[$pre_key]['has_children'] = 1;
            }
        }
        $pre_key = $key;
    }

    if ($re_type == true)
    {
        $select = '';
        foreach ($options AS $var)
        {
            $select .= '<option value="' . $var['cat_id'] . '" ';
            $select .= ' cat_type="' . $var['cat_type'] . '" ';
            $select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
            $select .= '>';
            if ($var['level'] > 0)
            {
                $select .= str_repeat('&nbsp;', $var['level'] * 4);
            }
            $select .= htmlspecialchars(addslashes($var['cat_name'])) . '</option>';
        }

        return $select;
    }
    else
    {
        foreach ($options AS $key => $value)
        {
            $options[$key]['url'] = build_uri('article_cat', array('acid' => $value['cat_id']), $value['cat_name']);
        }
        return $options;
    }
}

/**
 * 过滤和排序所有文章分类，返回一个带有缩进级别的数组
 *
 * @access  private
 * @param   int     $cat_id     上级分类ID
 * @param   array   $arr        含有所有分类的数组
 * @param   int     $level      级别
 * @return  void
 */
function options_weixin($spec_cat_id, $arr)
{
    static $cat_options = array();

    if (isset($cat_options[$spec_cat_id]))
    {
        return $cat_options[$spec_cat_id];
    }

    if (!isset($cat_options[0]))
    {
        $level = $last_cat_id = 0;
        $options = $cat_id_array = $level_array = array();
        while (!empty($arr))
        {
            foreach ($arr AS $key => $value)
            {
                $cat_id = $value['cat_id'];
                if ($level == 0 && $last_cat_id == 0)
                {
                    if ($value['parent_id'] > 0)
                    {
                        break;
                    }

                    $options[$cat_id]          = $value;
                    $options[$cat_id]['level'] = $level;
                    $options[$cat_id]['id']    = $cat_id;
                    $options[$cat_id]['name']  = $value['cat_name'];
                    unset($arr[$key]);

                    if ($value['has_children'] == 0)
                    {
                        continue;
                    }
                    $last_cat_id  = $cat_id;
                    $cat_id_array = array($cat_id);
                    $level_array[$last_cat_id] = ++$level;
                    continue;
                }

                if ($value['parent_id'] == $last_cat_id)
                {
                    $options[$cat_id]          = $value;
                    $options[$cat_id]['level'] = $level;
                    $options[$cat_id]['id']    = $cat_id;
                    $options[$cat_id]['name']  = $value['cat_name'];
                    unset($arr[$key]);

                    if ($value['has_children'] > 0)
                    {
                        if (end($cat_id_array) != $last_cat_id)
                        {
                            $cat_id_array[] = $last_cat_id;
                        }
                        $last_cat_id    = $cat_id;
                        $cat_id_array[] = $cat_id;
                        $level_array[$last_cat_id] = ++$level;
                    }
                }
                elseif ($value['parent_id'] > $last_cat_id)
                {
                    break;
                }
            }

            $count = count($cat_id_array);
            if ($count > 1)
            {
                $last_cat_id = array_pop($cat_id_array);
            }
            elseif ($count == 1)
            {
                if ($last_cat_id != end($cat_id_array))
                {
                    $last_cat_id = end($cat_id_array);
                }
                else
                {
                    $level = 0;
                    $last_cat_id = 0;
                    $cat_id_array = array();
                    continue;
                }
            }

            if ($last_cat_id && isset($level_array[$last_cat_id]))
            {
                $level = $level_array[$last_cat_id];
            }
            else
            {
                $level = 0;
            }
        }
        $cat_options[0] = $options;
    }
    else
    {
        $options = $cat_options[0];
    }

    if (!$spec_cat_id)
    {
        return $options;
    }
    else
    {
        if (empty($options[$spec_cat_id]))
        {
            return array();
        }

        $spec_cat_id_level = $options[$spec_cat_id]['level'];

        foreach ($options AS $key => $value)
        {
            if ($key != $spec_cat_id)
            {
                unset($options[$key]);
            }
            else
            {
                break;
            }
        }

        $spec_cat_id_array = array();
        foreach ($options AS $key => $value)
        {
            if (($spec_cat_id_level == $value['level'] && $value['cat_id'] != $spec_cat_id) ||
                ($spec_cat_id_level > $value['level']))
            {
                break;
            }
            else
            {
                $spec_cat_id_array[$key] = $value;
            }
        }
        $cat_options[$spec_cat_id] = $spec_cat_id_array;

        return $spec_cat_id_array;
    }
}

/*------------------------------------------------------ */
//-- 菜单列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $articlecat = weixin_menu_list(0, 0, false,2);
    foreach ($articlecat as $key => $cat)
    {
        $articlecat[$key]['type_name'] = $_LANG['type_name'][$cat['cat_type']];
    }
    $smarty->assign('ur_here',     '菜单列表');
    $smarty->assign('action_link', array('text' => '添加菜单', 'href' => 'weixin_menu.php?act=add'));
    $smarty->assign('full_page',   1);
    $smarty->assign('articlecat',        $articlecat);

    assign_query_info();
    $smarty->display('weixin_menu_list.htm');
}

/*------------------------------------------------------ */
//-- 查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $articlecat = weixin_menu_list(0, 0, false);
    foreach ($articlecat as $key => $cat)
    {
        $articlecat[$key]['type_name'] = $_LANG['type_name'][$cat['cat_type']];
    }
    $smarty->assign('articlecat',        $articlecat);

    make_json_result($smarty->fetch('weixin_menu_list.htm'));
}

/*------------------------------------------------------ */
//-- 添加菜单
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{

    $smarty->assign('cat_select',  weixin_menu_list(0, 0, true,1));
    $smarty->assign('ur_here',     '添加菜单');
    $smarty->assign('action_link', array('text' => '菜单列表', 'href' => 'weixin_menu.php?act=list'));
    $smarty->assign('form_action', 'insert');

    assign_query_info();
    $smarty->display('weixin_menu_info.htm');
}
elseif ($_REQUEST['act'] == 'insert')
{
    /* 权限判断 */
    admin_priv('article_cat');

    /*检查菜单名是否重复*/
    $is_only = $exc->is_only('cat_name', $_POST['cat_name']);

    if (!$is_only)
    {
        sys_msg(sprintf('已存在相同的菜单名称', stripslashes($_POST['cat_name'])), 1);
    }

    $cat_type = 1;
    if ($_POST['parent_id'] > 0)
    {
        $sql = "SELECT cat_type FROM " . $ecs->table('weixin_menu') . " WHERE cat_id = '$_POST[parent_id]'";
        $p_cat_type = $db->getOne($sql);
        if ($p_cat_type == 2 || $p_cat_type == 3 || $p_cat_type == 5)
        {
            sys_msg('你所选菜单不允许添加子菜单', 0);
        }
        else if ($p_cat_type == 4)
        {
            $cat_type = 5;
        }
    }


    $sql = "INSERT INTO ".$ecs->table('weixin_menu')."(cat_name, cat_type, weixin_key,links, parent_id, sort_order, weixin_type)
           VALUES ('$_POST[cat_name]', '$cat_type',  '$_POST[weixin_key]','$_POST[links]', '$_POST[parent_id]', '$_POST[sort_order]', '$_POST[weixin_type]')";
    $db->query($sql);
    admin_log($_POST['cat_name'],'add','articlecat');

    $link[0]['text'] = '继续添加新菜单';
    $link[0]['href'] = 'weixin_menu.php?act=add';

    $link[1]['text'] = '返回菜单列表';
    $link[1]['href'] = 'weixin_menu.php?act=list';
    clear_cache_files();
    sys_msg($_POST['cat_name'].'已成功添加',0, $link);
}

/*------------------------------------------------------ */
//-- 编辑菜单
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    /* 权限判断 */
    admin_priv('article_cat');

    $sql = "SELECT cat_id, cat_name, cat_type, weixin_key, links, weixin_type, parent_id,sort_order FROM ".
           $ecs->table('weixin_menu'). " WHERE cat_id='$_REQUEST[id]'";
    $cat = $db->GetRow($sql);

    if ($cat['cat_type'] == 2 || $cat['cat_type'] == 3 || $cat['cat_type'] ==4)
    {
        $smarty->assign('disabled', 1);
    }
    $options    =   weixin_menu_list(0, $cat['parent_id'], false,1);
    $select     =   '';
    $selected   =   $cat['parent_id'];
    foreach ($options as $var)
    {
        if ($var['cat_id'] == $_REQUEST['id'])
        {
            continue;
        }
        $select .= '<option value="' . $var['cat_id'] . '" ';
        $select .= ' cat_type="' . $var['cat_type'] . '" ';
        $select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
        $select .= '>';
        if ($var['level'] > 0)
        {
            $select .= str_repeat('&nbsp;', $var['level'] * 4);
        }
        $select .= htmlspecialchars($var['cat_name']) . '</option>';
    }
    unset($options);
    $smarty->assign('cat',         $cat);
    $smarty->assign('cat_select',  $select);
    $smarty->assign('ur_here',     '编辑菜单');
    $smarty->assign('action_link', array('text' => '菜单列表', 'href' => 'weixin_menu.php?act=list'));
    $smarty->assign('form_action', 'update');

    assign_query_info();
    $smarty->display('weixin_menu_info.htm');
}
elseif ($_REQUEST['act'] == 'update')
{
    /* 权限判断 */
    admin_priv('article_cat');

    /*检查重名*/
    if ($_POST['cat_name'] != $_POST['old_catname'])
    {
        $is_only = $exc->is_only('cat_name', $_POST['cat_name'], $_POST['id']);

        if (!$is_only)
        {
            sys_msg(sprintf('已存在相同的菜单名称', stripslashes($_POST['cat_name'])), 1);
        }
    }

    if(!isset($_POST['parent_id']))
    {
        $_POST['parent_id'] = 0;
    }

    $row = $db->getRow("SELECT cat_type, parent_id FROM " . $ecs->table('weixin_menu') . " WHERE cat_id='$_POST[id]'");
    $cat_type = $row['cat_type'];
    if ($cat_type == 3 || $cat_type ==4)
    {
        $_POST['parent_id'] = $row['parent_id'];
    }

    /* 检查设定的菜单的父菜单是否合法 */
    $child_cat = weixin_menu_list($_POST['id'], 0, false);
    if (!empty($child_cat))
    {
        foreach ($child_cat as $child_data)
        {
            $catid_array[] = $child_data['cat_id'];
        }
    }
    if (in_array($_POST['parent_id'], $catid_array))
    {
        sys_msg(sprintf('菜单名 %s 的父菜单不能设置成本身或本身的子菜单', stripslashes($_POST['cat_name'])), 1);
    }

    if ($cat_type == 1 || $cat_type == 5)
    {
        if ($_POST['parent_id'] > 0)
        {
            $sql = "SELECT cat_type FROM " . $ecs->table('weixin_menu') . " WHERE cat_id = '$_POST[parent_id]'";
            $p_cat_type = $db->getOne($sql);
            if ($p_cat_type == 4)
            {
                $cat_type = 5;
            }
            else
            {
                $cat_type = 1;
            }
        }
        else
        {
            $cat_type = 1;
        }
    }

    $dat = $db->getOne("SELECT cat_name, weixin_type FROM ". $ecs->table('weixin_menu') . " WHERE cat_id = '" . $_POST['id'] . "'");
    if ($exc->edit("cat_name = '$_POST[cat_name]', weixin_key ='$_POST[weixin_key]', links ='$_POST[links]', parent_id = '$_POST[parent_id]', cat_type='$cat_type', sort_order='$_POST[sort_order]', weixin_type = '$_POST[weixin_type]'",  $_POST['id']))
    {
        if($_POST['cat_name'] != $dat['cat_name'])
        {
            //如果菜单名称发生了改变
            $sql = "UPDATE " . $ecs->table('nav') . " SET name = '" . $_POST['cat_name'] . "' WHERE ctype = 'a' AND cid = '" . $_POST['id'] . "' AND type = 'middle'";
            $db->query($sql);
        }
        $link[0]['text'] = '返回菜单列表';
        $link[0]['href'] = 'weixin_menu.php?act=list';
        $note = sprintf('菜单 %s 编辑成功', $_POST['cat_name']);
        admin_log($_POST['cat_name'], 'edit', 'articlecat');
        clear_cache_files();
        sys_msg($note, 0, $link);

    }
    else
    {
        die($db->error());
    }
}



/*------------------------------------------------------ */
//-- 编辑菜单的排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_sort_order')
{
    check_authz_json('article_cat');

    $id    = intval($_POST['id']);
    $order = json_str_iconv(trim($_POST['val']));

    /* 检查输入的值是否合法 */
    if (!preg_match("/^[0-9]+$/", $order))
    {
        make_json_error(sprintf('请输入一个整数', $order));
    }
    else
    {
        if ($exc->edit("sort_order = '$order'", $id))
        {
            clear_cache_files();
            make_json_result(stripslashes($order));
        }
        else
        {
            make_json_error($db->error());
        }
    }
}

/*------------------------------------------------------ */
//-- 删除菜单
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('article_cat');

    $id = intval($_GET['id']);


    $sql = "SELECT COUNT(*) FROM " . $ecs->table('weixin_menu') . " WHERE parent_id = '$id'";
    if ($db->getOne($sql) > 0)
    {
        /* 还有子菜单，不能删除 */
        make_json_error('该菜单下还有子菜单，请先删除其子菜单');
    }

    /* 非空的菜单不允许删除 */
        $exc->drop($id);
        $db->query("DELETE FROM " . $ecs->table('nav') . "WHERE  ctype = 'a' AND cid = '$id' AND type = 'middle'");
        clear_cache_files();
        admin_log($cat_name, 'remove', 'category');

    $url = 'weixin_menu.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/**
 * 添加菜单
 *
 * @param   integer $cat_id
 * @param   array   $args
 *
 * @return  mix
 */
function cat_update($cat_id, $args)
{
    if (empty($args) || empty($cat_id))
    {
        return false;
    }

    return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('weixin_menu'), $args, 'update', "cat_id='$cat_id'");
}
?>
