<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$_REQUEST['act'] = trim($_REQUEST['act']);
$weixinlangtable = $GLOBALS['ecs']->table('weixin_lang');
$weixincfgtable = $GLOBALS['ecs']->table('weixin_cfg');
$weixinbonustable = $GLOBALS['ecs']->table('weixin_bonus');
$weixinpointtable = $GLOBALS['ecs']->table('weixin_point');
$weixinconfigtable = $GLOBALS['ecs']->table('weixin_config');
$weixinkeywordstable = $GLOBALS['ecs']->table('weixin_keywords');
if ($_REQUEST['act'] == 'wxconfig') {
    if (!empty($_POST['token'])) {
        $token     = $_POST['token'];
        $appid     = $_POST['appid'];
        $appsecret = $_POST['appsecret'];
        $ret       = $db->query("UPDATE ".$weixinconfigtable." SET `token`='$token',`appid`='$appid',`appsecret`='$appsecret' WHERE `id`=1;");
        $link[]    = array(
            'href' => 'wxch.php?act=config',
            'text' => '微信接口'
        );
        if ($ret) {
            sys_msg('设置成功', 0, $link);
        } else {
            sys_msg('设置失败，请重新设置', 0, $link);
        }
    } else {
        $ret = $db->getRow("SELECT * FROM ".$weixinconfigtable." WHERE `id` = 1");
        $smarty->assign('token', $ret['token']);
        $smarty->assign('appid', $ret['appid']);
        $smarty->assign('appsecret', $ret['appsecret']);
        $smarty->display('wxch_wxconfig.html');
    }
}elseif($_REQUEST['act'] == 'bonus') { 
	$wxch_lang['ur_here'] = '关注送红包设置';
	if($_POST) {
		$type_id = $_POST['bonus'];
		$sql = "UPDATE ".$weixinbonustable." SET `type_id`='$type_id'";
		$ret = $db->query($sql);
		$link[] = array('href' =>'wxch.php?act=bonus', 'text' => '关注送红包');
		if($ret){
			sys_msg('设置成功',0,$link);
		}else{
			sys_msg('设置失败，请重新设置',0,$link);
		}
	}else{
		$thistable = $ecs->prefix.'bonus_type';
	$sql = "SELECT * FROM  `$thistable` WHERE `send_type` = 3";
	$w_data = $db->getAll($sql);
	$ret = $db->getRow("SELECT `type_id` FROM ".$weixinbonustable." WHERE `id` = 1");
	$type_id = $ret['type_id'];
	$smarty->assign('w_data',$w_data);
	$smarty->assign('type_id',$type_id);
	$smarty->assign('form_act','bonus');
	$smarty->assign('wxch_lang',$wxch_lang);
	$smarty->display('wxch_bonus.html');
	} 
}elseif ($_REQUEST['act'] == 'point') {
    $wxch_lang['ur_here'] = '积分增加设置';
    if ($_POST) {
        $autoload = $_POST['autoload'];
        $point_value = $_POST['point_value'];
        $point_name = $_POST['point_name'];
        foreach ($point_name as $k => $v) {
            if ($autoload[$v] == 1) {
                $autoload[$v] = 'yes';
            } else {
                $autoload[$v] = 'no';
            }
            $sql = "UPDATE ".$weixinpointtable." SET  `point_value` = {$point_value[$v]},`autoload` =  '{$autoload[$v]}' WHERE  `point_name` ='{$point_name[$k]}';";
            $db->query($sql);
        }
        $link[] = array('href' => 'wxch.php?act=point', 'text' => $wxch_lang['ur_here']);
        sys_msg('设置成功', 0, $link);
    } else {
        $sql = 'SELECT * FROM '.$weixinpointtable;
        $ret = $db->getAll($sql);
        foreach ($ret as $k => $v) {
            switch ($v['point_name']) {
            case 'new':
                $ret[$k]['name'] = '新品查看';
                break;
            case 'best':
                $ret[$k]['name'] = '精品查看';
                break;
            case 'hot':
                $ret[$k]['name'] = '热销查看';
                break;
            case 'promote':
                $ret[$k]['name'] = '促销查看';
                break;
            case 'cxbd':
                $ret[$k]['name'] = '重新绑定';
                break;
            case 'ddcx':
                $ret[$k]['name'] = '订单查询';
                break;
            case 'kdcx':
                $ret[$k]['name'] = '快递查询';
                break;
            case 'qiandao':
                $ret[$k]['name'] = '签到送积分';
                break;
            }
        }
        $form_act = 'point';
        $smarty->assign('data', $ret);
        $smarty->assign('form_act', $form_act);
        $smarty->assign('wxch_lang', $wxch_lang);
        $smarty->display('wxch_point.html');
    }
}elseif ($_REQUEST['act'] == 'config') {
    if ($_POST) {
        $data            = array();
        $data['murl']    = $_POST['murl'];
        $data['baseurl'] = $_POST['baseurl'];
        foreach ($data as $k => $v) {
            $sql = "UPDATE  ".$weixincfgtable." SET  `cfg_value` =  '$v' WHERE  `cfg_name` = '$k';";
            $db->query($sql);
        }
        $link[] = array(
            'href' => 'wxch.php?act=config',
            'text' => '微信设置'
        );
        sys_msg('修改成功', 0, $link);
    } else {
        $ret      = $db->getAll("SELECT * FROM  ".$weixincfgtable);
        $wxchdata = array();
        foreach ($ret as $k => $v) {
            $wxchdata[$k] = $v;
            switch ($v['cfg_name']) {
                case 'murl':
                    $wxchdata[$k]['title'] = 'WAP手机站路径';
                    break;
                case 'baseurl':
                    $wxchdata[$k]['title'] = 'WAP手机版网址';
                    break;
            }
        }
        $smarty->assign('form_act', 'config');
        $smarty->assign('wxchdata', $wxchdata);
        $smarty->display('wxch_config.html');
    }
} elseif ($_REQUEST['act'] == 'regmsg') {
    if (!empty($_POST['regmsg'])) {
        $lang_name  = $_POST['act'];
        $lang_value = $_POST['regmsg'];
        $sql        = "SELECT * FROM ".$weixinlangtable." WHERE `lang_name` = 'regmsg'";
        $ret        = $db->getOne($sql);
        if ($ret) {
            $sql    = "UPDATE ".$weixinlangtable." SET `lang_value` = '$lang_value' WHERE `lang_name` = '$lang_name'";
            $ret    = $db->query($sql);
            $link[] = array(
                'href' => 'wxch.php?act=regmsg',
                'text' => '关注回复设置'
            );
            if ($ret) {
                sys_msg('修改成功', 0, $link);
            } else {
                sys_msg('修改成功，请重新修改', 0, $link);
            }
        } else {
            $sql    = "INSERT INTO ".$weixinlangtable." (`lang_name` ,`lang_value`) VALUES ( '$lang_name', '$lang_value')";
            $ret    = $db->query($sql);
            $link[] = array(
                'href' => 'wxch.php?act=regmsg',
                'text' => '关注回复设置'
            );
            if ($ret) {
                sys_msg('添加成功', 0, $link);
            } else {
                sys_msg('添加成功，请重新添加', 0, $link);
            }
        }
    } else {
        require(ROOT_PATH . 'includes/fckeditor/fckeditor.php');
        $editor             = new FCKeditor('regmsg');
        $editor->BasePath   = '../includes/fckeditor/';
        $editor->ToolbarSet = 'Normal';
        $editor->Width      = '80%';
        $editor->Height     = '320';
        $smarty->assign('FCKeditor', $FCKeditor);
        $sql = "SELECT `lang_value` FROM ".$weixinlangtable." WHERE `lang_name` = 'regmsg'";
        $ret = $db->getOne($sql);
        $smarty->assign('regmsg', $ret);
        $editor->Value = $ret;
        $FCKeditor     = $editor->CreateHtml();
        $smarty->assign('FCKeditor', $FCKeditor);
        $smarty->assign('form_act', 'regmsg');
        $smarty->display('wxch_regmsg.html');
    }
} elseif ($_REQUEST['act'] == 'keywords') {
    $record_count        = $db->getOne("SELECT count( id ) FROM ".$weixinkeywordstable." ");
    $filter['page']      = 1;
    $filter['page_size'] = 15;
    $full_page           = 1;
    if ($filter['page'] <= 1) {
        $start = 0;
    } else {
        $start = ($filter['page'] - 1) * $filter['page_size'];
    }
    $page_count           = ceil($record_count / $filter['page_size']);
    $filter['page_count'] = $page_count;
    $filter['start']      = $start;
    $ret                  = $db->getAll("SELECT * FROM ".$weixinkeywordstable." order by id desc LIMIT $start , $filter[page_size]");
    $wxchdata             = array();
    foreach ($ret as $k => $v) {
        if ($v['type'] == 1) {
            $v['type_name'] = '文字';
        } elseif ($v['type'] == 2) {
            $v['type_name'] = '图文';
        }
        $wxchdata[$k] = $v;
    }
    $filter['record_count'] = $record_count;
    $smarty->assign('wxchdata', $wxchdata);
    $smarty->assign('filter', $filter);
    $smarty->assign('full_page', $full_page);
    $smarty->display('wxch_keywords.html');
} elseif ($_REQUEST['act'] == 'edit_title') {
    $title = json_str_iconv(trim($_POST['val']));
    make_json_result(stripslashes($title));
} elseif ($_REQUEST['act'] == 'toggle_show') {
    $id  = intval($_POST['id']);
    $val = intval($_POST['val']);
    $db->query("UPDATE ".$weixinkeywordstable." SET `status` = '$val' WHERE `id` =$id;");
    clear_cache_files();
    make_json_result($val);
} elseif ($_REQUEST['act'] == 'remove') {
        $kws_id  = intval($_REQUEST['id']);
        $del_sql = "DELETE FROM ".$weixinkeywordstable." WHERE `id` = '$kws_id';";
        $db->query($del_sql);
        $url = 'wxch.php?act=keywords&act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
        ecs_header("Location: $url\n");
        exit;
} elseif ($_REQUEST['act'] == 'query') {
    $filter['page']      = $_POST['page'];
    $filter['page_size'] = $_POST['pagesize'];
    if (empty($filter['page_size'])) {
        $filter['page_size'] = 15;
    }
    $filter['page_count']   = ceil($_POST['page_count'] / $filter['page_size']);
    $filter['record_count'] = $_POST['record_count'];
    if ($filter['page'] <= 1) {
        $start = 0;
    } else {
        $start = ($filter['page'] - 1) * $filter['page_size'];
    }
    $filter['start'] = $start;
    $keyword         = $_POST['keyword'];
    if (empty($keyword)) {
        $ret = $db->getAll("SELECT * FROM ".$weixinkeywordstable." LIMIT $start , $filter[page_size]");
    } else {
        $ret = $db->getAll("SELECT * FROM ".$weixinkeywordstable." WHERE `name` LIKE '%$keyword%' LIMIT $start , $filter[page_size]");
    }
    $wxchdata = array();
    foreach ($ret as $k => $v) {
        if ($v['type'] == 1) {
            $v['type'] = '文字';
        } elseif ($v['type'] == 2) {
            $v['type'] = '图文';
        }
        $wxchdata[$k] = $v;
    }
    $smarty->assign('wxchdata', $wxchdata);
    $smarty->assign('filter', $filter);
    make_json_result($smarty->fetch('wxch_keywords.html'), '', array(
        'filter' => $filter,
        'page_count' => $filter['page_count']
    ));
}
?>