<?php

/**
 * ECSHOP 自定义数据调用函数包
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

if(!function_exists("index_comments")){

function index_comments($num)
{
   /*$sql = 'SELECT a.*,b.goods_id,b.goods_thumb,b.goods_name FROM '. $GLOBALS['ecs']->table('comment') .
            ' AS a,'. $GLOBALS['ecs']->table('goods') .'AS b WHERE a.status = 1 AND a.parent_id = 0 and a.comment_type=0 and a.id_value=b.goods_id'.
            ' GROUP BY a.id_value ORDER by a.comment_id DESC';*/
   $sql = 'SELECT DISTINCT a.id_value,b.goods_id,b.goods_thumb,b.goods_name,b.shop_price FROM '. $GLOBALS['ecs']->table('comment') .' AS a,'. $GLOBALS['ecs']->table('goods') .'AS b WHERE a.status = 1 AND a.parent_id = 0 and a.comment_type=0 and a.id_value=b.goods_id'.' ORDER by a.comment_id DESC';
			
  if ($num > 0)
  {
   $sql .= ' LIMIT ' . $num;
  }
  $res = $GLOBALS['db']->getAll($sql);
  $comments = array();
  foreach ($res AS $idx => $row)
  {
       $comments[$idx]['id_value']       = $row['id_value'];
	       
		   $sqli='SELECT add_time,content,user_name FROM '. $GLOBALS['ecs']->table('comment') .' where id_value='.$row['id_value'].' and status = 1 AND parent_id = 0 and comment_type=0 ORDER by add_time desc';
		   $resi = $GLOBALS['db']->getRow($sqli);
		   
		   $result = mysql_query($sqli);
		   $getall = $GLOBALS['db']->num_rows($result);

	       $comments[$idx]['number']    = $getall;//条数
		   $comments[$idx]['add_time']       = local_date('Y-m-d', $resi['add_time']);
		   $comments[$idx]['content']       = $resi['content'];
		   $comments[$idx]['user_name']       = $resi['user_name'];
	   
	   $comments[$idx]['goods_thumb']  = get_image_path($row['goods_id'], $row['goods_thumb'], true);
	   $comments[$idx]['goods_name']       = $row['goods_name'];
	   $comments[$idx]['shop_price']       = $row['shop_price'];
	   $comments[$idx]['url']              = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
  }
  return $comments;
}
}

function get_clild_list($pid)
{
   //开始获取子分类
    $sql_sub = "select * from ".$GLOBALS['ecs']->table('category')." where parent_id=".$pid." and is_show=1";

	$subres = $GLOBALS['db']->getAll($sql_sub);
	if($subres)
	{
		foreach ($subres as $sidx => $subrow)
		{
			$children[$sidx]['id']=$subrow['cat_id'];
			$children[$sidx]['name']=$subrow['cat_name'];
			$children[$sidx]['url']=build_uri('category', array('cid' => $subrow['cat_id']), $subrow['cat_name']);
		}
	}
	else 
	{
		$children = null;
	}
			
	return $children;
}

function get_flash_xml()
	{
		$flashdb = array();
		if (file_exists(ROOT_PATH . DATA_DIR . '/flash_data.xml'))
		{
	
			// 兼容v2.7.0及以前版本
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
			}
		}
		return $flashdb;
}

/**
 * 通过类型与传入的ID获取广告内容
 *
 * @param string $type
 * @param int $id
 * @return string
 */					
function get_adv($type,$id)
{
	 $sql = "select ap.ad_width,ap.ad_height,ad.ad_name,ad.ad_code,ad.ad_link from ".$GLOBALS['ecs']->table('ad_position')." as ap left join ".$GLOBALS['ecs']->table('ad')." as ad on ad.position_id = ap.position_id where ad.ad_name='".$type."_".$id."' and ad.media_type=0 and UNIX_TIMESTAMP()>ad.start_time and UNIX_TIMESTAMP()<ad.end_time and ad.enabled=1";
     $res = $GLOBALS['db']->getRow($sql);
     if($res)                        
     return  "<a href='".$res['ad_link']."' target='_blank'><img src='data/afficheimg/".$res['ad_code']."' width='".$res['ad_width']."' height='".$res['ad_height']."' /></a>";	
	 else
	 {
		return "";
	 }
}

