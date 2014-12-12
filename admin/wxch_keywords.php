<?php 
  define('IN_ECS', true);
  require(dirname(__FILE__) . '/includes/init.php'); 
  include_once(ROOT_PATH . '/includes/cls_image.php'); 
  $_REQUEST['act'] = trim($_REQUEST['act']); 
  $weixinkeywordstable = $GLOBALS['ecs']->table('weixin_keywords');
  $exc = new exchange($weixinkeywordstable, $db, 'id', 'keyword');

  if($_REQUEST['act'] == 'list') { 
	  $smarty->display('wxch_keywords.html'); 
  } 
  
  elseif($_REQUEST['act'] == 'add') { 
	  if($_POST){
		  $image = new cls_image($_CFG['bgcolor']); 
		  $path = $image->upload_image($_FILES['path']); 
		  $name = $_POST['name']; 
		  $keyword = $_POST['keyword']; 
		  $type = $_POST['type']; 
		  $contents = $_POST['contents']; 
		  $pic_tit = $_POST['pic_tit']; 
		  $desc = $_POST['desc']; 
		  $pic_url = $_POST['pic_url']; 

		  /*检查关键词是否重复*/
		  $is_only = $exc->is_only('keyword', $keyword);
		  if (!$is_only)
		  {
			 sys_msg(sprintf($keyword." 关键词已经存在！", stripslashes($keyword)), 1);
		  }
		  if ($keyword == 'new' or $keyword == 'best' or $keyword == 'hot' or $keyword == 'promote' or $keyword == 'cxbd' or $keyword == 'quit' or $keyword == 'member')
		 {
			 sys_msg(sprintf($keyword." 系统保留关键词，不能占用！", stripslashes($keyword)), 1);
		 }


		  if($type == 1){
			  $contents = $contents; 
			  $db->query("INSERT INTO ".$weixinkeywordstable." (`name`, `keyword`, `type`, `contents`, `count`, `status`) VALUES ('$name', '$keyword', $type, '$contents', 0, 1);"); 
		  }elseif($type == 2){
			  $img_name = basename($image->upload_image($_FILES['pic'],'weixin'));
			  $db->query("INSERT INTO ".$weixinkeywordstable." (`name`, `keyword`, `type`, `pic`, `pic_tit`, `desc`, `pic_url`, `count`, `status`) VALUES ('$name', '$keyword', $type, '$img_name', '$pic_tit', '$desc', '$pic_url', 0, 1);"); 
		  }
		  $link[] = array('href' =>'wxch.php?act=keywords', 'text' => '关键词自动回复');
		  sys_msg('添加成功',0,$link); 
	  }else{
		  require(ROOT_PATH . 'includes/fckeditor/fckeditor.php');
		  $lang = array();
		  $lang['tab_general'] = '文字信息';
		  $lang['tab_images'] = '图文信息';
		  $editor = new FCKeditor('contents');
		  $editor->BasePath = '../includes/fckeditor/'; 
		  $editor->ToolbarSet = 'Normal';
		  $editor->Width = '60%';
		  $editor->Height = '320';
		  $editor->Value = $content['template_content'];
		  $FCKeditor = $editor->CreateHtml(); 
		  $smarty->assign('FCKeditor', $FCKeditor);
		  $smarty->assign('lang',$lang);
		  $smarty->display('wxch_keywords_info_add.html'); 
	} 
} 
 
 elseif($_REQUEST['act'] == 'edit') {
	 if($_POST){
		 $image = new cls_image($_CFG['bgcolor']); 
		 $id = $_POST['id']; 
		 $name = $_POST['name']; 
		 $keyword = $_POST['keyword']; 
		 $type = $_POST['type']; 
		 $contents = $_POST['contents']; 
	     $pic_tit = $_POST['pic_tit']; 
	     $desc = $_POST['desc']; 
	     $pic_url = $_POST['pic_url']; 

		  /*检查关键词是否重复*/
		  if ($keyword == 'new' or $keyword == 'best' or $keyword == 'hot' or $keyword == 'promote' or $keyword == 'cxbd' or $keyword == 'quit' or $keyword == 'member')
		 {
			 sys_msg(sprintf($keyword." 系统保留关键词，不能占用！", stripslashes($keyword)), 1);
		 }

		 if($type == 1){ 
		 $update_sql = "UPDATE  ".$weixinkeywordstable." SET  `name` =  '$name',`keyword` =  '$keyword',`type` =  '$type',`contents` =  '$contents' WHERE  `id` ='$id';"; 
		 }elseif($type == 2){
		 $img_name = basename($image->upload_image($_FILES['pic'],'weixin'));
		 $update_sql = "UPDATE  ".$weixinkeywordstable." SET  `name` =  '$name',`keyword` =  '$keyword',`type` =  '$type',`pic` =  '$img_name',`pic_tit` =  '$pic_tit',`desc` =  '$desc',`pic_url` =  '$pic_url' WHERE  `id` ='$id';";
		 }
		 $db->query($update_sql); 
		 $link[] = array('href' =>'wxch.php?act=keywords', 'text' => '关键词自动回复'); 
		 sys_msg('修改成功',0,$link); 
	} 
	require(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); 
	$id = $_GET['id']; 
	$data = $db->getRow("SELECT * FROM ".$weixinkeywordstable." WHERE `id` = $id");
	$lang = array(); 
	$lang['tab_general'] = '主要信息'; 
	$editor = new FCKeditor('contents'); 
	$editor->BasePath = '../includes/fckeditor/'; 
	$editor->ToolbarSet = 'Normal'; 
	$editor->Width = '60%'; 
	$editor->Height = '320'; 
	$editor->Value = $data['contents']; 
	$FCKeditor = $editor->CreateHtml(); 
	$smarty->assign('data', $data); 
	$smarty->assign('FCKeditor', $FCKeditor); 
	$smarty->assign('lang',$lang); 
	$smarty->assign('data',$data); 
	$smarty->assign('article_list',$article_list); 
	if($_GET['type'] == 'text'){ 
		$smarty->display('wxch_keywords_infotext.html'); 
	}elseif($_GET['type'] == 'image'){ 
		$smarty->display('wxch_keywords_infoimage.html'); 
	} 
} 
 
 elseif($_REQUEST['act'] == 'remove') {
	 $id = $_GET['id']; 
	 $filter['page'] = $_GET['page']; 
	 $filter['page_size'] = $_GET['page_size']; 
	 if(empty($filter['page_size'])){ 
		 $filter['page_size'] = 15; 
	 } 
	 $filter['page_count'] = $_GET['page_count']; 
	 $filter['record_count'] = $_GET['record_count']; 
	 if($filter['page'] <=1){ 
		 $start = 0; 
	 }else{ 
		 $start = ($filter['page']-1) * $filter['page_size']; 
	 } 
	 $filter['start'] = $start;
	 $ret = $db->getAll("SELECT * FROM ".$weixinkeywordstable." LIMIT $start , $filter[page_size]"); 
	 $wxchdata = array(); 
	 foreach($ret as $k=>$v){ 
		 if($v['type'] == 1){ 
			 $v['type'] = '文字'; 
			 }elseif(
			 $v['type'] == 2){
			 $v['type'] = '图文'; 
			} 
			$wxchdata[$k] = $v; 
	} 
	$smarty->assign('wxchdata',$wxchdata);
	$smarty->assign('filter',$filter);
	make_json_result($smarty->fetch('wxch_keywords.html'), '',array('filter' => $filter, 'page_count' => $filter['page_count'])); 
} 

