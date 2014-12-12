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
if(empty($api_config['qq_appid']) || empty($api_config['qq_appkey']))
{
 die('配置文件丢失');
}

/**
 * 在你运行本demo之前请到 http://connect.opensns.qq.com/申请appid, appkey, 并注册callback地址
 */
//申请到的appid
//$_SESSION["appid"]    = yourappid; 
$_SESSION["appid"]    = $api_config['qq_appid']; 

//申请到的appkey
//$_SESSION["appkey"]   = "yourappkey"; 
$_SESSION["appkey"]   = $api_config['qq_appkey']; 

//QQ登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败。
//$_SESSION["callback"] = "http://your domain/oauth/get_access_token.php"; 
$_SESSION["callback"] = $api_url . "/interface.php?act=login_callback";

//QQ授权api接口.按需调用//get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo
$_SESSION["scope"] ="get_user_info";

//print_r ($_SESSION);

?>