function get_advimg($type,$id)
{
	 $sql = "select ap.ad_width,ap.ad_height,ad.ad_name,ad.ad_code,ad.ad_link from ".$GLOBALS['ecs']->table('ad_position')." as ap left join ".$GLOBALS['ecs']->table('ad')." as ad on ad.position_id = ap.position_id where ad.ad_name='".$type."_".$id."' and ad.media_type=0 and UNIX_TIMESTAMP()>ad.start_time and UNIX_TIMESTAMP()<ad.end_time and ad.enabled=1";
     $res = $GLOBALS['db']->getRow($sql);
     if($res)                        
     return  "data/afficheimg/".$res['ad_code']."";	
	 else
	 {
		return "";
	 }
}

function get_advurl($type,$id)
{
	 $sql = "select ap.ad_width,ap.ad_height,ad.ad_name,ad.ad_code,ad.ad_link from ".$GLOBALS['ecs']->table('ad_position')." as ap left join ".$GLOBALS['ecs']->table('ad')." as ad on ad.position_id = ap.position_id where ad.ad_name='".$type."_".$id."' and ad.media_type=0 and UNIX_TIMESTAMP()>ad.start_time and UNIX_TIMESTAMP()<ad.end_time and ad.enabled=1";
     $res = $GLOBALS['db']->getRow($sql);
     if($res)                        
     return  "".$res['ad_link']."";	
	 else
	 {
		return "";
	 }
}

function get_advtit($type,$id)
{
	 $sql = "select ap.ad_width,ap.ad_height,ad.ad_name,ad.ad_code,ad.ad_link,ad.link_man from ".$GLOBALS['ecs']->table('ad_position')." as ap left join ".$GLOBALS['ecs']->table('ad')." as ad on ad.position_id = ap.position_id where ad.ad_name='".$type."_".$id."' and ad.media_type=0 and UNIX_TIMESTAMP()>ad.start_time and UNIX_TIMESTAMP()<ad.end_time and ad.enabled=1";
     $res = $GLOBALS['db']->getRow($sql);
     if($res)                        
     return  "".$res['link_man']."";	
	 else
	 {
		return "";
	 }
}


function get_hot_cat_tree( $pid = 0, $rec = 3 )
{
		$arr = array( );
		$sql = "select c.*, rc.recommend_type from ".$GLOBALS['ecs']->table( "category" )." as c left join ".$GLOBALS['ecs']->table( "cat_recommend" ).( " as rc on c.cat_id = rc.cat_id where c.parent_id=".$pid." order by c.sort_order asc, c.cat_id asc" );
		$res = $GLOBALS['db']->getAll( $sql );
		foreach ( $res as $row )
		{
				if ( $row['recommend_type'] == $rec )
				{
						$arr[$row['cat_id']]['id'] = $row['cat_id'];
						$arr[$row['cat_id']]['name'] = $row['cat_name'];
						$arr[$row['cat_id']]['url'] = build_uri( "category", array(
								"cid" => $row['cat_id']
						), $row['cat_name'] );
				}
		}
		foreach ( $res as $row )
		{
				$arr2 = get_hot_cat_tree2( $row['cat_id'], $rec );
				if ( $arr2 )
				{
						$arr[$row['cat_id']]['child'] = $arr2;
				}
		}
		return $arr;
}
function get_hot_cat_tree2( $pid = 0, $rec = 3 )
{
		$arr = array( );
		$sql = "select c.*, rc.recommend_type from ".$GLOBALS['ecs']->table( "category" )." as c left join ".$GLOBALS['ecs']->table( "cat_recommend" ).( " as rc on c.cat_id = rc.cat_id where rc.recommend_type=".$rec." and c.parent_id={$pid} order by c.sort_order asc, c.cat_id asc" );
		$res = $GLOBALS['db']->getAll( $sql );
		foreach ( $res as $row )
		{
				$arr[$row['cat_id']]['id'] = $row['cat_id'];
				$arr[$row['cat_id']]['name'] = $row['cat_name'];
				$arr[$row['cat_id']]['url'] = build_uri( "category", array(
						"cid" => $row['cat_id']
				), $row['cat_name'] );
		}
		return $arr;
}
function get_cat_brands($cat, $app = 'brand')
{
    $children = ($cat > 0) ? ' AND ' . get_children($cat) : '';
    $sql = "SELECT b.brand_id, b.brand_name, b.brand_logo, COUNT(g.goods_id) AS goods_num, IF(b.brand_logo > '', '1', '0') AS tag ".
            "FROM " . $GLOBALS['ecs']->table('brand') . "AS b, ".
                $GLOBALS['ecs']->table('goods') . " AS g ".
            "WHERE g.brand_id = b.brand_id $children " .
            "GROUP BY b.brand_id HAVING goods_num > 0 ORDER BY tag DESC, b.sort_order ASC";

    $row = $GLOBALS['db']->getAll($sql);
    foreach ($row AS $key => $val)
    {
        $row[$key]['url'] = build_uri($app, array('cid' => $cat, 'bid' => $val['brand_id']), $val['brand_name']);
		$row[$key]['brand_name']=$val['brand_name'];
		$row[$key]['brand_logo']=$val['brand_logo'];
    }
    return $row;

}

