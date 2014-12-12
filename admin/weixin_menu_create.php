<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$ret = $db->getRow("SELECT * FROM ". $GLOBALS['ecs']->table('weixin_config') ." WHERE `id` = 1");
$weixinappid = $ret['appid'];
$weixinappsecret = $ret['appsecret'];
$access_token_weixin = get_access_token($weixinappid,$weixinappsecret);
define("ACCESS_TOKEN", $access_token_weixin);

//自定义菜单中获取access_token  
function get_access_token($appid,$secret){  
	$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;  
    $json=http_request_json($url);//这个地方不能用file_get_contents  
    $data=json_decode($json,true);  
    if($data['access_token']){  
       return $data['access_token'];  
    }else{  
       return "获取access_token错误";  
    }         
}  
//因为url是https 所有请求不能用file_get_contents,用curl请求json 数据  
function http_request_json($url){    
   $ch = curl_init();  
   curl_setopt($ch, CURLOPT_URL,$url);  
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
   $result = curl_exec($ch);  
   curl_close($ch);  
   return $result;    
}  

//创建菜单
function createMenu($data){
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tmpInfo = curl_exec($ch);
 if (curl_errno($ch)) {
  return curl_error($ch);
 }
 curl_close($ch);
 return $tmpInfo;
}

	function curl_menu($ACCESS_TOKEN,$data)
    {
		$ch = curl_init(); 
		 curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$ACCESS_TOKEN); 
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		 $tmpInfo = curl_exec($ch); 
		 if (curl_errno($ch)) {  
		 
			echo 'Errno'.curl_error($ch);
		 }
		 curl_close($ch); 
		$arr= json_decode($tmpInfo,true);
		return $arr;
    }

function getmenu() {
 $keyword = array();
 $sql="SELECT cat_id, cat_name, weixin_type, links, weixin_key as wkey FROM ". $GLOBALS['ecs']->table('weixin_menu') ." WHERE parent_id = 0 order by sort_order ASC,cat_id desc";
 $topmemu = $GLOBALS['db']->getAll($sql);
	
 foreach ($topmemu as $key) {
 $sql="SELECT cat_id, cat_name, weixin_type, links, weixin_key as wkey FROM ". $GLOBALS['ecs']->table('weixin_menu') ." WHERE parent_id =". $key['cat_id']."  order by sort_order ASC,cat_id desc";
 $nextmenu = $GLOBALS['db']->getAll($sql);

   if(count($nextmenu) != 0){//没有下级栏目
      foreach ($nextmenu as $key2) {
		if($key2['weixin_type']>0){
           $kk[] = array('type' => 'view', 'name' => $key2['cat_name'], 'url' => $key2['links']);
		}else{
           $kk[] = array('type' => 'click', 'name' => $key2['cat_name'], 'key' => $key2['wkey']);
		}
      }
      $keyword['button'][] = array('name' => $key['cat_name'], 'sub_button' => $kk);
      $kk = '';
   }else{
      if($key['weixin_type']>0){
		$keyword['button'][] = array('type' => 'view', 'name' => $key['cat_name'], 'url' => $key['links']);
      }else{
        $keyword['button'][] = array('type' => 'click', 'name' => $key['cat_name'], 'key' => $key['wkey']);
      }
   }
 }
return json_encode($keyword);
}
$data = getmenu();
$msg = curl_menu(ACCESS_TOKEN, preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $data));
            if ($msg['errmsg'] == 'ok') {
                echo '创建自定义菜单成功!';
                exit;
            } else {
                echo '创建自定义菜单失败!';
                exit;
            }
?>