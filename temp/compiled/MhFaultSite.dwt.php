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
<script type="text/javascript" src="<?php echo $this->_var['static_path']; ?>/js/geo1.js"></script>
</head>
<body  onload="setup();promptinfo();">
<script type="text/javascript">
var isWidescreen=screen.width>=1280;
if (isWidescreen){document.getElementsByTagName("body")[0].className="w1210";}
</script>
<?php echo $this->fetch('library/mhfault_header.lbi'); ?>
<script src="http://api.map.baidu.com/api?v=2.0&ak=C2ac08f5ef607a0afc17c740ed455431" type="text/javascript"></script>
 <div style="width:1280px;positin:relative;margin:auto;">
	<div style="width:300px;float:left; border:2px solid rgb(200,200,200);border-radius:5px;padding:10px;">
	 <form>
		    省 <select class="select" name="province" id="s1">
		      <option></option>
		    </select>
		    &nbsp;市 <select class="select" name="city" id="s2">
		      <option></option>
		    </select>
		    <!--select class="select" name="town" id="s3" style="margin-top:5px;">
		      <option></option>
		    </select-->
	   </form>
	   <div id="fault_site" style="padding:0px 10px">
		<?php $_from = $this->_var['fault_site']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'fault_site_0_07921000_1418266299');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['fault_site_0_07921000_1418266299']):
?>

			<div style="float:left;width:30px;margin-right:5px;" ><img src="/images/fault_site.jpg" ></div><div class="geo" geo="<?php echo $this->_var['fault_site_0_07921000_1418266299']['geo']; ?>" style="float:left;width:240px;border-top:1px dashed rgb(220,220,200); margin-top:5px;cursor:pointer;"><?php echo $this->_var['fault_site_0_07921000_1418266299']['name']; ?></div>
			<!--div style="width:90%;border-top:1px dashed rgb(220,220,200); margin-top:5px;"><?php echo $this->_var['fault_site_0_07921000_1418266299']['tel']; ?></div>
			<div style="width:90%;border-top:1px dashed rgb(220,220,200); margin-top:5px;"><?php echo $this->_var['fault_site_0_07921000_1418266299']['province']; ?>&nbsp;<?php echo $this->_var['fault_site_0_07921000_1418266299']['city']; ?>&nbsp;<?php echo $this->_var['fault_site_0_07921000_1418266299']['address']; ?></div-->
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

	   </div>
	 </div>
	<div id="container" style="border-radius:5px;height:700px;width:900px;margin:auto;margin-bottom:10px;border:2px solid rgb(200,200,200);padding:5px;background:rgb(230,230,230);"></div>
</div>
<script type="text/javascript">
var cityName;
var map = new BMap.Map("container");          // 创建地图实例
var point = new BMap.Point(116.404, 39.915);  // 创建点坐标
map.centerAndZoom(point, 9);                 // 初始化地图，设置中心点坐标和地图级别
	function myFun(result){
		 cityName = result.name;
		map.setCenter(cityName);
		alert("当前定位城市:"+cityName);
	}
	var myCity = new BMap.LocalCity();
	myCity.get(myFun);
map.enableScrollWheelZoom();	//	鼠标滚轮放大放小
map.addControl(new BMap.NavigationControl());
map.addControl(new BMap.ScaleControl());
map.addControl(new BMap.OverviewMapControl());
map.addControl(new BMap.MapTypeControl());

var customLayer=new BMap.CustomLayer({		//数据覆盖层
    geotableId: 87786,
    q: '', //检索关键字
    tags: '', //空格分隔的多字符串
    filter: '' //过滤条件,参考http://developer.baidu.com/map/lbs-geosearch.htm#.search.nearby
});
map.addTileLayer(customLayer);//添加自定义图层

function theLocation(){
		var city = cityName;
		if(city != ""){
			map.centerAndZoom(cityName,9);      // 用城市名设置地图中心点
		}
}
//这个函数是必须的，因为在geo.js里每次更改地址时会调用此函数
function promptinfo()
{
    var address = document.getElementById('address');
    var s1 = document.getElementById('s1');
    var s2 = document.getElementById('s2');
    var s3 = document.getElementById('s3');
    address.value = s1.value + s2.value + s3.value;
}
$(".select").change(function(){
	cityName=$(this).find("option:selected").val();
	theLocation();
});

$(".geo").click(function(){
	var geo=$(this).attr("geo");
	geo=geo.split(",");
	var point = new BMap.Point(parseFloat(geo[0]), parseFloat(geo[1]));  // 创建点坐标
	map.centerAndZoom(point, 18);                 // 初始化地图，设置中心点坐标和地图级别
});
</script>

<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