elseif($_REQUEST['act'] == 'edit_title') {
	$title = json_str_iconv(trim($_POST['val']));
	make_json_result(stripslashes($title)); 
} 

elseif ($_REQUEST['act'] == 'get_article_list') {
	include_once(ROOT_PATH . 'includes/cls_json.php');
	$json = new JSON; 
	$filters =(array) $json->decode(json_str_iconv($_GET['JSON']));
	$where = " WHERE cat_id > 0 "; 
	if (!empty($filters['title'])) {
		$keyword = trim($filters['title']); 
		$where .= " AND title LIKE '%" . mysql_like_quote($keyword) . "%' "; 
		}
	$sql = 'SELECT article_id, title FROM ' .$ecs->table('article'). $where. 'ORDER BY article_id DESC LIMIT 50';
	$res = $db->query($sql);
	$arr = array(); 
	while ($row = $db->fetchRow($res)) { $arr[] = array('value' => $row['article_id'], 'text' => $row['title'], 'data'=>''); }
	make_json_result($arr); 
} 

elseif ($_REQUEST['act'] == 'add_article') { 
	include_once(ROOT_PATH . 'includes/cls_json.php');
	$json = new JSON; 
	$articles = $json->decode($_GET['add_ids']);
	$arguments = $json->decode($_GET['JSON']); 
	if(!empty($arguments[0])){ 
		$kws_id = $arguments[0]; 
	}else{ 
		$insert_sql = "INSERT INTO ".$weixinkeywordstable." (`name`) VALUES ('');"; 
		$db->query($insert_sql); 
		$kws_id = $db->insert_id();
		session_start(); 
		$_SESSION['kws_id'] = $kws_id; 
	} 
	foreach ($articles AS $val) { 
		$sql = "INSERT INTO wxch_keywords_article (kws_id, article_id) " . "VALUES ('$kws_id', '$val')";
		$db->query($sql); 
	}
	$arr = get_keywords_articles($kws_id,$db); 
	$opt = array(); 
	foreach ($arr AS $val) {
		$opt[] = array('value' => $val['article_id'], 'text' => $val['title'], 'data' => ''); 
	} 
	clear_cache_files();
	make_json_result($opt); 
} 

