<?php
	
//13:44 2013-07-05

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');

$flow_type = 0;

if ($_SESSION['user_id'] > 0){
	$smarty->assign('user_name', $_SESSION['user_name']);
}

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

//删除单品
if ($act == 'drop_goods'){
	$rec_id = isset($_GET['id']) ? intval($_GET['id']) : '';
	if($rec_id) flow_drop_cart_goods($rec_id);
	$smarty->assign('cart_faild', 1);
	$smarty->assign('tips', '成功删除该商品！');
}
//清空
elseif ($act == 'clear'){
	$sql = "DELETE FROM " . $ecs->table('cart') . " WHERE session_id='" . SESS_ID . "'";
	$db->query($sql);
	$smarty->assign('cart_faild', 1);
	$smarty->assign('tips', '购物车已清空！');
}
//无刷新更新购物车
elseif($act=='update_group_cart'){
	include('includes/cls_json.php');
	
	$result = array('error' => 0, 'message' => '', 'content' => '', 'goods_id' => '');
	$json = new JSON;
	$rec_id = isset($_REQUEST['rec_id']) ? intval($_REQUEST['rec_id']) : 0;
	$number = isset($_REQUEST['number']) ? intval($_REQUEST['number']) : 0;
	$goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
	
	$result = array('rec_id' => $rec_id, 'number' => 1);
	$arr_return = check_goods_store($rec_id, $number);
	if ($rec_id <= 0 || $number <= 0){
		$result['content'] = '参数错误';
		$result['error']  = 1;
	}else if (!empty($arr_return['mes'])){
		$result['content'] = $arr_return['mes'];
		$result['error']  = 1;
		$result['number'] =$arr_return['number'];
	}else{
		$db->query("UPDATE " . $GLOBALS['ecs']->table('cart') . " set goods_number = '$number' where rec_id ='$rec_id'");
		$cart_goods = get_cart_goods();
		foreach($cart_goods['goods_list'] as $rec_goods)
		{
			if($rec_goods['rec_id'] == $rec_id)
			{
				$subtotal = $result['subtotal'] = $rec_goods['subtotal'];
				@$subtotal_exchange_integral = $rec_goods['subtotal_exchange_integral'];
			}
		}
		//购物车的描述的格式化
		$result['subtotal'] = $subtotal;
		$result['subtotal_exchange_integral'] = empty($subtotal_exchange_integral) ? 0 : $subtotal_exchange_integral;
		$result['cart_amount_desc'] = $cart_goods['total']['goods_price'];
		$result['market_amount_desc'] = $cart_goods['total']['market_price'].$cart_goods['total']['saving'].$cart_goods['total']['save_rate'];
	}
	die($json->encode($result));
}

/* 对商品信息赋值 */
$cart_goods = get_cart_goods();
$smarty->assign('goods_list', $cart_goods['goods_list']);
$smarty->assign('total', $cart_goods['total']);

$smarty->assign('footer', get_footer());
$smarty->display('cart.dwt');

/**
 * 删除购物车中的商品
 *
 * @access  public
 * @param   integer $id
 * @return  void
 */
function flow_drop_cart_goods($id){
	/* 取得商品id */
	$sql = "SELECT * FROM " .$GLOBALS['ecs']->table('cart'). " WHERE rec_id = '$id'";
	$row = $GLOBALS['db']->getRow($sql);
	if ($row){
		//如果是超值礼包
		if ($row['extension_code'] == 'package_buy'){
			$sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
					" WHERE session_id = '" . SESS_ID . "' " .
					"AND rec_id = '$id' LIMIT 1";
		}

		//如果是普通商品，同时删除所有赠品及其配件
		elseif ($row['parent_id'] == 0 && $row['is_gift'] == 0){
			/* 检查购物车中该普通商品的不可单独销售的配件并删除 */
			$sql = "SELECT c.rec_id
					FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('group_goods') . " AS gg, " . $GLOBALS['ecs']->table('goods'). " AS g
					WHERE gg.parent_id = '" . $row['goods_id'] . "'
					AND c.goods_id = gg.goods_id
					AND c.parent_id = '" . $row['goods_id'] . "'
					AND c.extension_code <> 'package_buy'
					AND gg.goods_id = g.goods_id
					AND g.is_alone_sale = 0";
			$res = $GLOBALS['db']->query($sql);
			$_del_str = $id . ',';
			while ($id_alone_sale_goods = $GLOBALS['db']->fetchRow($res))
			{
				$_del_str .= $id_alone_sale_goods['rec_id'] . ',';
			}
			$_del_str = trim($_del_str, ',');

			$sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
					" WHERE session_id = '" . SESS_ID . "' " .
					"AND (rec_id IN ($_del_str) OR parent_id = '$row[goods_id]' OR is_gift <> 0)";
		}
		//如果不是普通商品，只删除该商品即可
		else{
			$sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
					" WHERE session_id = '" . SESS_ID . "' " .
					"AND rec_id = '$id' LIMIT 1";
		}

		$GLOBALS['db']->query($sql);
	}

	flow_clear_cart_alone();
}

