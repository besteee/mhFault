<?php
class wechatCallbackapi{
    public function valid($db,$ecdb){
        $echoStr = $_GET["echostr"];
        if($this -> checkSignature($db,$ecdb)){
            echo $echoStr;
            return true;
        }
    }
    public function responseMsg($db, $user, $base_url){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		$weixinusertable = $db -> prefix . 'weixin_user';
		$weixinlangtable = $db -> prefix . 'weixin_lang';
		$weixincfgtable = $db -> prefix . 'weixin_cfg';
		$weixinconfigtable = $db -> prefix . 'weixin_config';
		$weixinkeywordstable = $db -> prefix . 'weixin_keywords';
		$weixinbonustable = $db -> prefix . 'weixin_bonus';
		$weixinpointtable = $db -> prefix . 'weixin_point';
		$weixinpointrecordtable = $db -> prefix . 'weixin_point_record';
        $debug = 0;
        if($_GET['debug'] == 1){
            $debug = 1;
        }
        if (!empty($postStr) or $debug == 1){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj -> FromUserName;
            $msgType = $postObj -> MsgType;
            $toUsername = $postObj -> ToUserName;
            $keyword = trim($postObj -> Content);
            if(empty($keyword)){
                $keyword = $_GET['keyword'];
            }
            if(empty($fromUsername)){
                $fromUsername = 'opSicjigYKxue3QWHbWEGAd8VKPA';
            }
            $time = time();
            $lang = array();
            $ret = $db -> getRow("SELECT `setp`,`uname` FROM ".$weixinusertable." WHERE `wxid` = '$fromUsername'");
            $setp = $ret['setp'];
            $uname = $ret['uname'];
            $m_ret = $db -> getRow("SELECT * FROM  ".$weixincfgtable." WHERE `cfg_name` = 'murl'");
            $base_ret = $db -> getRow("SELECT * FROM  ".$weixincfgtable." WHERE `cfg_name` = 'baseurl'");
            if(empty($base_ret['cfg_value'])){
                $m_url = $base_url . $m_ret['cfg_value'];
            }else{
                $m_url = $base_ret['cfg_value'] . $m_ret['cfg_value'];
                $base_url = $base_ret['cfg_value'];
            }
            $thistable = $db -> prefix . 'users';
            $ret = $db -> getRow("SELECT `user_id` FROM `$thistable` WHERE `user_name` ='$uname'");
            $user_id = $ret['user_id'];
            $ret = $db -> getRow("SELECT `wxid` FROM ".$weixinusertable." WHERE `wxid` = '$fromUsername'");
            if(empty($ret)){
                if(!empty($fromUsername)){
                    $db -> query("INSERT INTO ".$weixinusertable." ( `wxid`) VALUES ('$fromUsername')");
                }
            }
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
			$imageTpl = "<xml>
                         <ToUserName><![CDATA[%s]]></ToUserName>
                         <FromUserName><![CDATA[%s]]></FromUserName>
                         <CreateTime>%s</CreateTime>
                         <MsgType><![CDATA[%s]]></MsgType>
                         <ArticleCount>%s</ArticleCount>
                         <Articles>
                         %s
                         </Articles>
                         <FuncFlag>0</FuncFlag>
                         </xml>";
			$newsTpl = "<xml>
                         <ToUserName><![CDATA[%s]]></ToUserName>
                         <FromUserName><![CDATA[%s]]></FromUserName>
                         <CreateTime>%s</CreateTime>
                         <MsgType><![CDATA[%s]]></MsgType>
                         <ArticleCount>%s</ArticleCount>
                         <Articles>
                         %s
                         </Articles>
                         <FuncFlag>0</FuncFlag>
                         </xml>";
            if ($postObj->MsgType == 'event') {
                $Eventkeyword = $postObj->EventKey;
				if ($Eventkeyword ==''){
					$thistable = $db -> prefix . 'users';
					$retuser = $db -> getRow( "select uname from ".$weixinusertable." WHERE `wxid`= '$fromUsername' and uname!='';");
					$msgType = "text";
					$lang['regmsg'] = $db -> getOne("SELECT `lang_value` FROM ".$weixinlangtable." WHERE `lang_name` = 'regmsg'");
					if(empty($retuser)){
						$contentgz = $lang['regmsg'];

						srand((double)microtime()*1000000);
						$ychar="0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
						$list=explode(",",$ychar);
						for($i=0;$i<6;$i++){
						$randnum=rand(0,35);
						$password.=$list[$randnum];
						}
						$password2 = md5($password);
						$ret = $db -> getRow("select max(uid) as userid from `$weixinusertable`");
						$weixinuser = "weixin".$ret['userid'];
						$db -> query("INSERT INTO `$thistable` (`user_name`, `password`) VALUES ('$weixinuser', '$password2');");
						$db -> query("UPDATE ".$weixinusertable." SET `uname` = '$weixinuser' , `setp` = 3 WHERE `wxid`= '$fromUsername';");
						$contentreg = "\n恭喜您,用户注册成功!\n用户为:".$weixinuser."\n密码为:".$password."\n<a href='".$m_url."user.php?wxid=".$fromUsername."'>进入会员中心</a>";
						$gzshb = $this->coupon($db, $fromUsername);
						$contentStr = $contentgz.$contentreg.$gzshb;
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
						exit;
					}else{
						$gzshb = $this->coupon($db, $fromUsername);
						$contentStr = $lang['regmsg'].$gzshb;
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
						exit;
					}
				}else{
                $keyword = $postObj->EventKey;
				}
            }
            $auto_res = $ret = $db -> getAll("SELECT * FROM ".$weixinkeywordstable);
            if(count($auto_res) > 0){
                foreach($auto_res as $k => $v){
                    $res_ks = explode(' ', $v['keyword']);
                    if($v['type'] == 1){
                        $msgType = "text";
                        foreach($res_ks as $kk => $vv){
                            if($vv == $keyword){
                                $contentStr = $v['contents'];
                                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                echo $resultStr;
                                $db -> query("UPDATE ".$weixinkeywordstable." SET `count` = `count`+1 WHERE `id` =$v[id]");
                            }
                        }
                    }
                    if($v['type'] == 2){
                        $msgType = "news";
                        foreach($res_ks as $kk => $vv){
                            if($vv == $keyword){
                $ArticleCount = 1;
                        $v['images'] = $base_url .'data/weixin/'. $v['pic'];
                        $items .= "<item>
						 <Title><![CDATA[" . $v['pic_tit'] . "]]></Title>
						 <Description><![CDATA[" . $v['desc'] . "]]></Description>
						 <PicUrl><![CDATA[" . $v['images'] . "]]></PicUrl>
						 <Url><![CDATA[" . $v['pic_url'] . "]]></Url>
                 </item>";
                $resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                                echo $resultStr;
                                $db -> query("UPDATE ".$weixinkeywordstable." SET `count` = `count`+1 WHERE `id` =$v[id]");
                            }
                        }
                    }
                }
            }
            if($setp > 0 and $setp < 3){
                $msgType = "text";
                if($keyword == 'quit'){
                    $db -> query("UPDATE ".$weixinusertable." SET `setp`= 0 WHERE `wxid`= '$fromUsername';");
                    $contentStr = "您已退出会员绑定流程，再次绑定输入【cxbd】进入绑定流程";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                if($setp == 1){
                    $users_table = $db -> prefix . 'users';
                    $ret = $db -> getRow("SELECT `user_name` FROM  `$users_table` WHERE `user_name` = '$keyword'");
                    if(empty($ret)){
                        $contentStr ="您输入的用户名不存在，检查之后请重新输入：" . $keyword."\n退出绑定回复【quit】";
                    }else{
                        $ret = $db -> getRow("SELECT `uname` FROM  ".$weixinusertable." WHERE `uname` = '$keyword'");
                        if(!empty($ret)){
                            $contentStr = $keyword . "已经被其他用户绑定了，请绑定其他账号\n退出绑定回复【quit】";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                            exit;
                        }
                        $db -> query("UPDATE ".$weixinusertable." SET `setp`=`setp`+1 WHERE `wxid`= '$fromUsername';");
                        $db -> query("UPDATE ".$weixinusertable." SET `uname` = '$keyword' WHERE `wxid`= '$fromUsername';");
                        $contentStr = '请输入密码';
                    }
                }elseif($setp == 2){
                    $password = $keyword;
                    $verifyLogin = $user -> login($uname, $password, '');
                    if(!$verifyLogin){
                        $contentStr = "您输入的密码不正确，请重新输入\n退出绑定回复【quit】";
                    }else{
                        $db -> query("UPDATE ".$weixinusertable." SET `setp`=`setp`+1 WHERE `wxid`= '$fromUsername';");
                        $contentStr = $uname . '，您的账号已经绑定成功！';
                    }
                }
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                $this->plusPoint($db, $uname, $keyword, $fromUsername);
                echo $resultStr;
                exit;
            }
            if($keyword == 'debug'){
                $msgType = "text";
                $contentStr = "Welcome to here!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                exit;
            }elseif($keyword == 'member'){
                $msgType = "text";
				$contentStr = "<a href='".$m_url."user.php?wxid=".$fromUsername."'>点击进入会员中心</a>";
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				echo $resultStr;
				exit;
            } elseif ($keyword == 'qiandao') {
                $jf_state = $db->getOne("SELECT `autoload` FROM ".$weixinpointtable." WHERE `point_name` = '$keyword'");
                $msgType = "text";
                if ($jf_state == 'yes') {
                    $qd_jf = $db->getOne("SELECT `point_value` FROM ".$weixinpointtable." WHERE `point_name` = '$keyword'");
                    $res = $this->plusPoint($db, $uname, $keyword, $fromUsername);
                    if ($res['errmsg'] == 'ok') {
                        $contentStr = $res['contentStr'] . $qd_jf;
                    } else {
                        $contentStr = $res['contentStr'];
                    }
                } elseif ($jf_state == 'no') {
                    $contentStr = '签到送积分已停止使用';
                }
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                exit;
            } elseif ($keyword == 'jfcx') {
				$ret = $db -> getRow("SELECT `uname` FROM ".$weixinusertable." WHERE `wxid` = '$fromUsername'");
				$uname = $ret['uname'];
                $thistable = $db->prefix . 'users';
                $sql = "SELECT * FROM `$thistable` WHERE `user_name` = '$uname'";
                $ret = $db->getRow($sql);
                $pay_points = $ret['pay_points'];
                $money = $ret['user_money'];
                $msgType = "text";
                $contentStr = "余额：$money\r\n积分：$pay_points";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                exit;
            } elseif ($keyword == 'ddcx') {
                $ArticleCount = 1;
                $msgType = "news";
                $thistable = $db->prefix . 'order_info';
                $order_goods_tb = $db->prefix . 'order_goods';
                    $query_sql = "SELECT * FROM `$thistable` WHERE `user_id` = '$user_id' ORDER BY `order_id` DESC";
                    $orders = $db->getRow($query_sql);
                    $order_id = $orders['order_id'];
                    $order_goods = $db->getAll("SELECT * FROM `$order_goods_tb`  WHERE `order_id` = '$order_id'");
                $shopinfo = '';
                if (!empty($order_goods)) {
                    foreach ($order_goods as $v) {
                        if (empty($v['goods_attr'])) {
                            $shopinfo.= $v['goods_name'] . '(' . $v['goods_number'] . '),';
                        } else {
                            $shopinfo.= $v['goods_name'] . '（' . $v['goods_attr'] . '）' . '(' . $v['goods_number'] . '),';
                        }
                    }
                    $shopinfo = substr($shopinfo, 0, strlen($shopinfo) - 1);
                    $title = '最近订单：' . $orders['order_sn'];
                    if ($orders['pay_status'] == 0) {
                        $pay_status = '支付状态：未付款';
                    } elseif ($orders['pay_status'] == 1) {
                        $pay_status = '支付状态：付款中';
                    } elseif ($orders['pay_status'] == 2) {
                        $pay_status = '支付状态：已付款';
                    }
                    $url = $m_url . 'user.php?act=order_detail&order_id=' . $orders['order_id'] . '&wxid='.$fromUsername;
                    if ($orders['order_amount'] == 0.00) {
                        if ($orders['money_paid'] > 0) {
                            $orders['order_amount'] = $orders['money_paid'];
                        }
                    }
                    $description = '商品信息：' . $shopinfo . "\r\n总金额：" . $orders['order_amount'] . "\r\n" . $pay_status . "\r\n快递公司：" . $orders['shipping_name'] . "\r\n物流单号：" . $orders['invoice_no'];
                    $items = "<item>
                 <Title><![CDATA[" . $title . "]]></Title>
                 <Description><![CDATA[" . $description . "]]></Description>
                 <PicUrl><![CDATA[]]></PicUrl>
                 <Url><![CDATA[" . $url . "]]></Url>
                 </item>";
                    $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                    $w_message = '图文消息';
                    $this->plusPoint($db, $uname, $keyword, $fromUsername);
                    echo $resultStr;
                } else {
                    $msgType = "text";
                    $contentStr = "您还没有订单";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                exit;
            } elseif ($keyword == 'kdcx') {
                $thistable = $db->prefix . 'order_info';
                if (!empty($user_id)) {
                    $orders = $db->getRow("SELECT * FROM `$thistable` WHERE `user_id` = '$user_id' ORDER BY `order_id` DESC");
                } else {
                    $table2 = $db->prefix . 'users';
                    $ret = $db->getRow("SELECT `user_id` FROM `$table2` WHERE `wxid` ='$fromUsername'");
                    $user_id = $ret['user_id'];
                    $orders = $db->getRow("SELECT * FROM `$thistable` WHERE `user_id` = '$user_id' ORDER BY `order_id` DESC");
                }
                if (empty($orders)) {
                    $msgType = "text";
                    $contentStr = '您还没有订单，无法查询快递';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                if (empty($orders['invoice_no'])) {
                    $msgType = "text";
                    $contentStr = '订单号：' . $orders['order_sn'] . '还没有快递单号，不能查询';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                $k_arr = $this->kuaidi($orders['invoice_no'], $orders['shipping_name']);
                $contents = '';
                if ($k_arr['message'] == 'ok') {
                    $count = count($k_arr['data']) - 1;
                    for ($i = $count; $i >= 0; $i--) {
                        $contents.= "\r\n" . $k_arr['data'][$i]['time'] . "\r\n" . $k_arr['data'][$i]['context'];
                    }
                    $msgType = "text";
                    $contentStr = "快递信息" . $contents;
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    $this->plusPoint($db, $uname, $keyword, $fromUsername);
                    echo $resultStr;
                    exit;
                }
            }elseif($keyword == 'new'){
                $thistable = $db -> prefix . 'goods';
                $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE `is_on_sale` = 1 AND `is_alone_sale` = 1 AND `is_delete` = 0 AND `is_new` = 1 ORDER BY sort_order,last_update DESC LIMIT 0 , 5");
                $ArticleCount = count($ret);
                if($ArticleCount >= 1){
                    foreach($ret as $v){
                        $v['thumbnail_pic'] = $base_url . $v['goods_img'];
                        $goods_url = $m_url . 'goods.php?id=' . $v['goods_id'] . '&wxid='.$fromUsername;
                        $items .= "<item>
                 <Title><![CDATA[" . $v['goods_name'] . "]]></Title>
                 <PicUrl><![CDATA[" . $v['thumbnail_pic'] . "]]></PicUrl>
                 <Url><![CDATA[" . $goods_url . "]]></Url>
                 </item>";
                    }
                    $msgType = "news";
                }
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                $this->plusPoint($db, $uname, $keyword, $fromUsername);
                echo $resultStr;
                exit;
            }elseif($keyword == 'best'){
                $thistable = $db -> prefix . 'goods';
                $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE `is_on_sale` = 1 AND `is_alone_sale` = 1 AND `is_delete` = 0 AND `is_best` = 1 ORDER BY sort_order,last_update DESC LIMIT 0 , 5");
                $ArticleCount = count($ret);
                if($ArticleCount >= 1){
                    foreach($ret as $v){
                        $v['thumbnail_pic'] = $base_url . $v['goods_img'];
                        $goods_url = $m_url . 'goods.php?id=' . $v['goods_id'] . '&wxid='.$fromUsername;
                        $items .= "<item>
                 <Title><![CDATA[" . $v['goods_name'] . "]]></Title>
                 <PicUrl><![CDATA[" . $v['thumbnail_pic'] . "]]></PicUrl>
                 <Url><![CDATA[" . $goods_url . "]]></Url>
                 </item>";
                    }
                    $msgType = "news";
                }
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                $this->plusPoint($db, $uname, $keyword, $fromUsername);
                echo $resultStr;
                exit;
            }elseif($keyword == 'hot'){
                $thistable = $db -> prefix . 'goods';
                $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE `is_on_sale` = 1 AND `is_alone_sale` = 1 AND `is_delete` = 0 AND `is_hot` = 1 ORDER BY sort_order,last_update DESC LIMIT 0 , 5");
                $ArticleCount = count($ret);
                if($ArticleCount >= 1){
                    foreach($ret as $v){
                        $v['thumbnail_pic'] = $base_url . $v['goods_img'];
                        $goods_url = $m_url . 'goods.php?id=' . $v['goods_id'] . '&wxid='.$fromUsername;
                        $items .= "<item>
                 <Title><![CDATA[" . $v['goods_name'] . "]]></Title>
                 <PicUrl><![CDATA[" . $v['thumbnail_pic'] . "]]></PicUrl>
                 <Url><![CDATA[" . $goods_url . "]]></Url>
                 </item>";
                    }
                    $msgType = "news";
                }
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                $this->plusPoint($db, $uname, $keyword, $fromUsername);
                echo $resultStr;
                exit;
            }elseif($keyword == 'promote'){
				$time = gmtime();
                $thistable = $db -> prefix . 'goods';
                $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE `is_on_sale` = 1 AND `is_alone_sale` = 1 AND `is_delete` = 0 AND `is_promote` = 1 AND promote_start_date <= '$time' AND promote_end_date >= '$time' ORDER BY sort_order,last_update DESC LIMIT 0 , 5");
                $ArticleCount = count($ret);
                if($ArticleCount >= 1){
                    foreach($ret as $v){
                        $v['thumbnail_pic'] = $base_url . $v['goods_img'];
                        $goods_url = $m_url . 'goods.php?id=' . $v['goods_id'] . '&wxid='.$fromUsername;
                        $items .= "<item>
                 <Title><![CDATA[" . $v['goods_name'] . "]]></Title>
                 <PicUrl><![CDATA[" . $v['thumbnail_pic'] . "]]></PicUrl>
                 <Url><![CDATA[" . $goods_url . "]]></Url>
                 </item>";
                    }
                    $msgType = "news";
                }
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                $this->plusPoint($db, $uname, $keyword, $fromUsername);
                echo $resultStr;
                exit;
            }elseif($keyword == 'cxbd'){
                $ret = $db -> getAll("SELECT `uname` FROM  ".$weixinusertable);
				$db -> query("UPDATE ".$weixinusertable." SET `setp` = 0 WHERE `wxid`= '$fromUsername';");
                    $contentStr = '您已进入会员绑定流程，想要退出绑定流程请回复【quit】,继续请输入网站会员昵称';
                    $db -> query("UPDATE ".$weixinusertable." SET `setp`=`setp`+1 WHERE `wxid`= '$fromUsername';");
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                exit;
            }elseif(!empty($keyword)){
                $thistable = $db -> prefix . 'goods';
                $goods_name = $keyword;
                $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE  `goods_name` LIKE '%$goods_name%' LIMIT 0,5");
                $ArticleCount = count($ret);
                if($ArticleCount >= 1){
                    foreach($ret as $v){
                        $v['thumbnail_pic'] = $base_url . $v['goods_img'];
                        $goods_url = $m_url . 'goods.php?id=' . $v['goods_id'] . '&wxid='.$fromUsername;
                        $items .= "<item>
                 <Title><![CDATA[" . $v['goods_name'] . "]]></Title>
                 <PicUrl><![CDATA[" . $v['thumbnail_pic'] . "]]></PicUrl>
                 <Url><![CDATA[" . $goods_url . "]]></Url>
                 </item>";
                    }
                    $msgType = "news";
                }else{
                    $msgType = "text";
                    $thistable = $db -> prefix . 'goods';
                    $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE  `is_best` =1");
                    $tj_count = count($ret);
                    $tj_key = mt_rand(0, $tj_count);
                    $tj_goods = $ret[$tj_key];
                    $tj_str = $this -> plusTj($db, $m_url,$fromUsername);
                    $contentStr = '没有搜索到"' . $goods_name . '"的商品' . $tj_str;
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                echo $resultStr;
                exit;
            }else{
				echo "";
				exit;
            }
        }else{
            echo "";
            exit;
        }
    }
    protected function plusTj($db, $m_url,$fromUsername){
        $thistable = $db -> prefix . 'goods';
        $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE `is_delete`=0 and `is_on_sale`=1 and `is_best` =1");
        $tj_count = count($ret);
        $tj_key = mt_rand(0, $tj_count);
        $tj_goods = $ret[$tj_key];
        return $tj_str = "\r\n我们为您推荐:" . '<a href="' . $m_url . 'goods.php?id=' . $tj_goods[goods_id] . '&wxid='.$fromUsername.'">' . $tj_goods[goods_name] . '</a>';
    }
    protected function getNews($db, $base_url){
        $thistable = $db -> prefix . 'goods';
        $ret = $db -> getAll("SELECT * FROM  `$thistable` ORDER BY `add_time` LIMIT 0 , 5");
        $ArticleCount = count($ret);
        if($ArticleCount >= 1){
            foreach($ret as $v){
                $v['thumbnail_pic'] = $base_url . $v['goods_img'];
                $goods_url = $m_url . 'goods.php?id=' . $v['goods_id'] . '&wxid='.$fromUsername;
                $items .= "<item>
             <Title><![CDATA[" . $v['goods_name'] . "]]></Title>
             <PicUrl><![CDATA[" . $v['thumbnail_pic'] . "]]></PicUrl>
             <Url><![CDATA[" . $goods_url . "]]></Url>
             </item>";
            }
        }
        $data = array();
        $data['ArticleCount'] = $ArticleCount;
        $data['items'] = $items;
        return $data;
    }
    protected function coupon($db, $fromUsername) {
		$weixinusertable = $db -> prefix . 'weixin_user';
		$weixinbonustable = $db -> prefix . 'weixin_bonus';
        $retc = $db->getRow("SELECT `coupon` FROM `$weixinusertable` WHERE `wxid` ='$fromUsername'");
        if (!empty($retc['coupon'])) {
            $contentStr = "\r\n您已经领取过红包:" . $retc['coupon'];
            return $contentStr;
        } else {
            $ret = $db->getRow("SELECT * FROM `$weixinbonustable` WHERE `id` = 1");
            $type_id = $ret['type_id'];
            $thistable = $db->prefix . 'bonus_type';
            $ret = $db->getRow("SELECT * FROM `$thistable` WHERE `type_id` =$type_id ");
            $type_money = $ret['type_money'];
            $use_end_date = date("Y年-m月-d日", $ret['use_end_date']);
            $time = time();
            if (($time >= $ret['send_start_date']) or ($time <= $ret['send_end_date'])) {
                $thistable = $db->prefix . 'user_bonus';
                $ret = $db->getRow("SELECT `bonus_sn` FROM `$thistable` WHERE `bonus_type_id` = $type_id AND `used_time` = 0 ");
                if (!empty($ret['bonus_sn'])) {
                    $user_bonus = $db->getAll("SELECT `bonus_sn` FROM  `$thistable` WHERE `bonus_type_id` = $type_id");
                    $wx_bonus = $db->getAll("SELECT `coupon` FROM `$weixinusertable`");
                    foreach ($wx_bonus as $k => $v) {
                        foreach ($user_bonus as $kk => $vv) {
                            if ($v['coupon'] == $vv['bonus_sn']) {
                                unset($user_bonus[$kk]);
                            }
                        }
                    }
                    $bonus_rand = array_rand($user_bonus);
                    $coupon = $user_bonus[$bonus_rand]['bonus_sn'];
                    $contentStr = "\r\n关注送". $type_money . "元红包:" . $coupon . "\r\n过期时间:$use_end_date";
                    $db->query("UPDATE `$weixinusertable` SET `coupon` = '$coupon' WHERE `wxid` ='$fromUsername';");
                } else {
                    $contentStr = "\r\n本次活动红包已送完!";
                }
            }
        }
        return $contentStr;
    }
    protected function plusPoint($db, $uname, $keyword, $fromUsername) {
		$weixinpointrecordtable = $db -> prefix . 'weixin_point_record';
		$weixinpointtable = $db -> prefix . 'weixin_point';
        $res_arr = array();
        $sql = "SELECT * FROM `$weixinpointrecordtable` WHERE `point_name` = '$keyword' AND `wxid` = '$fromUsername'";
        $record = $db->getRow($sql);
        $num = $db->getOne("SELECT `point_num` FROM `$weixinpointtable` WHERE `point_name` = 'qiandao'");
        $lasttime = time();
        if (empty($record)) {
            $dateline = time();
            $insert_sql = "INSERT INTO `$weixinpointrecordtable` (`wxid`, `point_name`, `num`, `lasttime`, `datelinie`) VALUES
('$fromUsername', '$keyword' , 1, $lasttime, $dateline);";
            $potin_name = $db->getOne("SELECT `point_name` FROM `$weixinpointtable` WHERE `point_name` = '$keyword'");
            if (!empty($potin_name)) {
                $db->query($insert_sql);
            }
        } else {
            $time = time();
            $lasttime_sql = "SELECT `lasttime` FROM `$weixinpointrecordtable` WHERE `point_name` = '$keyword' AND `wxid` = '$fromUsername'";
            $db_lasttime = $db->getOne($lasttime_sql);
            if (($time - $db_lasttime) > (60 * 60 * 24)) {
                $update_sql = "UPDATE `$weixinpointrecordtable` SET `num` = 0,`lasttime` = '$lasttime' WHERE `wxid` ='$fromUsername';";
                $db->query($update_sql);
            }
            $record_num = $db->getOne("SELECT `num` FROM `$weixinpointrecordtable` WHERE `point_name` = '$keyword' AND `wxid` = '$fromUsername'");
            if ($record_num < 1) {
                $update_sql = "UPDATE `$weixinpointrecordtable` SET `num` = `num`+1,`lasttime` = '$lasttime' WHERE `point_name` = '$keyword' AND `wxid` ='$fromUsername';";
                $db->query($update_sql);
            } else {
                $res_arr['errmsg'] = 'no';
                $res_arr['contentStr'] = '今天签到过啦，明天继续哦！';
                return $res_arr;
            }
        }
        $weixin_point =  $db->prefix . 'weixin_point';
        $wxch_points = $db->getAll("SELECT * FROM  `$weixin_point`");
        foreach ($wxch_points as $k => $v) {
            if ($v['point_name'] == $keyword) {
                if ($v['autoload'] == 'yes') {
                    $points = $v['point_value'];
                    $thistable = $db->prefix . 'users';
                    $sql = "UPDATE `$thistable` SET `pay_points` = `pay_points`+$points WHERE `user_name` ='$uname'";
                    $db->query($sql);
                }
            }
        }
        $res_arr['errmsg'] = 'ok';
        $res_arr['contentStr'] = '签到成功,积分+';
        return $res_arr;
    }
    public function kuaidi($invoice_no, $shipping_name) {
        switch ($shipping_name) {
            case '中国邮政':
                $logi_type = 'ems';
                break;

            case '申通快递':
                $logi_type = 'shentong';
                break;

            case '圆通速递':
                $logi_type = 'yuantong';
                break;

            case '顺丰速运':
                $logi_type = 'shunfeng';
                break;

            case '韵达快递':
                $logi_type = 'yunda';
                break;

            case '天天快递':
                $logi_type = 'tiantian';
                break;

            case '中通速递':
                $logi_type = 'zhongtong';
                break;

            case '增益速递':
                $logi_type = 'zengyisudi';
                break;
        }
        $kurl = 'http://www.kuaidi100.com/query?type=' . $logi_type . '&postid=' . $invoice_no;
        $ret = $this->curl_get_contents($kurl);
        $k_arr = json_decode($ret, true);
        return $k_arr;
    }
    public function curl_get_contents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
        curl_setopt($ch, CURLOPT_REFERER, _REFERER_);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    public function curl_grab_page($url, $data, $proxy = '', $proxystatus = '', $ref_url = ''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if ($proxystatus == 'true'){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($ref_url)){
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_REFERER, $ref_url);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        ob_start();
        return curl_exec ($ch);
        ob_end_clean();
        curl_close ($ch);
        unset($ch);
    }
    private function checkSignature($db,$ecdb){
        $thistable = $ecdb -> prefix . 'weixin_config';
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $ret = $db -> getRow("SELECT * FROM ".$thistable." WHERE `id` = 1");
        $token = $ret['token'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }
}
?>