<?php

/**
 * ECSHOP WAP评论页
 * ============================================================================
 * 版权所有 2005-2011 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: testyang $
 * $Id: comment.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

include_once(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_order.php');

/**
 * 查询评论内容
 *
 * @access  public
 * @params  integer     $id
 * @params  integer     $type
 * @params  integer     $page
 * @return  array
 */
function assign_comment_wap($id, $type)
{
    /* 取得评论列表 */
    $count = $GLOBALS['db']->getOne('SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('comment').
           " WHERE id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0");
    $size  = !empty($GLOBALS['_CFG']['comments_number']) ? $GLOBALS['_CFG']['comments_number'] : 5;
    $page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;
    $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('comment') .
            " WHERE id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0".
            ' ORDER BY comment_id DESC';
        $res = $GLOBALS['db']->query($sql);

    $arr = array();
    $ids = '';
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ids .= $ids ? ",$row[comment_id]" : $row['comment_id'];
        $arr[$row['comment_id']]['id']       = $row['comment_id'];
        $arr[$row['comment_id']]['email']    = $row['email'];
        $arr[$row['comment_id']]['username'] = $row['user_name'];
        $arr[$row['comment_id']]['content']  = str_replace('\r\n', '<br />', htmlspecialchars($row['content']));
        $arr[$row['comment_id']]['content']  = nl2br(str_replace('\n', '<br />', $arr[$row['comment_id']]['content']));
        $arr[$row['comment_id']]['rank']     = $row['comment_rank'];
        $arr[$row['comment_id']]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
    }
    /* 取得已有回复的评论 */
    if ($ids)
    {
        $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('comment') .
                " WHERE parent_id IN( $ids )";
        $res = $GLOBALS['db']->query($sql);
        while ($row = $GLOBALS['db']->fetch_array($res))
        {
            $arr[$row['parent_id']]['re_content']  = nl2br(str_replace('\n', '<br />', htmlspecialchars($row['content'])));
            $arr[$row['parent_id']]['re_add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
            $arr[$row['parent_id']]['re_email']    = $row['email'];
            $arr[$row['parent_id']]['re_username'] = $row['user_name'];
        }
    }
    /* 分页样式 */
    //$pager['styleid'] = isset($GLOBALS['_CFG']['page_style'])? intval($GLOBALS['_CFG']['page_style']) : 0;
    $pager['size']         = $size;
    $pager['record_count'] = $count;
    $pager['page_count']   = $page_count;

    $cmt = array('comments' => $arr, 'pager' => $pager);

    return $cmt;
}

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if ($_SESSION['user_id'] > 0)
{
    $smarty->assign('user_name', $_SESSION['user_name']);

}

$goods_id = !empty($_GET['g_id']) ? intval($_GET['g_id']) : exit();
if ($goods_id <= 0)
{
    exit();
}
if(@$_GET['act'] == 'comment'){
	
	$status = 1 - $GLOBALS['_CFG']['comment_check'];
	$id_value = $_GET['g_id'];
    $user_id = empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
    @$email = htmlspecialchars($_POST['email']);
    $user_name = ($_SESSION['user_name'] ? $_SESSION['user_name'] : '匿名用户');
    $user_name = htmlspecialchars($user_name);
	$rank = $_POST['comment_rank'];
	$content = $_POST['content'];
	$type = '0';
	if($content == ''){
		$smarty->assign('info', '评论内容不可以为空！');
	}
	else{
		/* 保存评论内容 */
		$sql = "INSERT INTO " .$GLOBALS['ecs']->table('comment') .
			   "(comment_type, id_value, email, user_name, content, comment_rank, add_time, ip_address, status, parent_id, user_id) VALUES " .
			   "('" .$type. "', '" .$id_value. "', '$email', '$user_name', '" .$content."', '".$rank."', ".gmtime().", '".real_ip()."', '$status', '0', '$user_id')";
		
		$result = $GLOBALS['db']->query($sql);
		if($result){
			if ($GLOBALS['_CFG']['comment_check']==1){
			$smarty->assign('info', '您的评论已成功发表, 请等待管理员的审核!');
			}else{
			$smarty->assign('info', '您的评论已成功发表, 感谢您的参与!');
			}
		}
	}
	$smarty->assign('footer', get_footer());
	$smarty->display('comment_success.dwt');
}
else{
/* 读取商品信息 */
$_LANG['kilogram'] = '千克';
$_LANG['gram'] = '克';
$_LANG['home'] = '首页';
$smarty->assign('goods_id', $goods_id);
$goods_info = get_goods_info($goods_id);
$goods_info['goods_name'] = encode_output($goods_info['goods_name']);
$goods_info['goods_brief'] = encode_output($goods_info['goods_brief']);
$smarty->assign('goods_info', $goods_info);

/* 读评论信息 */
$comment = assign_comment_wap($goods_id, 'comments');

$num = $comment['pager']['record_count'];
if ($num > 0)
{
    $page_num = '5';
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
    foreach ($comment['comments'] as $key => $data)
    {
        if (($i > ($page_num * ($page - 1 ))) && ($i <= ($page_num * $page)))
        {
            $re_content = !empty($data['re_content']) ? encode_output($data['re_content']) : '';
            $re_username = !empty($data['re_username']) ? encode_output($data['re_username']) : '';
            $re_add_time = !empty($data['re_add_time']) ? substr($data['re_add_time'], 5, 14) : '';
              $comment_data[] = array('i' => $i , 'content' => encode_output($data['content']) , 'username' => encode_output($data['username']) , 'add_time' => substr($data['add_time'], 5, 14) , 're_content' => $re_content , 're_username' => $re_username , 're_add_time' => $re_add_time , 'comment_rank' => $data['rank']/5*100);
      }
        $i++;
    }

    $smarty->assign('comment_data', $comment_data);
    $pagebar = get_wap_pager($num, $page_num, $page, 'comment.php?g_id='.$goods_id, 'page');
    $smarty->assign('pagebar' , $pagebar);
}

$smarty->assign('footer', get_footer());
$smarty->display('comment.dwt');
}
?>