<?php

/**
 * ECSHOP 管理中心文章处理程序文件
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: article.php 17095 2010-04-12 10:26:10Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . "includes/fckeditor/fckeditor.php");
require_once(ROOT_PATH . 'includes/cls_image.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');


/* 允许上传的文件类型 */
$allow_file_types = '|GIF|JPG|PNG|BMP|SWF|DOC|XLS|PPT|MID|WAV|ZIP|RAR|PDF|CHM|RM|TXT|';

/*------------------------------------------------------ */
//-- 文章列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
     admin_priv('goods_manage');
     $_LANG['not_exist_goods_attr'] = '此商品不存在规格，请为其添加规格';

    /* 是否存在属性id */
    if (empty($_GET['goods_id']))
    {
        $link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['cannot_found_goods']);
        sys_msg($_LANG['cannot_found_goods'], 1, $link);
    }
    else
    {
        $goods_id = intval($_GET['goods_id']);
    }

    /* 取出属性信息 */
    $sql = "SELECT goods_sn, goods_name, goods_type, shop_price FROM " . $ecs->table('goods') . " WHERE goods_id = '$goods_id'";
    $goods = $db->getRow($sql);
    if (empty($goods))
    {
        $link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']);
        sys_msg($_LANG['cannot_found_goods'], 1, $link);
    }
    $smarty->assign('sn', sprintf($_LANG['good_goods_sn'], $goods['goods_sn']));
    $smarty->assign('price', sprintf($_LANG['good_shop_price'], $goods['shop_price']));
    $smarty->assign('goods_name', sprintf($_LANG['products_title'], $goods['goods_name']));
    $smarty->assign('goods_sn', sprintf($_LANG['products_title_2'], $goods['goods_sn']));


    /* 获取属性规格列表 */
    $attribute = get_goods_specifications_pic_list($goods_id);
	
	
    if (empty($attribute))
    {
        $link[] = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id, 'text' => $_LANG['edit_goods']);
        sys_msg($_LANG['not_exist_goods_attr'], 1, $link);
    }

    $smarty->assign('attribute',                $attribute);
	$smarty->assign('goods_id',                 $goods['goods_id']);
	
	//print_r($attribute);

    $smarty->assign('ur_here',      $_LANG['specification_pic']);
    $smarty->assign('action_link',  array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']));
    $smarty->assign('goods_id',     $goods_id);
    $smarty->assign('filter',       $product['filter']);
    $smarty->assign('full_page',    1);

    /* 显示属性列表页面 */
    assign_query_info();

    $smarty->display('product_spec_pic.htm');
}






/*------------------------------------------------------ */
//-- 属性规格图片管理
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_specification_pic')
{
    admin_priv('goods_manage');

    /* 是否存在属性id */
    if (empty($_GET['goods_id']))
    {
        $link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['cannot_found_goods']);
        sys_msg($_LANG['cannot_found_goods'], 1, $link);
    }
    else
    {
        $goods_id = intval($_GET['goods_id']);
    }
	
	if (empty($_GET['goods_attr_id']))
    {
        $link[] = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id, 'text' => $_LANG['edit_goods']);
        sys_msg($_LANG['not_exist_goods_attr'], 1, $link);
    }
	else
    {
        $goods_attr_id = intval($_GET['goods_attr_id']);
    }

    /* 取出属性信息 */
    $sql = "SELECT goods_sn, goods_name, goods_type, shop_price FROM " . $ecs->table('goods') . " WHERE goods_id = '$goods_id'";
    $goods = $db->getRow($sql);
    if (empty($goods))
    {
        $link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']);
        sys_msg($_LANG['cannot_found_goods'], 1, $link);
    }
    $smarty->assign('goods_name', $goods['goods_name']);
    $smarty->assign('goods_sn', $goods['goods_sn']);
    
	$attribute_info = get_goods_specifications_pic_info($goods_id,$goods_attr_id);

    $smarty->assign('attribute_info',$attribute_info);
	
	$sql = "SELECT * FROM " . $ecs->table('goods_gallery') . " WHERE goods_id = '$goods_id'";
    $goods_gallery = $db->getAll($sql);
	
	foreach($goods_gallery as $key=>$val)
	{
	   $val['thumb_url'] = get_image_path($goods_id,$val['thumb_url']);
	   $val['img_url'] = get_image_path($goods_id,$val['img_url']);
	   $goods_gallery[$key] =  $val;
	}
	
	$smarty->assign('goods_gallery',$goods_gallery);

    $smarty->assign('ur_here',      $_LANG['specification_pic']);
    $smarty->assign('action_link',  array('href' => 'product_spec_pic.php?act=list&goods_id='.$_GET['goods_id'], 'text' => $_LANG['specification_pic_list']));
    $smarty->assign('goods_id',     $goods_id);
    $smarty->assign('filter',       $product['filter']);
    $smarty->assign('full_page',    1);

    /* 显示属性列表页面 */
    assign_query_info();

    $smarty->display('product_spec_pic_info.htm');
}


