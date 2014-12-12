<?php

/**
 * ECSHOP 商品分类
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: category.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

/*========================besteee&maluda=====================================*/
/* 车型表查询 */
switch ($_POST['action']){
	case 'addDiy':
		addDiy();
	break;
	case 'subCarType':
		subCarType();
	break;
}

function addDiy(){
	if($_SESSION['user_id']!==0){
		$name=$_POST['name'];
		$tel=$_POST['tel'];
		$text=$_POST['text'];
		$need=$_POST['need'];
		$carType=$_POST['carType'];
		$fault_name=$_POST['fault_name'];
		$user_id=$_SESSION['user_id'];
		$add_time=time();
		$sql="INSERT INTO".$GLOBALS['ecs']->table('fault_diy')."(name,tel,text,cartype,need,user_id,fault_name,add_time)value('$name','$tel','$text','$carType','$need','$user_id','$fault_name','$add_time')";
		$result=$GLOBALS['db']->query($sql);
		if($result){
			echo '您的需求已提交，工作人员将马上与您联系！';
		}
	}
	else{
		echo '需要登陆后才可提交自定义套餐，请注册或登陆！';
	}
}
function subCarType(){
	$brand=$_POST['brand'];
	$sql = "SELECT * FROM " .$GLOBALS['ecs']->table('cartypes'). " WHERE name = '$brand'";
	$row=$GLOBALS['db']->getRow($sql);
	$id=$row['id'];
	$sql2="SELECT * FROM".$GLOBALS['ecs']->table('cartypes')."WHERE cid = '$id'";
	$row2=$GLOBALS['db']->getAll($sql2);
	$result='<select class="subYourCarS" > <option value="">请选择</option>';
	foreach($row2 as $key=> $cartype){
		$result.='<option value="'.$cartype['name'].'">'.$cartype['name'].'</option>';
	}
	$result.='</select>';
	echo $result;
	exit;
}
/* 车型表查询end */
/*========================besteee&maluda end=====================================*/
/* 获得请求的分类 ID */
if (isset($_REQUEST['id']))
{
    $cat_id = intval($_REQUEST['id']);
}
elseif (isset($_REQUEST['category']))
{
    $cat_id = intval($_REQUEST['category']);
}
else
{
    /* 如果分类ID为0，则返回首页 */
    ecs_header("Location: ./\n");

    exit;
}


/* 初始化分页信息 */
$page = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
$size = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
$brand = isset($_REQUEST['brand']) && intval($_REQUEST['brand']) > 0 ? intval($_REQUEST['brand']) : 0;
$price_max = isset($_REQUEST['price_max']) && intval($_REQUEST['price_max']) > 0 ? intval($_REQUEST['price_max']) : 0;
$price_min = isset($_REQUEST['price_min']) && intval($_REQUEST['price_min']) > 0 ? intval($_REQUEST['price_min']) : 0;
$filter_attr_str = isset($_REQUEST['filter_attr']) ? htmlspecialchars(trim($_REQUEST['filter_attr'])) : '0';

$filter_attr_str = trim(urldecode($filter_attr_str));
$filter_attr_str = preg_match('/^[\d\.]+$/',$filter_attr_str) ? $filter_attr_str : '';
$filter_attr = empty($filter_attr_str) ? '' : explode('.', $filter_attr_str);


/* 排序、显示方式以及类型 */
$default_display_type = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
$default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
$default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'shop_price' : 'last_update');

$sort  = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'shop_price', 'last_update', 'click_count'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
$order = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC')))                              ? trim($_REQUEST['order']) : $default_sort_order_method;
$display  = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
$display  = in_array($display, array('list', 'grid', 'text')) ? $display : 'text';
setcookie('ECS[display]', $display, gmtime() + 86400 * 7);
/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/* 页面的缓存ID */
$cache_id = sprintf('%X', crc32($cat_id . '-' . $display . '-' . $sort  .'-' . $order  .'-' . $page . '-' . $size . '-' . $_SESSION['user_rank'] . '-' .
    $_CFG['lang'] .'-'. $brand. '-' . $price_max . '-' .$price_min . '-' . $filter_attr_str));


