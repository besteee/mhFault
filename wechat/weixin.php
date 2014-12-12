<?php
define('IN_ECS', true);
error_reporting(0);
require(dirname(__FILE__) . '/../includes/init.php');
require('callback.php');
$wechatObj = new wechatCallbackapi();
$ecdb -> prefix = $ecs -> prefix;
$wechatObj -> valid($db,$ecdb);
$base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/';
$db -> prefix = $ecs -> prefix;
$wechatObj -> responseMsg($db, $user, $base_url);
?>