elseif ($_REQUEST['act'] == 'drop_image')
{
	
	if (empty($_GET['goods_id']))
    {
        $link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['cannot_found_goods']);
        sys_msg("产品不存在", 1, $link);
    }
    else
    {
        $goods_id = intval($_GET['goods_id']);
    }
	
	if (empty($_GET['goods_attr_id']))
    {
        $link[] = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id, 'text' => $_LANG['edit_goods']);
        sys_msg($_LANG['not_exist_goods_attr'], 1, $link);
    }
	else
    {
        $goods_attr_id = intval($_GET['goods_attr_id']);
    }
	
	
	$sql = "SELECT thumb_url, img_url, img_original " .
                    " FROM " . $ecs->table('goods_attr') .
                    " WHERE goods_attr_id = '$_REQUEST[goods_attr_id]'";
	$row = $db->getRow($sql);
	if ($row['thumb_url'] != '' && is_file('../' . $row['thumb_url']))
	{
		@unlink('../' . $row['thumb_url']);
	}
	if ($row['img_url'] != '' && is_file('../' . $row['img_url']))
	{
		@unlink('../' . $row['img_url']);
	}
	if ($row['img_original'] != '' && is_file('../' . $row['img_original']))
	{
		@unlink('../' . $row['img_original']);
	}
	
    $db->query("UPDATE " . $ecs->table('goods_attr') . " SET img_url = '',img_original='',thumb_url='' WHERE goods_attr_id='$goods_attr_id'");
	$link[] = array('href' => 'product_spec_pic.php?act=list&goods_id='.$goods_id, 'text' => $_LANG['specification_pic_list']);
    sys_msg("删除属性图片成功", 0, $link);
	
}