$topCatId=end(get_parent_cats($cat_id));					//获取商品顶级分类,根据顶级分类选用不同模板
$topCatId=$topCatId['cat_id'];
switch($topCatId){
	case 151:
		$dwt='categoryMhFault.dwt';
		$channel='channelMhFault.dwt';
	break;
	case 175:
		$dwt='mhFaultDiy.dwt';
		$channel='channelMhFault.dwt';
	break;
	case 177:
		$arr=array();
		$sql="SELECT * FROM".$GLOBALS['ecs']->table('fault_site');
		$result=$GLOBALS['db']->getAll($sql);
		foreach($result as $key=>$row){
			$arr[$key]['site_id']=$row['site_id'];
			$arr[$key]['name']=$row['name'];
			$arr[$key]['geo']=$row['geo'];
			$arr[$key]['tel']=$row['tel'];
			$arr[$key]['province']=$row['province'];
			$arr[$key]['city']=$row['city'];
			$arr[$key]['address']=$row['address'];
		}
		$smarty->assign('fault_site',$arr);
		$dwt='mhFaultSite.dwt';
		$channel='MhFaultSite.dwt';
	break;
	default:
		$channel='channel.dwt';
		$dwt='category.dwt';
}													//获取商品顶级分类end
if (!$smarty->is_cached($dwt, $cache_id))
{
    /* 如果页面没有被缓存则重新获取页面的内容 */

    $children = get_children($cat_id);

    $cat = get_cat_info($cat_id);   // 获得分类的相关信息

    if (!empty($cat))
    {
        $smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
        $smarty->assign('description', htmlspecialchars($cat['cat_desc']));
        $smarty->assign('cat_style',   htmlspecialchars($cat['style']));
		$smarty->assign('cat_name',   htmlspecialchars($cat['cat_name']));
		$smarty->assign('cat_parent_id', $cat['parent_id']); //是否顶级分类
		$smarty->assign('is_wshow', $cat['is_wshow']);
    }
    else
    {
        /* 如果分类不存在则返回首页 */
        ecs_header("Location: ./\n");

        exit;
    }

    /* 赋值固定内容 */
    if ($brand > 0)
    {
        $sql = "SELECT brand_name FROM " .$GLOBALS['ecs']->table('brand'). " WHERE brand_id = '$brand'";
        $brand_name = $db->getOne($sql);
    }
    else
    {
        $brand_name = '';
    }

    /* 获取价格分级 */
    if ($cat['grade'] == 0  && $cat['parent_id'] != 0)
    {
        $cat['grade'] = get_parent_grade($cat_id); //如果当前分类级别为空，取最近的上级分类
    }

    if ($cat['grade'] > 1)
    {
        /* 需要价格分级 */

        /*
            算法思路：
                1、当分级大于1时，进行价格分级
                2、取出该类下商品价格的最大值、最小值
                3、根据商品价格的最大值来计算商品价格的分级数量级：
                        价格范围(不含最大值)    分级数量级
                        0-0.1                   0.001
                        0.1-1                   0.01
                        1-10                    0.1
                        10-100                  1
                        100-1000                10
                        1000-10000              100
                4、计算价格跨度：
                        取整((最大值-最小值) / (价格分级数) / 数量级) * 数量级
                5、根据价格跨度计算价格范围区间
                6、查询数据库

            可能存在问题：
                1、
                由于价格跨度是由最大值、最小值计算出来的
                然后再通过价格跨度来确定显示时的价格范围区间
                所以可能会存在价格分级数量不正确的问题
                该问题没有证明
                2、
                当价格=最大值时，分级会多出来，已被证明存在
        */

        $sql = "SELECT min(g.shop_price) AS min, max(g.shop_price) as max ".
               " FROM " . $ecs->table('goods'). " AS g ".
               " WHERE ($children OR " . get_extension_goods($children) . ') AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1  ';
               //获得当前分类下商品价格的最大值、最小值

        $row = $db->getRow($sql);

        // 取得价格分级最小单位级数，比如，千元商品最小以100为级数
        $price_grade = 0.0001;
        for($i=-2; $i<= log10($row['max']); $i++)
        {
            $price_grade *= 10;
        }

        //跨度
        $dx = ceil(($row['max'] - $row['min']) / ($cat['grade']) / $price_grade) * $price_grade;
        if($dx == 0)
        {
            $dx = $price_grade;
        }

        for($i = 1; $row['min'] > $dx * $i; $i ++);

        for($j = 1; $row['min'] > $dx * ($i-1) + $price_grade * $j; $j++);
        $row['min'] = $dx * ($i-1) + $price_grade * ($j - 1);

        for(; $row['max'] >= $dx * $i; $i ++);
        $row['max'] = $dx * ($i) + $price_grade * ($j - 1);

        $sql = "SELECT (FLOOR((g.shop_price - $row[min]) / $dx)) AS sn, COUNT(*) AS goods_num  ".
               " FROM " . $ecs->table('goods') . " AS g ".
               " WHERE ($children OR " . get_extension_goods($children) . ') AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 '.
               " GROUP BY sn ";

        $price_grade = $db->getAll($sql);

        foreach ($price_grade as $key=>$val)
        {
            $temp_key = $key + 1;
            $price_grade[$temp_key]['goods_num'] = $val['goods_num'];
            $price_grade[$temp_key]['start'] = $row['min'] + round($dx * $val['sn']);
            $price_grade[$temp_key]['end'] = $row['min'] + round($dx * ($val['sn'] + 1));
            $price_grade[$temp_key]['price_range'] = $price_grade[$temp_key]['start'] . '&nbsp;-&nbsp;' . $price_grade[$temp_key]['end'];
            $price_grade[$temp_key]['formated_start'] = price_format($price_grade[$temp_key]['start']);
            $price_grade[$temp_key]['formated_end'] = price_format($price_grade[$temp_key]['end']);
            $price_grade[$temp_key]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_grade[$temp_key]['start'], 'price_max'=> $price_grade[$temp_key]['end'], 'filter_attr'=>$filter_attr_str), $cat['cat_name']);

            /* 判断价格区间是否被选中 */
            if (isset($_REQUEST['price_min']) && $price_grade[$temp_key]['start'] == $price_min && $price_grade[$temp_key]['end'] == $price_max)
            {
                $price_grade[$temp_key]['selected'] = 1;
            }
            else
            {
                $price_grade[$temp_key]['selected'] = 0;
            }
        }

        $price_grade[0]['start'] = 0;
        $price_grade[0]['end'] = 0;
        $price_grade[0]['price_range'] = $_LANG['all_attribute'];
        $price_grade[0]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>0, 'price_max'=> 0, 'filter_attr'=>$filter_attr_str), $cat['cat_name']);
        $price_grade[0]['selected'] = empty($price_max) ? 1 : 0;

        $smarty->assign('price_grade',     $price_grade);

    }


    /* 品牌筛选 */

    $sql = "SELECT b.brand_id, b.brand_name, COUNT(*) AS goods_num ".
            "FROM " . $GLOBALS['ecs']->table('brand') . "AS b, ".
                $GLOBALS['ecs']->table('goods') . " AS g LEFT JOIN ". $GLOBALS['ecs']->table('goods_cat') . " AS gc ON g.goods_id = gc.goods_id " .
            "WHERE g.brand_id = b.brand_id AND ($children OR " . 'gc.cat_id ' . db_create_in(array_unique(array_merge(array($cat_id), array_keys(cat_list($cat_id, 0, false))))) . ") AND b.is_show = 1 " .
            " AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ".
            "GROUP BY b.brand_id HAVING goods_num > 0 ORDER BY b.sort_order, b.brand_id ASC";

    $brands = $GLOBALS['db']->getAll($sql);

    foreach ($brands AS $key => $val)
    {
        $temp_key = $key + 1;
        $brands[$temp_key]['brand_name'] = $val['brand_name'];
        $brands[$temp_key]['url'] = build_uri('category', array('cid' => $cat_id, 'bid' => $val['brand_id'], 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str), $cat['cat_name']);

        /* 判断品牌是否被选中 */
        if ($brand == $brands[$key]['brand_id'])
        {
            $brands[$temp_key]['selected'] = 1;
        }
        else
        {
            $brands[$temp_key]['selected'] = 0;
        }
    }

    $brands[0]['brand_name'] = $_LANG['all_attribute'];
    $brands[0]['url'] = build_uri('category', array('cid' => $cat_id, 'bid' => 0, 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str), $cat['cat_name']);
    $brands[0]['selected'] = empty($brand) ? 1 : 0;

    $smarty->assign('brands', $brands);


    /* 属性筛选 */
    $ext = ''; //商品查询条件扩展
    if ($cat['filter_attr'] > 0)
    {
        $cat_filter_attr = explode(',', $cat['filter_attr']);       //提取出此分类的筛选属性
        $all_attr_list = array();

        foreach ($cat_filter_attr AS $key => $value)
        {
            $sql = "SELECT a.attr_name FROM " . $ecs->table('attribute') . " AS a, " . $ecs->table('goods_attr') . " AS ga, " . $ecs->table('goods') . " AS g WHERE ($children OR " . get_extension_goods($children) . ") AND a.attr_id = ga.attr_id AND g.goods_id = ga.goods_id AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND a.attr_id='$value'";
            if($temp_name = $db->getOne($sql))
            {
                $all_attr_list[$key]['filter_attr_name'] = $temp_name;

                $sql = "SELECT a.attr_id, MIN(a.goods_attr_id ) AS goods_id, a.attr_value AS attr_value FROM " . $ecs->table('goods_attr') . " AS a, " . $ecs->table('goods') .
                       " AS g" .
                       " WHERE ($children OR " . get_extension_goods($children) . ') AND g.goods_id = a.goods_id AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 '.
                       " AND a.attr_id='$value' ".
                       " GROUP BY a.attr_value";

                $attr_list = $db->getAll($sql);

                $temp_arrt_url_arr = array();

                for ($i = 0; $i < count($cat_filter_attr); $i++)        //获取当前url中已选择属性的值，并保留在数组中
                {
                    $temp_arrt_url_arr[$i] = !empty($filter_attr[$i]) ? $filter_attr[$i] : 0;
                }

                $temp_arrt_url_arr[$key] = 0;                           //“全部”的信息生成
                $temp_arrt_url = implode('.', $temp_arrt_url_arr);
                $all_attr_list[$key]['attr_list'][0]['attr_value'] = $_LANG['all_attribute'];
                $all_attr_list[$key]['attr_list'][0]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url), $cat['cat_name']);
                $all_attr_list[$key]['attr_list'][0]['selected'] = empty($filter_attr[$key]) ? 1 : 0;

                foreach ($attr_list as $k => $v)
                {
                    $temp_key = $k + 1;
                    $temp_arrt_url_arr[$key] = $v['goods_id'];       //为url中代表当前筛选属性的位置变量赋值,并生成以‘.’分隔的筛选属性字符串
                    $temp_arrt_url = implode('.', $temp_arrt_url_arr);

                    $all_attr_list[$key]['attr_list'][$temp_key]['attr_value'] = $v['attr_value'];
                    $all_attr_list[$key]['attr_list'][$temp_key]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url), $cat['cat_name']);

                    if (!empty($filter_attr[$key]) AND $filter_attr[$key] == $v['goods_id'])
                    {
                        $all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 1;
                    }
                    else
                    {
                        $all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 0;
                    }
                }
            }

        }

        $smarty->assign('filter_attr_list',  $all_attr_list);
        /* 扩展商品查询条件 */
        if (!empty($filter_attr))
        {
            $ext_sql = "SELECT DISTINCT(b.goods_id) FROM " . $ecs->table('goods_attr') . " AS a, " . $ecs->table('goods_attr') . " AS b " .  "WHERE ";
            $ext_group_goods = array();

            foreach ($filter_attr AS $k => $v)                      // 查出符合所有筛选属性条件的商品id */
            {
                if (is_numeric($v) && $v !=0 &&isset($cat_filter_attr[$k]))
                {
                    $sql = $ext_sql . "b.attr_value = a.attr_value AND b.attr_id = " . $cat_filter_attr[$k] ." AND a.goods_attr_id = " . $v;
                    $ext_group_goods = $db->getColCached($sql);
                    $ext .= ' AND ' . db_create_in($ext_group_goods, 'g.goods_id');
                }
            }
        }
    }

    assign_template('c', array($cat_id));

    $position = assign_ur_here($cat_id, $brand_name);
    $smarty->assign('page_title',       $position['title']);    // 页面标题
    $smarty->assign('ur_here',          $position['ur_here']);  // 当前位置

    $smarty->assign('categories',       get_categories_tree($cat_id)); // 分类树
    $smarty->assign('helps',            get_shop_help());              // 网店帮助
    $smarty->assign('top_goods',        get_top10());                  // 销售排行
    $smarty->assign('show_marketprice', $_CFG['show_marketprice']);
    $smarty->assign('category',         $cat_id);
    $smarty->assign('brand_id',         $brand);
    $smarty->assign('price_max',        $price_max);
    $smarty->assign('price_min',        $price_min);
    $smarty->assign('filter_attr',      $filter_attr_str);
    $smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-c$cat_id.xml" : 'feed.php?cat=' . $cat_id); // RSS URL

    if ($brand > 0)
    {
        $arr['all'] = array('brand_id'  => 0,
                        'brand_name'    => $GLOBALS['_LANG']['all_goods'],
                        'brand_logo'    => '',
                        'goods_num'     => '',
                        'url'           => build_uri('category', array('cid'=>$cat_id), $cat['cat_name'])
                    );
    }
    else
    {
        $arr = array();
    }

    $brand_list = array_merge($arr, get_brands($cat_id, 'category'));

    $smarty->assign('data_dir',    DATA_DIR);
    $smarty->assign('brand_list',      $brand_list);
    $smarty->assign('promotion_info', get_promotion_info());


    /* 调查 */
    $vote = get_vote();
    if (!empty($vote))
    {
        $smarty->assign('vote_id',     $vote['id']);
        $smarty->assign('vote',        $vote['content']);
    }

    $smarty->assign('best_goods',      get_category_recommend_goods('best', $children, $brand, $price_min, $price_max, $ext));
    $smarty->assign('promotion_goods', get_category_recommend_goods('promote', $children, $brand, $price_min, $price_max, $ext));
    $smarty->assign('hot_goods',       get_category_recommend_goods('hot', $children, $brand, $price_min, $price_max, $ext));
	$smarty->assign('new_goods',       get_category_recommend_goods('new', $children, $brand, $price_min, $price_max, $ext));

    $count = get_cagtegory_goods_count($children, $brand, $price_min, $price_max, $ext);
    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }
    $goodslist = category_get_goods($children, $brand, $price_min, $price_max, $ext, $size, $page, $sort, $order);
    if($display == 'grid')
    {
        if(count($goodslist) % 2 != 0)
        {
            $goodslist[] = array();
        }
    }
    $smarty->assign('goods_list',       $goodslist);
    $smarty->assign('category',         $cat_id);
    $smarty->assign('script_name', 'category');

	/* 获得顶级分类 */
	$cat_arr = get_parent_cats($cat_id);
	foreach ($cat_arr AS $val)
	{
			$topcat_id=$val['cat_id'];
			$topcat_name=$val['cat_name'];
	}
	$smarty->assign('topcat_id', $topcat_id);
	$smarty->assign('topcat_name', $topcat_name);
	$smarty->assign('ecy_adpicr', get_ecy_classpic($cat_id,3));
	$smarty->assign('ecy_adflash', get_ecy_classpic($cat_id,2));
	$smarty->assign('ecy_adpicl', get_ecy_classpic($cat_id,4));
	$smarty->assign('ecy_adtext', get_ecy_classpic($cat_id,6));

    assign_pager('category',            $cat_id, $count, $size, $sort, $order, $page, '', $brand, $price_min, $price_max, $display, $filter_attr_str); // 分页
    assign_dynamic('category'); // 动态内容
}
if ($cat['is_wshow'] ==1 and $cat['parent_id'] == 0){
  $smarty->display($channel, $cache_id);
}
else{
  $smarty->display($dwt, $cache_id);
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 获得分类的信息
 *
 * @param   integer $cat_id
 *
 * @return  void
 */
function get_cat_info($cat_id)
{
    return $GLOBALS['db']->getRow('SELECT cat_name, keywords, cat_desc, style, grade, filter_attr, parent_id,is_wshow FROM ' . $GLOBALS['ecs']->table('category') .
        " WHERE cat_id = '$cat_id'");
}

/**
 * 获得分类下的商品
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function category_get_goods($children, $brand, $min, $max, $ext, $size, $page, $sort, $order)
{
    $display = $GLOBALS['display'];
    $where = "g.is_on_sale = 1 AND g.is_alone_sale = 1 AND ".
            "g.is_delete = 0 AND ($children OR " . get_extension_goods($children) . ')';

    if ($brand > 0)
    {
        $where .=  "AND g.brand_id=$brand ";
    }

    if ($min > 0)
    {
        $where .= " AND g.shop_price >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND g.shop_price <= $max ";
    }

    /* 获得商品列表 */
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price, g.goods_type, " .
                'g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb , g.goods_img ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . ' AS mp ' .
                "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " .
            "WHERE $where $ext ORDER BY $sort $order";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if ($row['promote_price'] > 0)
        {
            $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
        }
        else
        {
            $promote_price = 0;
        }

        /* 处理商品水印图片 */
        $watermark_img = '';

        if ($promote_price != 0)
        {
            $watermark_img = "watermark_promote_small";
        }
        elseif ($row['is_new'] != 0)
        {
            $watermark_img = "watermark_new_small";
        }
        elseif ($row['is_best'] != 0)
        {
            $watermark_img = "watermark_best_small";
        }
        elseif ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot_small';
        }

        if ($watermark_img != '')
        {
            $arr[$row['goods_id']]['watermark_img'] =  $watermark_img;
        }

        $arr[$row['goods_id']]['goods_id']         = $row['goods_id'];
        if($display == 'grid')
        {
            $arr[$row['goods_id']]['goods_name']       = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name']       = $row['goods_name'];
        }
        $arr[$row['goods_id']]['name']             = $row['goods_name'];
        $arr[$row['goods_id']]['goods_brief']      = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_style_name'] = add_style($row['goods_name'],$row['goods_name_style']);
        $arr[$row['goods_id']]['market_price']     = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']       = price_format($row['shop_price']);
        $arr[$row['goods_id']]['type']             = $row['goods_type'];
        $arr[$row['goods_id']]['promote_price']    = ($promote_price > 0) ? price_format($promote_price) : '';
        $arr[$row['goods_id']]['goods_thumb']      = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']        = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url']              = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
    }

    return $arr;
}

