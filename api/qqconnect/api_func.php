<?php
/** 完美实现qq帐号登录ecshop插件
 * $Author: phplife qq:40499756 914091457 email:admin@topit.cn ydhcxh@126.com $
 * 版权所有 2010-2020 顶亿网，并保留所有权利。
 * 网站地址: http://www.topit.cn
 * 插件安装说明:http://ecshop.topit.cn/ecshop-plugin/ecshop_login_with_qq_account_v2.0-233.html
 * 插件会不断更新 新版下载发布地址：http://bbs.topit.cn/thread-829-1-1.html
 * 此插件您可以自由使用，但请保留此开发者的相关信息，
*/
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
function check_privilege()
{
	if (!isset($_SESSION['admin_id']) || intval($_SESSION['admin_id']) <= 0)
	{
		if (!empty($_COOKIE['ECSCP']['admin_id']) && !empty($_COOKIE['ECSCP']['admin_pass']))
		{
			// 找到了cookie, 验证cookie信息
			$sql = 'SELECT user_id, user_name, password, action_list, last_login ' .
					' FROM ' .$ecs->table('admin_user') .
					" WHERE user_id = '" . intval($_COOKIE['ECSCP']['admin_id']) . "'";
			$row = $db->GetRow($sql);
			if (!$row)
			{
                 return false;
			}
			else
			{
				// 检查密码是否正确
				if (md5($row['password'] . $_CFG['hash_code']) == $_COOKIE['ECSCP']['admin_pass'])
				{
					 return true;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}
	}
	return true;
}

function show_api_message($content, $links = '', $hrefs = '', $type = 'info', $auto_redirect = true)
{
    assign_template();
	$msg['content'] = $content;
    if (is_array($links) && is_array($hrefs))
    {
        if (!empty($links) && count($links) == count($hrefs))
        {
            foreach($links as $key =>$val)
            {
                $msg['url_info'][$val] = $hrefs[$key];
            }
            $msg['back_url'] = $hrefs['0'];
        }
    }
    else
    {
        $link   = empty($links) ? $GLOBALS['_LANG']['back_up_page'] : $links;
        $href    = empty($hrefs) ? 'javascript:history.back()'       : $hrefs;
        $msg['url_info'][$link] = $href;
        $msg['back_url'] = $href;
    }

    $msg['type']    = $type;
    $position = assign_ur_here(0, $GLOBALS['_LANG']['sys_msg']);
    $GLOBALS['smarty']->assign('page_title', $position['title']);   // 页面标题
    $GLOBALS['smarty']->assign('ur_here',    $position['ur_here']); // 当前位置
    $GLOBALS['smarty']->assign('auto_redirect', $auto_redirect);
	$GLOBALS['smarty']->assign('act', 'message');
    $GLOBALS['smarty']->assign('message', $msg);
    die($GLOBALS['smarty']->fetch($GLOBALS['api_tpl']));
}

function get_app_name($path='')
{
   if (!$path){$path=$_SERVER['PHP_SELF'];}
   $current_directory = dirname($path);
   $current_directory = str_replace('\\','/',$current_directory);
   $current_directory = explode('/',$current_directory);
   $current_directory = end($current_directory);
   return $current_directory;
}

/**
 * 读结果缓存文件
 *
 * @params  string  $cache_name
 *
 * @return  array   $data
 */
function api_read_static_cache($cache_name)
{

    static $result = array();
    if (!empty($result[$cache_name]))
    {
        return $result[$cache_name];
    }
    $cache_file_path = ROOT_PATH . '/data/' . $cache_name . '.php';
    if (file_exists($cache_file_path))
    {
        include_once($cache_file_path);
        $result[$cache_name] = $data;
        return $result[$cache_name];
    }
    else
    {
        return false;
    }
}

/**
 * 写结果缓存文件
 *
 * @params  string  $cache_name
 * @params  string  $caches
 *
 * @return
 */
function api_write_static_cache($cache_name, $caches)
{
    $cache_file_path = ROOT_PATH . '/data/' . $cache_name . '.php';
    $content = "<?php\r\n";
    $content .= "\$data = " . var_export($caches, true) . ";\r\n";
    $content .= "?>";
    file_put_contents($cache_file_path, $content, LOCK_EX);
}

?>