elseif ($_REQUEST['act'] == 'act_edit_specification_pic')
{
    
	/* 权限判断 */
    admin_priv('goods_manage');
	
	include_once(ROOT_PATH . '/includes/cls_image.php');
    $image = new cls_image($_CFG['bgcolor']);
	
    $hex_color = isset($_POST['hex_color']) ? trim($_POST['hex_color']) : '';
    $goods_id = isset($_POST['goods_id']) ? intval(trim($_POST['goods_id'])) : 0;
	$goods_attr_id = isset($_POST['goods_attr_id']) ? intval(trim($_POST['goods_attr_id'])) : 0;
	
	    /* 是否处理缩略图 */
    $proc_thumb = (isset($GLOBALS['shop_id']) && $GLOBALS['shop_id'] > 0)? false : true;
	
	/* 检查图片：如果有错误，检查尺寸是否超过最大值；否则，检查文件类型 */
    if (isset($_FILES['goods_img']['error'])) // php 4.2 版本才支持 error
    {
        // 最大上传文件大小
        $php_maxsize = ini_get('upload_max_filesize');
        $htm_maxsize = '2M';

        // 属性图片
        if ($_FILES['goods_img']['error'] == 0)
        {
            if (!$image->check_img_type($_FILES['goods_img']['type']))
            {
                sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
            }
        }
        elseif ($_FILES['goods_img']['error'] == 1)
        {
            sys_msg(sprintf($_LANG['goods_img_too_big'], $php_maxsize), 1, array(), false);
        }
        elseif ($_FILES['goods_img']['error'] == 2)
        {
            sys_msg(sprintf($_LANG['goods_img_too_big'], $htm_maxsize), 1, array(), false);
        }

        // 属性缩略图
        if (isset($_FILES['goods_thumb']))
        {
            if ($_FILES['goods_thumb']['error'] == 0)
            {
                if (!$image->check_img_type($_FILES['goods_thumb']['type']))
                {
                    sys_msg($_LANG['invalid_goods_thumb'], 1, array(), false);
                }
            }
            elseif ($_FILES['goods_thumb']['error'] == 1)
            {
                sys_msg(sprintf($_LANG['goods_thumb_too_big'], $php_maxsize), 1, array(), false);
            }
            elseif ($_FILES['goods_thumb']['error'] == 2)
            {
                sys_msg(sprintf($_LANG['goods_thumb_too_big'], $htm_maxsize), 1, array(), false);
            }
        }
    }
    /* 4.1版本 */
    else
    {
        // 属性图片
        if ($_FILES['goods_img']['tmp_name'] != 'none')
        {
            if (!$image->check_img_type($_FILES['goods_img']['type']))
            {

                sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
            }
        }

        // 属性缩略图
        if (isset($_FILES['goods_thumb']))
        {
            if ($_FILES['goods_thumb']['tmp_name'] != 'none')
            {
                if (!$image->check_img_type($_FILES['goods_thumb']['type']))
                {
                    sys_msg($_LANG['invalid_goods_thumb'], 1, array(), false);
                }
            }
        }
    }
	
	/* 处理商品图片 */
    $goods_img        = '';  // 初始化商品图片
    $goods_thumb      = '';  // 初始化商品缩略图
    $original_img     = '';  // 初始化原始图片
    $old_original_img = '';  // 初始化原始图片旧图
	
	
	// 如果上传了商品图片，相应处理
    if (($_FILES['goods_img']['tmp_name'] != '' && $_FILES['goods_img']['tmp_name'] != 'none') or (($_POST['goods_img_url'] != $_LANG['lab_picture_url'] && $_POST['goods_img_url'] != 'http://') && $is_url_goods_img = 1))
    {
        if ($_REQUEST['goods_attr_id'] > 0)
        {
            /* 删除原来的图片文件 */
            $sql = "SELECT thumb_url, img_url, img_original " .
                    " FROM " . $ecs->table('goods_attr') .
                    " WHERE goods_attr_id = '$_REQUEST[goods_attr_id]'";
            $row = $db->getRow($sql);
            if ($row['thumb_url'] != '' && is_file('../' . $row['thumb_url']))
            {
                @unlink('../' . $row['thumb_url']);
            }
            if ($row['img_url'] != '' && is_file('../' . $row['img_url']))
            {
                @unlink('../' . $row['img_url']);
            }
            if ($row['img_original'] != '' && is_file('../' . $row['img_original']))
            {
                /* 先不处理，以防止程序中途出错停止 */
                //$old_original_img = $row['original_img']; //记录旧图路径
            }
       
        }

        if (empty($is_url_goods_img))
        {
            $original_img   = $image->upload_image($_FILES['goods_img']); // 原始图片
        }
        elseif (copy(trim($_POST['goods_img_url']), ROOT_PATH . 'temp/' . basename($_POST['goods_img_url'])))
        {
            $original_img = 'temp/' . basename($_POST['goods_img_url']);
        }

        if ($original_img === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
        $goods_img      = $original_img;   // 商品图片


        // 如果系统支持GD，缩放商品图片，且给商品图片和相册图片加水印
        if ($proc_thumb && $image->gd_version() > 0 && $image->check_img_function($_FILES['goods_img']['type']) || $is_url_goods_img)
        {

            if (empty($is_url_goods_img))
            {
                // 如果设置大小不为0，缩放图片
                if ($_CFG['image_width'] != 0 || $_CFG['image_height'] != 0)
                {
                    $goods_img = $image->make_thumb('../'. $goods_img , $GLOBALS['_CFG']['image_width'],  $GLOBALS['_CFG']['image_height']);
                    if ($goods_img === false)
                    {
                        sys_msg($image->error_msg(), 1, array(), false);
                    }
                }
                // 加水印
                if (intval($_CFG['watermark_place']) > 0 && !empty($GLOBALS['_CFG']['watermark']))
                {
                    if ($image->add_watermark('../'.$goods_img,'',$GLOBALS['_CFG']['watermark'], $GLOBALS['_CFG']['watermark_place'], $GLOBALS['_CFG']['watermark_alpha']) === false)
                    {
                        sys_msg($image->error_msg(), 1, array(), false);
                    }
                }
            }
        }
    }
	
	    // 是否上传商品缩略图
    if (isset($_FILES['goods_thumb']) && $_FILES['goods_thumb']['tmp_name'] != '' &&
        isset($_FILES['goods_thumb']['tmp_name']) &&$_FILES['goods_thumb']['tmp_name'] != 'none')
    {
        // 上传了，直接使用，原始大小
        $goods_thumb = $image->upload_image($_FILES['goods_thumb']);
        if ($goods_thumb === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
    }
    else
    {
        // 未上传，如果自动选择生成，且上传了商品图片，生成所略图
        if ($proc_thumb && isset($_POST['auto_thumb']) && !empty($original_img))
        {
            // 如果设置缩略图大小不为0，生成缩略图
            if ($_CFG['thumb_width'] != 0 || $_CFG['thumb_height'] != 0)
            {
                $goods_thumb = $image->make_thumb('../' . $original_img, $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);
                if ($goods_thumb === false)
                {
                    sys_msg($image->error_msg(), 1, array(), false);
                }
            }
            else
            {
                $goods_thumb = $original_img;
            }
        }
    }


	
	/* 重新格式化图片名称 */
    $original_img = reformat_image_name('goods', $goods_id, $original_img, 'source');
    $goods_img = reformat_image_name('goods', $goods_id, $goods_img, 'goods');
    $goods_thumb = reformat_image_name('goods_thumb', $goods_id, $goods_thumb, 'thumb');
   
     if ($goods_img !== false)
    {
        $db->query("UPDATE " . $ecs->table('goods_attr') . " SET img_url = '$goods_img' WHERE goods_attr_id='$goods_attr_id'");
    }

    if ($original_img !== false)
    {
        $db->query("UPDATE " . $ecs->table('goods_attr') . " SET img_original = '$original_img' WHERE goods_attr_id='$goods_attr_id'");
    }

    if ($goods_thumb !== false)
    {
        $db->query("UPDATE " . $ecs->table('goods_attr') . " SET thumb_url = '$goods_thumb' WHERE goods_attr_id='$goods_attr_id'");
    }

    if ($hex_color !== false)
    {
        $db->query("UPDATE " . $ecs->table('goods_attr') . " SET hex_color = '$hex_color' WHERE goods_attr_id='$goods_attr_id'");
    }
   
	
	$link[] = array('href' => 'product_spec_pic.php?act=list&goods_id='.$goods_id, 'text' => $_LANG['specification_pic_list']);

    sys_msg($_LANG['save_specification'], 0, $link);

}



/**
 * 获得属性规格列表
 *
 * @access      public
 * @params      integer         $goods_id
 * @return      array
 */
function get_goods_specifications_pic_list($goods_id)
{
    if (empty($goods_id))
    {
        return array();  //$goods_id不能为空
    }

    $sql = "SELECT g.goods_attr_id, g.attr_value, g.attr_id, a.attr_name , thumb_url, img_url, img_original, hex_color 
            FROM " . $GLOBALS['ecs']->table('goods_attr') . " AS g
                LEFT JOIN " . $GLOBALS['ecs']->table('attribute') . " AS a
                    ON a.attr_id = g.attr_id
            WHERE g.goods_id = '$goods_id'
            AND a.attr_type = 1
            ORDER BY g.attr_id ASC";
			
    $results = $GLOBALS['db']->getAll($sql);
    
	foreach($results as $key=>$val)
	{
	   if(!empty($val['thumb_url']))
	   {
	      $val['thumb_url'] = '../'.$val['img_url'];
		  $val['img_url']   = '../'.$val['img_url'];
	   }
	   $results[$key] = $val;
	}

    return $results;
}


/**
 * 获得属性规格信息
 *
 * @access      public
 * @params      integer         $goods_id
 * @return      array
 */
function get_goods_specifications_pic_info($goods_id,$goods_attr_id)
{
    if (empty($goods_id))
    {
        return array();  //$goods_id不能为空
    }

    $sql = "SELECT g.goods_attr_id, g.attr_value, g.attr_id, a.attr_name, thumb_url, img_url, img_original, hex_color
            FROM " . $GLOBALS['ecs']->table('goods_attr') . " AS g
                LEFT JOIN " . $GLOBALS['ecs']->table('attribute') . " AS a
                    ON a.attr_id = g.attr_id
            WHERE g.goods_id = '$goods_id' and goods_attr_id = '$goods_attr_id'
            AND a.attr_type = 1
            ORDER BY g.attr_id ASC";

    $row = $GLOBALS['db']->getRow($sql);
	
	$row['img_id'] = explode(',',$row['img_id']);

    return $row;
}



?>