/**
 * 获得分类下的商品总数
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function get_cagtegory_goods_count($children, $brand = 0, $min = 0, $max = 0, $ext='')
{
    $where  = "g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND ($children OR " . get_extension_goods($children) . ')';

    if ($brand > 0)
    {
        $where .=  " AND g.brand_id = $brand ";
    }

    if ($min > 0)
    {
        $where .= " AND g.shop_price >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND g.shop_price <= $max ";
    }

    /* 返回商品总数 */
    return $GLOBALS['db']->getOne('SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('goods') . " AS g WHERE $where $ext");
}

/**
 * 取得最近的上级分类的grade值
 *
 * @access  public
 * @param   int     $cat_id    //当前的cat_id
 *
 * @return int
 */
function get_parent_grade($cat_id)
{
    static $res = NULL;

    if ($res === NULL)
    {
        $data = read_static_cache('cat_parent_grade');
        if ($data === false)
        {
            $sql = "SELECT parent_id, cat_id, grade ".
                   " FROM " . $GLOBALS['ecs']->table('category');
            $res = $GLOBALS['db']->getAll($sql);
            write_static_cache('cat_parent_grade', $res);
        }
        else
        {
            $res = $data;
        }
    }

    if (!$res)
    {
        return 0;
    }

    $parent_arr = array();
    $grade_arr = array();

    foreach ($res as $val)
    {
        $parent_arr[$val['cat_id']] = $val['parent_id'];
        $grade_arr[$val['cat_id']] = $val['grade'];
    }

    while ($parent_arr[$cat_id] >0 && $grade_arr[$cat_id] == 0)
    {
        $cat_id = $parent_arr[$cat_id];
    }

    return $grade_arr[$cat_id];

}