elseif ($_REQUEST['act'] == 'drop_article') { 
	include_once(ROOT_PATH . 'includes/cls_json.php'); 
	$json = new JSON; 
	$articles = $json->decode($_GET['drop_ids']);
	$arguments = $json->decode($_GET['JSON']); 
	foreach ($articles AS $val) { 
		$sql = "DELETE FROM `wxch_keywords_article` WHERE `wxch_keywords_article`.`article_id` = $val;"; 
		$db->query($sql); 
	} 
	$arr = get_keywords_articles($arguments[0],$db);
	$opt = array(); 
	if(is_array($arr)){ 
		foreach ($arr AS $val) { 
			$opt[] = array('value' => $val['article_id'], 'text' => $val['title'], 'data' => '');
		} 
	}
	clear_cache_files();
	make_json_result($opt); 
} 

elseif($_REQUEST['act'] == 'query') {
	if(!empty($_POST['keyword'])){
		$keyword = $_POST['keyword']; 
		$filter['page'] = $_POST['page'];
		$filter['page_size'] = $_POST['page_size']; 
		if(empty($filter['page_size'])){
			$filter['page_size'] = 15; 
		} 
		$filter['page_count'] = ceil($_POST['page_count']/$filter['page_size']);
		$filter['record_count'] = $_POST['record_count']; 
		if($filter['page'] <=1){ $start = 0; }else{ $start = ($filter['page']-1) * $filter['page_size']; }
		$filter['start'] = $start; 
		$ret = $db->getAll("SELECT * FROM ".$weixinkeywordstable." WHERE `name` LIKE '%$keyword%' LIMIT $start , $filter[page_size]");
		$wxchdata = array(); 
		foreach($ret as $k=>$v){ 
			if($v['type'] == 1){
				$v['type'] = '文字'; 
			}elseif($v['type'] == 2){
				$v['type'] = '图文'; 
			} 
		$wxchdata[$k] = $v; 
		} 
		$smarty->assign('wxchdata',$wxchdata);
		$smarty->assign('filter',$filter); 
		make_json_result($smarty->fetch('wxch_keywords.html'), '',array('filter' => $filter, 'page_count' => $filter['page_count'])); 
	} 
} 

function htmltowei($contents) {
	$contents = strip_tags($contents,'<br>'); 
	$contents = str_replace('<br />',"\r\n",$contents);
	$contents = str_replace('&quot;','"',$contents);
	$contents = str_replace('&nbsp;','',$contents);
	return $contents;
} 

function get_keywords_articles($kws_id,$db) {
	$sql = "SELECT `article_id` FROM `wxch_keywords_article` WHERE `kws_id` = '$kws_id'"; 
	$ret = $db->getAll($sql);
	foreach($ret as $v){ 
		$articles .= $v['article_id'].',';
	} 
	$length = strlen($articles)-1; 
	$articles = substr($articles, 0, $length);
	if(!empty($articles)){
		$sql2 = "SELECT `article_id`,`title` FROM ".$GLOBALS['ecs']->table('article')." WHERE `article_id` IN ($articles)";
		$res = $db->getAll($sql2); 
	} 
	return $res; 
} 
?>