function get_goods_min_max_price( $goods_id )
{
		$goods = get_goods_info_ex( $goods_id );
		if ( $goods['is_promote'] && $goods['gmt_end_time'] )
		{
				$price = $goods['promote_price'];
		}
		else
		{
				$price = $goods['shop_price'];
		}
		$price_arr = array(
				"min" => $price - 200,
				"max" => $price + 200
		);
		return $price_arr;
}
function get_art_cat_name( $cat_id )
{
		$row = $GLOBALS['db']->getRow( "SELECT cat_name FROM ".$GLOBALS['ecs']->table( "article_cat" ).( " WHERE cat_id = '".$cat_id."'" ) );
		return $row['cat_name'];
}

function get_goods_info_ex( $goods_id )
{
		$sql = "SELECT g.market_price, g.shop_price, g.promote_price, g.is_promote, g.promote_start_date, g.promote_end_date  FROM ".$GLOBALS['ecs']->table( "goods" )." AS g ".( "WHERE g.goods_id = '".$goods_id."' AND g.is_delete = 0 " );
		$row = $GLOBALS['db']->getRow( $sql );
		if ( $row !== FALSE )
		{
				if ( 0 < $row['promote_price'] )
				{
						$promote_price = bargain_price( $row['promote_price'], $row['promote_start_date'], $row['promote_end_date'] );
				}
				else
				{
						$promote_price = 0;
				}
				$row['promote_price'] = $promote_price;
				$time = gmtime( );
				if ( $row['promote_start_date'] <= $time && $time <= $row['promote_end_date'] )
				{
						$row['gmt_end_time'] = $row['promote_end_date'];
						return $row;
				}
				$row['gmt_end_time'] = 0;
		}
		return $row;
}