/**
 * 获得指定商品分类图片
 */
function get_ecy_classpic($cat,$pclassid)
{
    $sql = "SELECT brand_name,brand_logo,site_url,sort_order,brand_desc FROM ".$GLOBALS['ecs']->table('ecyclass')." WHERE porduct_id=$cat and pclassid=$pclassid and is_show=1 ORDER BY sort_order ASC";

    $row = $GLOBALS['db']->getAll($sql);
    foreach ($row AS $key => $val)
    {
        $row[$key]['brand_name'] = $val['brand_name'];
		$row[$key]['site_url'] = $val['site_url'];
		$row[$key]['brand_logo'] = $val['brand_logo'];
    }
    return $row;

}

function get_child_treec($tree_id = 0)
{
    $three_arr = array();
    $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('category') . " WHERE parent_id = '$tree_id' AND is_show = 1 ";
    if ($GLOBALS['db']->getOne($sql) || $tree_id == 0)
    {
        $child_sql = 'SELECT cat_id, cat_name, parent_id, is_show,is_wshow ' .
                'FROM ' . $GLOBALS['ecs']->table('category') .
                "WHERE parent_id = '$tree_id' AND is_show = 1 AND is_wshow=1 ORDER BY sort_order ASC, cat_id ASC";
        $res = $GLOBALS['db']->getAll($child_sql);
        foreach ($res AS $row)
        {
            if ($row['is_show'])

               $three_arr[$row['cat_id']]['id']   = $row['cat_id'];
               $three_arr[$row['cat_id']]['name'] = $row['cat_name'];
               $three_arr[$row['cat_id']]['url']  = build_uri('category', array('cid' => $row['cat_id']), $row['cat_name']);

               if (isset($row['cat_id']) != NULL)
                   {
                       $three_arr[$row['cat_id']]['cat_id'] = get_child_tree($row['cat_id']);

            }
        }
    }
    return $three_arr;
}


