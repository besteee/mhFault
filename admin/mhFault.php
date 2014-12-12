<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

$smarty->assign('fault',get_fault(0));		//顶层故障项目
$smarty->assign('fault_detail',get_fault($_GET['fault_id'],'fault_detail'));		
$smarty->assign('fault_name',$_GET['fault_name']);
$smarty->assign('fault_id',$_GET['fault_id']);
$smarty->assign('diyId',$_GET['diyId']);
$smarty->assign('fault_diy',get_fault_diy());

switch($_GET['act']){
	case "":
		$dwt="mhFault.htm";
	break;
	case "detail":
		$dwt="mhFaultD.htm";
	break;
	case "diy":
		$dwt="mhFaultDiy.htm";
	break;
}
$smarty->display($dwt);
function get_fault($pid,$table='fault_category'){
	$arr=array();
	$sql="SELECT * FROM".$GLOBALS['ecs']->table($table)."WHERE pid in('$pid')";
	$row=$GLOBALS['db']->getAll($sql);
	foreach($row as $key=>$result){
		$arr[$key]['name']=$result['name'];
		$arr[$key]['id']=$result['id'];
		$pid2=$arr[$key]['id'];
		$sql2="SELECT * FROM".$GLOBALS['ecs']->table($table)."WHERE pid in($pid2)";
		$row2=$GLOBALS['db']->getALL($sql2);
		foreach($row2 as $key2 =>$result2){
			$arr[$key]['subMhFault'][$key2]['name']=$result2['name'];
			$arr[$key]['subMhFault'][$key2]['id']=$result2['id'];
			$arr[$key]['subMhFault'][$key2]['matePrice']=$result2['matePrice'];
			$arr[$key]['subMhFault'][$key2]['timePrice']=$result2['timePrice'];
			$arr[$key]['subMhFault'][$key2]['materialsPrice']=$result2['materialsPrice'];
		}
	}
	return $arr;
}
function get_fault_diy(){
	$arr=array();
	$sql="SELECT * FROM".$GLOBALS['ecs']->table('fault_diy')."WHERE handle=0";
	$result=$GLOBALS['db']->getAll($sql);
	foreach($result as $key=>$row){
		$arr[$key]['id']=$row['id'];
		$arr[$key]['user_id']=$row['user_id'];
		$arr[$key]['fault_name']=$row['fault_name'];
		$arr[$key]['cartype']=$row['cartype'];
		$arr[$key]['need']=$row['need'];
		$arr[$key]['text']=$row['text'];
		$arr[$key]['name']=$row['name'];
		$fault_name=$row['fault_name'];
		$sql2="SELECT * FROM".$GLOBALS['ecs']->table('fault_category')."WHERE name='$fault_name'";
		$result2=$GLOBALS['db']->getRow($sql2);
		$arr[$key]['fault_id']=$result2['id'];
	}
	return $arr;
}

function addGoods(){

	print_r($_POST);
	exit;
}

function addGoods1(){

		$goods_name=$_POST['goods_nameP'];
		$shop_price=$_POST['totalPriceP'];
		$matePrice=$_POST['matePriceP'];
		$timePrice=$_POST['timePriceP'];
		$materialsPrice=$_POST['materialsPriceP'];
		$matePriceNum=$_POST['matePriceNumP'];
		$timePriceNum=$_POST['timePriceNumP'];
		$materialsPriceNum=$_POST['materialsPriceNumP'];

		$sql="INSERT INTO".$GLOBALS['ecs']->table('goods')."(goods_name,shop_price,matePrice,timePrice,materialsPrice,matePriceNum,timePriceNum,materialsPriceNum)value('$goods_name','$shop_price','$matePrice','$timePrice','$materialsPrice','$matePriceNum','$timePriceNum','$materialsPriceNum')";
		$result=$GLOBALS['db']->query($sql);
		if($result){
			echo '您的需求已提交，工作人员将马上与您联系！';
		}


	exit;
}
?>