function get_cat_recommend_goods( $type = "", $cats = "", $cat_num = 0, $brand = 0, $min = 0, $max = 0, $ext = "" )
{
		$brand_where = 0 < $brand ? " AND g.brand_id = '".$brand."'" : "";
		$price_where = 0 < $min ? " AND g.shop_price >= ".$min." " : "";
		$price_where .= 0 < $max ? " AND g.shop_price <= ".$max." " : "";
		$sql = "SELECT g.goods_id, g.goods_name, g.goods_name_style,g.goods_sn,  g.market_price, g.shop_price AS org_price, g.promote_price, ".( "IFNULL(mp.user_price, g.shop_price * '".$_SESSION['discount']."') AS shop_price, " )."(select AVG(r.comment_rank) from ".$GLOBALS['ecs']->table( "comment" )." as r where r.id_value = g.goods_id AND r.comment_type = 0 AND r.parent_id = 0 AND r.status = 1) AS comment_rank, (select IFNULL(sum(og.goods_number), 0) from ".$GLOBALS['ecs']->table( "order_goods" )." as og where og.goods_id = g.goods_id) AS sell_number, promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, goods_img, b.brand_name, b.brand_id, g.is_best, g.is_new, g.is_hot, g.is_promote FROM ".$GLOBALS['ecs']->table( "goods" )." AS g LEFT JOIN ".$GLOBALS['ecs']->table( "brand" )." AS b ON b.brand_id = g.brand_id LEFT JOIN ".$GLOBALS['ecs']->table( "member_price" )." AS mp ".( "ON mp.goods_id = g.goods_id AND mp.user_rank = '".$_SESSION['user_rank']."' " )."WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ".$brand_where.$price_where.$ext;
		$num = 0;
		$type2lib = array( "best" => "recommend_best", "new" => "recommend_new", "hot" => "recommend_hot", "promote" => "recommend_promotion" );
		if ( $cat_num == 0 )
		{
				$num = get_library_number( $type2lib[$type] );
		}
		else
		{
				$num = $cat_num;
		}
		switch ( $type )
		{
		case "best" :
				$sql .= " AND is_best = 1";
				break;
		case "new" :
				$sql .= " AND is_new = 1";
				break;
		case "hot" :
				$sql .= " AND is_hot = 1";
				break;
		case "promote" :
				$time = gmtime( );
				$sql .= " AND is_promote = 1 AND promote_start_date <= '".$time."' AND promote_end_date >= '{$time}'";
		}
		if ( !empty( $cats ) )
		{
				$sql .= " AND (".$cats." OR ".get_extension_goods( $cats ).")";
		}
		$order_type = $GLOBALS['_CFG']['recommend_order'];
		$sql .= $order_type == 0 ? " ORDER BY g.sort_order, g.last_update DESC" : " ORDER BY RAND()";
		$res = $GLOBALS['db']->selectLimit( $sql, $num );
		$idx = 0;
		$goods = array( );
		while ( $row = $GLOBALS['db']->fetchRow( $res ) )
		{
				if ( 0 < $row['promote_price'] )
				{
						$promote_price = bargain_price( $row['promote_price'], $row['promote_start_date'], $row['promote_end_date'] );
						$goods[$idx]['promote_price'] = 0 < $promote_price ? price_format( $promote_price ) : "";
				}
				else
				{
						$goods[$idx]['promote_price'] = "";
				}
				$row['comment_rank'] = ceil( $row['comment_rank'] ) == 0 ? 5 : ceil( $row['comment_rank'] );
				$goods[$idx]['id'] = $row['goods_id'];
				$goods[$idx]['name'] = $row['goods_name'];
				$goods[$idx]['goods_sn'] = $row['goods_sn'];
				$goods[$idx]['comment_rank'] = $row['comment_rank'];
				$goods[$idx]['sell_number'] = $row['sell_number'];
				$goods[$idx]['is_new'] = $row['is_new'];
				$goods[$idx]['is_best'] = $row['is_best'];
				$goods[$idx]['is_hot'] = $row['is_hot'];
				$goods[$idx]['is_promote'] = $row['is_promote'];
				$goods[$idx]['brief'] = $row['goods_brief'];
				$goods[$idx]['brand_id'] = $row['brand_id'];
				$goods[$idx]['brand_name'] = $row['brand_name'];
				$goods[$idx]['short_name'] = 0 < $GLOBALS['_CFG']['goods_name_length'] ? sub_str( $row['goods_name'], $GLOBALS['_CFG']['goods_name_length'] ) : $row['goods_name'];
				$goods[$idx]['market_price'] = price_format( $row['market_price'] );
				$goods[$idx]['shop_price'] = price_format( $row['shop_price'] );
				$goods[$idx]['thumb'] = get_image_path( $row['goods_id'], $row['goods_thumb'], TRUE );
				$goods[$idx]['goods_img'] = get_image_path( $row['goods_id'], $row['goods_img'] );
				$goods[$idx]['url'] = build_uri( "goods", array(
						"gid" => $row['goods_id']
				), $row['goods_name'] );
				$goods[$idx]['short_style_name'] = add_style( $goods[$idx]['short_name'], $row['goods_name_style'] );
				++$idx;
		}
		return $goods;
}

?>