/**
 * 获得指定分类下的商品
 *
 * @access  public
 * @param   integer     $cat_id     分类ID
 * @param   integer     $num        数量
 * @param   string      $from       来自web/wap的调用
 * @param   string      $order_rule 指定商品排序规则
 * @return  array
 */
function ecy_cat_goods($cat_id, $num = 0, $from = 'web', $order_rule = '')
{
    $children = get_children($cat_id);

    $sql = 'SELECT g.goods_id, g.goods_name, g.market_price,g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
               'g.promote_price, promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img ' .
            "FROM " . $GLOBALS['ecs']->table('goods') . ' AS g '.
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            'WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND '.
                'g.is_delete = 0 AND (' . $children . 'OR ' . get_extension_goods($children) . ') ';

    $order_rule = empty($order_rule) ? 'ORDER BY g.sort_order, g.goods_id DESC' : $order_rule;
    $sql .= $order_rule;
    if ($num > 0)
    {
        $sql .= ' LIMIT ' . $num;
    }
    $res = $GLOBALS['db']->getAll($sql);

    $goods = array();
    foreach ($res AS $idx => $row)
    {
        if ($row['promote_price'] > 0)
        {
            $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            $goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
        }
        else
        {
            $goods[$idx]['promote_price'] = '';
        }
		
		 $watermark_img = '';

        if ($promote_price != 0)
        {
            $watermark_img = "watermark_promote_small";
        }
        if ($row['is_new'] != 0)
        {
            $watermark_img1 = "watermark_new_small";
			$goods[$idx]['watermark_img1'] =  $watermark_img1;
        }
        if ($row['is_best'] != 0)
        {
            $watermark_img2 = "watermark_best_small";
			$goods[$idx]['watermark_img2'] =  $watermark_img2;
        }
        if ($row['is_hot'] != 0)
        {
            $watermark_img3 = 'watermark_hot_small';
			$goods[$idx]['watermark_img3'] =  $watermark_img3;
        }

        if ($watermark_img != '')
        {
            $goods[$idx]['watermark_img'] =  $watermark_img;
        }

        $goods[$idx]['id']           = $row['goods_id'];
        $goods[$idx]['name']         = $row['goods_name'];
        $goods[$idx]['brief']        = $row['goods_brief'];
        $goods[$idx]['market_price'] = price_format($row['market_price']);
        $goods[$idx]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                        sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $goods[$idx]['shop_price']   = price_format($row['shop_price']);
        $goods[$idx]['thumb']        = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $goods[$idx]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
        $goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
    }

	return $goods;

    /* 分类信息 */
    $sql = 'SELECT cat_name FROM ' . $GLOBALS['ecs']->table('category') . " WHERE cat_id = '$cat_id'";
    $cat['name'] = $GLOBALS['db']->getOne($sql);
    $cat['url']  = build_uri('category', array('cid' => $cat_id), $cat['name']);
    $cat['id']   = $cat_id;

    return $cat;
}

?>
