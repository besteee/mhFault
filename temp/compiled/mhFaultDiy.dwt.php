<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link href="themes/jd2013/base.css" rel="stylesheet" type="text/css">
<link href="themes/jd2013/home.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_var['static_path']; ?>/js/jquery-1.11.0.min.js"></script>
</head>
<body>
<script type="text/javascript">
var isWidescreen=screen.width>=1280;
if (isWidescreen){document.getElementsByTagName("body")[0].className="w1210";}
</script>
<?php echo $this->fetch('library/mhfault_header.lbi'); ?>

<div id="mhFaultDiy">
	<div class="diyTitle">产品套餐定制</div>
	<div class="diyForm">
		<div class="text">请提交您的需求，我们将根据您提交的需求，通过技术和市场价格机制，为您配置出相应的套餐，此套餐包含产品、工时费及担保费。方便您第一时间进行选购，并就近接受服务。</div>
		<div class="yourName">您的称呼　　<input type="text" name="yourName"></div>
		<div class="yourTel">手机号码　　<input type="text" name="yourTel"></div>
		<div class="yourCar" style="position:relative;">您的汽车

		</div>
		<div class="yourNeed" style="position:relative;">您的需求
		<span id="yourNeed">

		</span>
			<span id="subYourNeed">

			</span>
		</div>
		<div class="yourText"><span style="float:left;">内　　容</span>
			<span style="margin-left:21px;"><textarea naem="yourText" ></textarea><span>
		</div>
		<button id="btnSubmit">提交</button>
	</div>
</div>
<script type="text/javascript">

var mhace={
	"品牌":["A 阿斯顿·马丁","A 奥迪","B 巴博斯","B 宝骏","B 宝马","B 保时捷","B 北京汽车","B 北汽威旺","B 北汽制造","B 奔驰","B 奔腾","B 本田","B 比亚迪","B 标致","B 别克","B 宾利","B 布加迪","C 昌河","C 长安","C 长安商用","C 长城","D DS","D 大众","D 道奇","D 东风","D 东风风度","D 东风风神","D 东风风行","D 东风小康","D 东南","F 法拉利","F 菲亚特","F 丰田","F 福迪","F 福特","G GMC","G 观致","G 光冈","G 广汽传祺","G 广汽吉奥","H 哈飞","H 哈弗","H 海格","H 海马","H 恒天","H 红旗","H 华泰","H 黄海","J Jeep","J 吉利帝豪","J 吉利全球鹰","J 吉利英伦","J 江淮","J 江铃","J 捷豹","J 金杯","J 金旅","J 金旅","K 卡尔森","K 开瑞","K 凯迪拉克","K 科尼赛克","K 克莱斯勒","L 兰博基尼","L 劳伦士","L 劳斯莱斯","L 雷克萨斯","L 雷诺","L 理念","L 力帆","L 莲花汽车","L 猎豹汽车","L 林肯","L 铃木","L 陆风","L 路虎","L 路特斯","M MG","M MINI","M 马自达","M 玛莎拉蒂","M 迈凯伦","M 迈凯伦","N 纳智捷","O 讴歌","O 欧宝","O 欧朗","Q 奇瑞","Q 启辰","Q 起亚","R 日产","R 荣威","R 如虎","R 瑞麒","S smart","S 三菱","S 陕汽通家","S 上汽大通","S 绅宝","S 世爵","S 双环","S 双龙","S 思铭","S 斯巴鲁","S 斯柯达","W 威麟","W 威兹曼","W 沃尔沃","W 五菱汽车","W 五十铃","X 西雅特","X 现代","X 新凯","X 雪佛兰","X 雪铁龙","Y 野马汽车","Y 一汽","Y 依维柯","Y 英菲尼迪","Y 永源","Z 中华","Z 中兴","Z 众泰"]

}
var mhFault={
	"空调故障":["时凉时不凉 ","一边凉一边不凉","前面凉后面不凉","开空调有异响","吹出的风有异味","出热风没有冷气","完全没风出","出风量小","不是很凉","开空调凉的很慢","风向模式调不了","空调突然不制冷","1","空调不工作","早晚凉，中午不怎么凉","怠速时不怎么凉，跑起来凉","冷车时制冷，热车后不制冷","开空调一段时间后就不制冷","开空调一段时间后就没风出"],
	"烧机油":["严重烧机油(3000km加一升)","中度烧机油(4000km加一升)","轻度烧机油(5000km加一升)"]
}

var yourCarHtml='您的汽车<select name="yourCar" class="yourCarS" style="margin-left:21px;"><option value="请选择">请选择</option>';

for(var i in mhace.品牌){
	yourCarHtml+='<option value="'+mhace.品牌[i]+'">'+mhace.品牌[i]+'</option>';
}
$(".yourCar").html(yourCarHtml+'<select><span id="subYourCar" style="position:absolute;top:15px; left:220px;"></span>');

$(".yourCarS").change(function(){
	var brand_value=$(".yourCarS>option:selected").val();
		$.ajax({
			url: '',
			type: 'POST',
			data:{action:'subCarType',brand:brand_value},
			dataType: 'html',
			success: function(result)
			{
				$("#subYourCar").html(result);
			}
		});
});

$("#yourNeed").html(
		'<select class="yourNeedS" name="yourNeed" style="margin-left:21px;">'+		//故障项目选择
			'<option value="">请选择</option>'+
			'<option value="空调故障">空调故障</option>'+
			'<option value="烧机油">烧机油</option>'+
		'</select>');
$(".yourNeedS").change(function(){
	$(".subYourNeedS").css("display","block");
	var selectFault=$(".yourNeedS>option:selected").val();
	var subYourNeedHtml='<select class="subYourNeedS" style="position:absolute;top:15px; left:180px;"><option value="">请选择</option>';
	for(var i in mhFault[selectFault]){
		subYourNeedHtml+='<option value="'+mhFault[selectFault][i]+'">'+mhFault[selectFault][i]+'</option>';
	}
	$("#subYourNeed").html(subYourNeedHtml+'</select>');
});

$("#btnSubmit").click(function(){
	var yourName=$(".yourName input").val();
	var yourTel=$(".yourTel input").val();
	var yourCarS=$(".yourCarS>option:selected").val();
	var subYourCarS=$(".subYourCarS>option:selected").val();
	var yourNeedS=$(".yourNeedS>option:selected").val();
	var subYourNeedS=$(".subYourNeedS>option:selected").val();
	var yourText=$(".yourText textarea").val()
	//alert(yourName+yourTel+yourCarS+subYourCarS+yourNeedS+subYourNeedS+yourText);
	$.ajax({
		url: 'addDiy.php',
		type: 'POST',
		data:{action:'addDiy',name:yourName,tel:yourTel,text:yourText,carType:yourCarS+' '+subYourCarS,need:yourNeedS+' '+subYourNeedS,fault_name:subYourNeedS},
		dataType: 'html',
		success: function(result)
		{
			alert(result);
		}
	});
});
</script>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
