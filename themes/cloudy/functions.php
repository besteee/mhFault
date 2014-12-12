<?php
if(!defined("IN_ECS")){die("<a href=\"http://shopiy.com/\">Shopiy.com</a>");}
require_once('includes/language.php');
/**
 * 调用浏览历史
 */
function insert_siy_history()
{
	$str = '';
	if (!empty($_COOKIE['ECS']['history']))
	{
		$where = db_create_in($_COOKIE['ECS']['history'], 'goods_id');
		$sql   = 'SELECT goods_id, goods_name, goods_thumb, shop_price FROM ' . $GLOBALS['ecs']->table('goods') .
				" WHERE $where AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0";
		$query = $GLOBALS['db']->query($sql);
		$res = array();
		$str .= '<div id="history" class="box">
	<b class="tp"><b></b></b>
	<div class="hd"><h3>' . $GLOBALS['_LANG']['view_history'] . '</h3><span class="more" onclick="clear_history()">' . $GLOBALS['_LANG']['clear_history'] . '</span></div>
	<div class="bd">
		<ul class="goods-list">';
			while ($row = $GLOBALS['db']->fetch_array($query))
			{
				$goods['goods_id'] = $row['goods_id'];
				$goods['goods_name'] = $row['goods_name'];
				$goods['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
				$goods['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
				$goods['shop_price'] = price_format($row['shop_price']);
				$goods['url'] = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
				$str.='		<li>
				<span class="photo">
					<a href="'.$goods['url'].'" title="'.$goods['goods_name'].'" class="image"><img src="'.$goods['goods_thumb'].'" alt="'.$goods['goods_name'].'"/></a>
				</span>
				<span class="info">
					<a href="'.$goods['url'].'" title="'.$goods['goods_name'].'" class="name">'.$goods['short_name'].'</a>
					<em class="price">'.$goods['shop_price'].'</em>
				</span>
				<span class="action">
					<a href="'.$goods['url'].'" class="detail">'.$GLOBALS['_LANG']['btn_detail'].'</a>
				</span>
			</li>';
			}
			$str .= '	</ul>
	</div>
	<b class="bt"><b></b></b>
</div>';
	}
	return $str;
}

function insert_siy_index_ad()
{
	$str = '';
	$flashdb = array();
	if (file_exists(ROOT_PATH . DATA_DIR . '/flash_data.xml'))
	{
		if (!preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"\ssort="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER))
		{
			preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER);
		}
		if (!empty($t))
		{
			foreach ($t as $key => $val)
			{
				$val[4] = isset($val[4]) ? $val[4] : 0;
				$flashdb[] = array('src'=>$val[1],'url'=>$val[2],'text'=>$val[3],'sort'=>$val[4]);
			}
			$str .= '<div id="slide"><ul id="slide-item">';
			foreach ($flashdb as $key => $val)
			{
				if (strpos($val['src'], 'http') === false)
				{
					$flashdb[$key]['src'] = $uri . $val['src'];
				}
				if ($val['sort'] != -1)
				{
					$str.='<li><a href="'.$flashdb[$key]['url'].'" rel="external"><img src="'.$flashdb[$key]['src'].'" alt="'.$flashdb[$key]['text'].'" /></a></li>';
				}
			}
			$str .= '</ul></div>';
		}
	}
	return $str;
}

?>