/**
 * 删除购物车中不能单独销售的商品
 *
 * @access  public
 * @return  void
 */
function flow_clear_cart_alone(){
	/* 查询：购物车中所有不可以单独销售的配件 */
	$sql = "SELECT c.rec_id, gg.parent_id
			FROM " . $GLOBALS['ecs']->table('cart') . " AS c
				LEFT JOIN " . $GLOBALS['ecs']->table('group_goods') . " AS gg ON c.goods_id = gg.goods_id
				LEFT JOIN" . $GLOBALS['ecs']->table('goods') . " AS g ON c.goods_id = g.goods_id
			WHERE c.session_id = '" . SESS_ID . "'
			AND c.extension_code <> 'package_buy'
			AND gg.parent_id > 0
			AND g.is_alone_sale = 0";
	$res = $GLOBALS['db']->query($sql);
	$rec_id = array();
	while ($row = $GLOBALS['db']->fetchRow($res)){
		$rec_id[$row['rec_id']][] = $row['parent_id'];
	}

	if (empty($rec_id)){
		return;
	}

	/* 查询：购物车中所有商品 */
	$sql = "SELECT DISTINCT goods_id
			FROM " . $GLOBALS['ecs']->table('cart') . "
			WHERE session_id = '" . SESS_ID . "'
			AND extension_code <> 'package_buy'";
	$res = $GLOBALS['db']->query($sql);
	$cart_good = array();
	while ($row = $GLOBALS['db']->fetchRow($res)){
		$cart_good[] = $row['goods_id'];
	}

	if (empty($cart_good)){
		return;
	}

	/* 如果购物车中不可以单独销售配件的基本件不存在则删除该配件 */
	$del_rec_id = '';
	foreach ($rec_id as $key => $value){
		foreach ($value as $v){
			if (in_array($v, $cart_good)){
				continue 2;
			}
		}
		$del_rec_id = $key . ',';
	}
	$del_rec_id = trim($del_rec_id, ',');
	if ($del_rec_id == ''){
		return;
	}

	/* 删除 */
	$sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') ."
			WHERE session_id = '" . SESS_ID . "'
			AND rec_id IN ($del_rec_id)";
	$GLOBALS['db']->query($sql);
}

/*
 *二次开发--检查是否超过了库存
 *@param $rec_id 购物车id号
 *@param $num 被检查的数字
 *@return $string 提示信息，没有则为空
 */
function check_goods_store($rec_id, $num){
	$return = array('mes' => '', 'number' => 1);
	$num = intval(make_semiangle($num));
	$rec_id = intval($rec_id);
	if ($num <= 0 && !is_numeric($num)){
		$return['mes'] = '所填数字必须是正整数！';
		return $return;
	}
	if ($rec_id <= 0){
		$return['mes'] = '参数错误！';
		return $return;
	}

	//查询：
	$sql = "SELECT `goods_id`, `goods_attr_id`, `product_id`, `extension_code` FROM" .$GLOBALS['ecs']->table('cart'). " WHERE rec_id='$rec_id' AND session_id='" . SESS_ID . "'";
	$goods = $GLOBALS['db']->getRow($sql);

	$sql = "SELECT g.goods_name, g.goods_number ".
			"FROM " .$GLOBALS['ecs']->table('goods'). " AS g, ".
				$GLOBALS['ecs']->table('cart'). " AS c ".
			"WHERE g.goods_id = c.goods_id AND c.rec_id = '$rec_id'";
	$row = $GLOBALS['db']->getRow($sql);

	//查询：系统启用了库存，检查输入的商品数量是否有效
	if (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] != 'package_buy'){
		
		if ($row['goods_number'] < $num){
			$return['mes'] = "非常抱歉，您选择的商品" . $row['goods_name'] . " 的库存数量不足 ， 您最多只能购买 " . $row['goods_number'] ." 件。";
			$return['number'] = $row['goods_number'];
			return $return;
		}
		/* 是货品 */
		$goods['product_id'] = trim($goods['product_id']);
		if (!empty($goods['product_id'])){
			$sql = "SELECT product_number FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '" . $goods['goods_id'] . "' AND product_id = '" . $goods['product_id'] . "'";

			$product_number = $GLOBALS['db']->getOne($sql);
			if ($product_number < $num)
			{
				$return['mes'] = "非常抱歉，您选择的商品" . $row['goods_name'] . " 的库存数量只有 " . $row['product_number'] . "，您最多只能购买 " . $row['product_number'] ." 件。";
				$return['number'] = $row['product_number'];
				return $return;
			}
		}
	}elseif (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] == 'package_buy'){
		if (judge_package_stock($goods['goods_id'], $num)){
				$return['mes'] = "非常抱歉，库存数量不足，请减少购买数购买。";
				return $return;
		}
	}
	return $return;
}

?>