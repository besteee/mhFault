<?php

$urlhost=$_SERVER['HTTP_HOST'];
if($urlhost!='www.a361.cn'&&$urlhost!='localhost')
{
echo("未授权！");
exit;
}
define('IN_ECS',true);
require(dirname(__FILE__) .'/includes/init.php');
if ($_REQUEST['act'] == 'main')
{
if (gd_version() == 0)
{
sys_msg($_LANG['captcha_note'],1);
}
$kefushow = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='kefushow'");
$skin = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='skin'");
$show = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='show'");
$showlefttop = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='showlefttop'");
$showleft = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='showleft'");
$showrighttop = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='showrighttop'");
$showright = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='showright'");
$fs_show = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='fs_show'");
$typeone = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='typeone'");
$kfqq = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='kfqq'");
$im = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='im'");
$typetwo = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='typetwo'");
$kfqqtwo = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='kfqqtwo'");
$imtwo = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='imtwo'");
$qqqun = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='qqqun'");
$wwqun = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='wwqun'");
$qqcss = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='qqcss'");
$wwcss = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='wwcss'");
$fenxiang = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='fenxiang'");
$kf53 = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='kf53'");
$kftel = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='kftel'");
$shijian = $db->getOne("SELECT value FROM ".$GLOBALS['ecs']->table('kefu') ." WHERE name='shijian'");
$captcha_check = array();
if ($kefushow==1)
{
$captcha_check['kefushowyes']          = 'checked="checked"';
}else{
$captcha_check['kefushowno']     = 'checked="checked"';
}
if ($show==0)
{
$captcha_check['showleft']          = 'checked="checked"';
}else{
$captcha_check['showright']     = 'checked="checked"';
}
if ($fs_show==0)
{
$captcha_check['fs_showyes']          = 'checked="checked"';
}else{
$captcha_check['fs_showno']     = 'checked="checked"';
}
if ($qqcss==0)
{
$captcha_check['qqcss0']          = 'checked="checked"';
}elseif($qqcss==1){
$captcha_check['qqcss1']     = 'checked="checked"';
}elseif($qqcss==2){
$captcha_check['qqcss2']     = 'checked="checked"';
}
if ($wwcss==0)
{
$captcha_check['wwcss0']          = 'checked="checked"';
}elseif($wwcss==1){
$captcha_check['wwcss1']     = 'checked="checked"';
}elseif($wwcss==2){
$captcha_check['wwcss2']     = 'checked="checked"';
}
$fenxiang = explode(",",$fenxiang);
if (in_array('bds_qzone',$fenxiang)){$captcha_check['fx1'] = 'checked="checked"';}
if (in_array('bds_tsina',$fenxiang)){$captcha_check['fx2'] = 'checked="checked"';}
if (in_array('bds_baidu',$fenxiang)){$captcha_check['fx3'] = 'checked="checked"';}
if (in_array('bds_renren',$fenxiang)){$captcha_check['fx4'] = 'checked="checked"';}
if (in_array('bds_tqq',$fenxiang)){$captcha_check['fx5'] = 'checked="checked"';}
if (in_array('bds_kaixin001',$fenxiang)){$captcha_check['fx6'] = 'checked="checked"';}
if (in_array('bds_tqf',$fenxiang)){$captcha_check['fx7'] = 'checked="checked"';}
if (in_array('bds_hi',$fenxiang)){$captcha_check['fx8'] = 'checked="checked"';}
if (in_array('bds_douban',$fenxiang)){$captcha_check['fx9'] = 'checked="checked"';}
if (in_array('bds_tsohu',$fenxiang)){$captcha_check['fx10'] = 'checked="checked"';}
if (in_array('bds_msn',$fenxiang)){$captcha_check['fx11'] = 'checked="checked"';}
if (in_array('bds_qq',$fenxiang)){$captcha_check['fx12'] = 'checked="checked"';}
if (in_array('bds_taobao',$fenxiang)){$captcha_check['fx13'] = 'checked="checked"';}
if (in_array('bds_tieba',$fenxiang)){$captcha_check['fx14'] = 'checked="checked"';}
if (in_array('bds_sohu',$fenxiang)){$captcha_check['fx15'] = 'checked="checked"';}
if (in_array('bds_t163',$fenxiang)){$captcha_check['fx16'] = 'checked="checked"';}
if (in_array('bds_qy',$fenxiang)){$captcha_check['fx17'] = 'checked="checked"';}
if (in_array('bds_tfh',$fenxiang)){$captcha_check['fx18'] = 'checked="checked"';}
if (in_array('bds_hx',$fenxiang)){$captcha_check['fx19'] = 'checked="checked"';}
if (in_array('bds_fx',$fenxiang)){$captcha_check['fx20'] = 'checked="checked"';}
if (in_array('bds_ff',$fenxiang)){$captcha_check['fx21'] = 'checked="checked"';}
if (in_array('bds_xg',$fenxiang)){$captcha_check['fx22'] = 'checked="checked"';}
if (in_array('bds_ty',$fenxiang)){$captcha_check['fx23'] = 'checked="checked"';}
if (in_array('bds_fbook',$fenxiang)){$captcha_check['fx24'] = 'checked="checked"';}
if (in_array('bds_twi',$fenxiang)){$captcha_check['fx25'] = 'checked="checked"';}
if (in_array('bds_ms',$fenxiang)){$captcha_check['fx26'] = 'checked="checked"';}
if (in_array('bds_deli',$fenxiang)){$captcha_check['fx27'] = 'checked="checked"';}
if (in_array('bds_s139',$fenxiang)){$captcha_check['fx28'] = 'checked="checked"';}
if (in_array('bds_s51',$fenxiang)){$captcha_check['fx29'] = 'checked="checked"';}
if (in_array('bds_zx',$fenxiang)){$captcha_check['fx30'] = 'checked="checked"';}
if (in_array('bds_linkedin',$fenxiang)){$captcha_check['fx31'] = 'checked="checked"';}
$smarty->assign('captcha',$captcha_check);
$smarty->assign('skin',$skin);
$smarty->assign('showlefttop',$showlefttop);
$smarty->assign('showleft',$showleft);
$smarty->assign('showrighttop',$showrighttop);
$smarty->assign('showright',$showright);
$smarty->assign('typeone',$typeone);
$smarty->assign('kfqq',$kfqq);
$smarty->assign('im',$im);
$smarty->assign('typetwo',$typetwo);
$smarty->assign('kfqqtwo',$kfqqtwo);
$smarty->assign('imtwo',$imtwo);
$smarty->assign('qqqun',$qqqun);
$smarty->assign('wwqun',$wwqun);
$smarty->assign('kf53',$kf53);
$smarty->assign('kftel',$kftel);
$smarty->assign('shijian',$shijian);
$smarty->assign('ur_here',$_LANG['kefu']);
$smarty->display('kefu.htm');
}
if($_REQUEST['act'] == 'css')
{
$skin = $_REQUEST['skin'];
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$skin' WHERE name='skin'";
$db->query($sql);
sys_msg('选择成功！',0,array(array('href'=>'kefu.php?act=main','text'=>$_LANG['kefu'])));
}
if ($_REQUEST['act'] == 'save_config')
{
$kefushow = $_POST['kefushow'];
$show = $_POST['show'];
$showlefttop = $_POST['showlefttop'];
$showleft = $_POST['showleft'];
$showrighttop = $_POST['showrighttop'];
$showright = $_POST['showright'];
$fs_show = $_POST['fs_show'];
$typeone = $_POST['typeone'];
$kfqq = $_POST['kfqq'];
$im = $_POST['im'];
$typetwo = $_POST['typetwo'];
$kfqqtwo = $_POST['kfqqtwo'];
$imtwo = $_POST['imtwo'];
$qqqun = $_POST['qqqun'];
$wwqun = $_POST['wwqun'];
$qqcss = $_POST['qqcss'];
$wwcss = $_POST['wwcss'];
$fenxiang=$_POST['fenxiang'];
if($fenxiang){
$fenxiang=implode(",",$fenxiang);
}
$kf53 = $_POST['kf53'];
$kftel = $_POST['kftel'];
$shijian = $_POST['shijian'];
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$kefushow' WHERE name='kefushow'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$show' WHERE name='show'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$showlefttop' WHERE name='showlefttop'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$showleft' WHERE name='showleft'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$showrighttop' WHERE name='showrighttop'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$showright' WHERE name='showright'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$fs_show' WHERE name='fs_show'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$typeone' WHERE name='typeone'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$kfqq' WHERE name='kfqq'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$im' WHERE name='im'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$typetwo' WHERE name='typetwo'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$kfqqtwo' WHERE name='kfqqtwo'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$imtwo' WHERE name='imtwo'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$qqqun' WHERE name='qqqun'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$wwqun' WHERE name='wwqun'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$qqcss' WHERE name='qqcss'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$wwcss' WHERE name='wwcss'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$fenxiang' WHERE name='fenxiang'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$kf53' WHERE name='kf53'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$kftel' WHERE name='kftel'";
$db->query($sql);
$sql = "UPDATE ".$ecs->table('kefu') ." SET value='$shijian' WHERE name='shijian'";
$db->query($sql);
clear_cache_files();
sys_msg('修改成功！',0,array(array('href'=>'kefu.php?act=main','text'=>$_LANG['kefu'])));
}
?>