<?php
/** 完美实现qq帐号登录ecshop插件
 * $Author: phplife qq:40499756 914091457 email:admin@topit.cn ydhcxh@126.com $
 * 版权所有 2010-2020 顶亿网，并保留所有权利。
 * 网站地址: http://www.topit.cn
 * 插件安装说明:http://ecshop.topit.cn/ecshop-plugin/ecshop_login_with_qq_account_v2.0-233.html
 * 插件会不断更新 新版下载发布地址：http://bbs.topit.cn/thread-829-1-1.html
 * 此插件您可以自由使用，但请保留此开发者的相关信息，
*/

/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.2
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */

/**
 * @brief 本文件包含了OAuth认证过程中会用到的公用方法 
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

function do_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}

function get_url_contents($url)
{
    if (ini_get("allow_url_fopen") == "1" && function_exists('file_get_contents'))
    {
         return file_get_contents($url);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result =  curl_exec($ch);
    curl_close($ch);
    return $result;
}

function qq_login($appid, $scope, $callback)
{
    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $appid . "&redirect_uri=" . urlencode($callback)
        . "&state=" . $_SESSION['state']
        . "&scope=".$scope;
    header("Location:$login_url");
}

function qq_callback()
{
    //debug
    //print_r($_REQUEST);
    //print_r($_SESSION);
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $_SESSION["appid"]. "&redirect_uri=" . urlencode($_SESSION["callback"])
            . "&client_secret=" . $_SESSION["appkey"]. "&code=" . $_REQUEST["code"];

        $response = get_url_contents($token_url);
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }

        $params = array();
        parse_str($response, $params);

        //debug
        //print_r($params);

        //set access token to session
        $_SESSION["access_token"] = $params["access_token"];
}

function get_qq_user_info()
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['access_token']
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . $_SESSION["openid"]
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

function get_openid()
{
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
        . $_SESSION['access_token'];

    $str  = get_url_contents($graph_url);
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
    }

    //debug
    //echo("Hello " . $user->openid);

    //set openid to session
    $_SESSION["openid"] = $user->openid;
    setcookie("qq_openid", $_SESSION["openid"], time() + 68400 , $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
}

function add_blog()
{
	//发表QQ空间日志的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/blog/add_one_blog";
    $data = "access_token=".$_SESSION["access_token"]
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".$_SESSION["openid"]
        ."&format=".$_POST["format"]
        ."&title=".$_POST["title"]
        ."&content=".$_POST["content"];

    $ret = do_post($url, $data); 
    return $ret;
}

function add_weibo()
{
	//发表微博的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/wb/add_weibo";
    $data = "access_token=".$_SESSION["access_token"]
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".$_SESSION["openid"]
        ."&format=".$_POST["format"]
        ."&type=".$_POST["type"]
        ."&content=".urlencode($_POST["content"])
        ."&img=".urlencode($_POST["img"]);

    //echo $data;
    $ret = do_post($url, $data); 
    return $ret;
}

function add_topic()
{
	//发表QQ空间日志的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/shuoshuo/add_topic";
    $data = "access_token=".$_SESSION["access_token"]
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".$_SESSION["openid"]
        ."&format=".$_POST["format"]
        ."&richtype=".$_POST["richtype"]
        ."&richval=".urlencode($_POST["richval"])
        ."&con=".urlencode($_POST["con"])
        ."&lbs_nm=".$_POST["lbs_nm"]
        ."&lbs_x=".$_POST["lbs_x"]
        ."&lbs_y=".$_POST["lbs_y"]
        ."&third_source=".$_POST["third_source"];

    //echo $data;
    $ret = do_post($url, $data); 
    return $ret;
}

function add_album()
{
	//创建QQ空间相册的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/photo/add_album";
    $data = "access_token=".$_SESSION["access_token"]
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".$_SESSION["openid"]
        ."&format=".$_POST["format"]
        ."&albumname=".urlencode($_POST["albumname"])
        ."&albumdesc=".urlencode($_POST["albumdesc"])
        ."&priv=".$_POST["priv"];

    //echo $data;

    $ret =  do_post($url, $data); 
    return $ret;
}

function list_album()
{
    //获取相册列表的接口地址, 不要更改!!
    $url = "https://graph.qq.com/photo/list_album?"
        ."access_token=".$_SESSION["access_token"]
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".$_SESSION["openid"]
        ."&format=json";
    //echo $url;
    $ret = get_url_contents($url);
    return $ret;
}

function upload_pic()
{
	//上传照片的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/photo/upload_pic";

    $params["access_token"] = $_SESSION["access_token"]; 
    $params["oauth_consumer_key"] = $_SESSION["appid"];
    $params["openid"] = $_SESSION["openid"];
    $params["photodesc"] = urlencode($_POST["photodesc"]);
    $params["title"] = urlencode($_POST["title"]);
    $params["albumid"] = urlencode($_POST["albumid"]);
    $params["x"] = $_POST["x"];
    $params["y"] = $_POST["y"];
    $params["format"] = $_POST["format"];
    
    //处理上传图片
    foreach ($_FILES as $filename => $filevalue)
    {   
        $tmpfile = dirname($filevalue["tmp_name"])."/".$filevalue["name"];
        move_uploaded_file($filevalue["tmp_name"], $tmpfile);
        $params[$filename] = "@$tmpfile";
    }

    $ret =  do_post($url, $params);
    unlink($tmpfile);
    //echo $tmpfile;
    return $ret;

}

function add_share()
{
    //发布一条动态的接口地址, 不要更改!!
    $url = "https://graph.qq.com/share/add_share?"
        ."access_token=".$_SESSION["access_token"]
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".$_SESSION["openid"]
        ."&format=json"
        ."&title=".urlencode($_REQUEST["title"])
        ."&url=".urlencode($_REQUEST["url"])
        ."&comment=".urlencode($_REQUEST["comment"])
        ."&summary=".urlencode($_REQUEST["summary"])
        ."&images=".urlencode($_REQUEST["images"]);

    //echo $url;

    $ret = get_url_contents($url);
}
if (!function_exists('json_decode'))
{
	function json_decode($content,$assoc=true)
	{
		require_once(ROOT_PATH . 'includes/cls_json.php');
		$json = new JSON;
		return $json->decode($content,$assoc);
	}
}
?>
