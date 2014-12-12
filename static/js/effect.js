var goodsHover = function(){
	if (!jQuery.support.opacity) {
		$('.goods-list li .action').prepend('<span class="bg"></span>');
	};
	$('.goods-list li').hover(function(){
		$(this).addClass('hover');
		if (jQuery.support.opacity) {
			$(this).find('.action').stop().animate({opacity:'1'}, 500);
		} else {
			$(this).find('.action a').stop().animate({opacity:'1'}, 500);
		};
	}, function() {
		$(this).removeClass('hover');
		if (jQuery.support.opacity) {
			$(this).find('.action').stop().animate({opacity:'0'}, 300);
		} else {
			$(this).find('.action a').stop().animate({opacity:'0'}, 300);
		};
	});
};
var goodsClearer = function(){
	$('.col-main .goods-list li.first-child').before('<b class="clearer"></b>');
};
$(document).ready(function() {
	$('a[rel="external"],a.more,.goods-list a.image,.goods-list a.name,.goods-list a.detail').click(function(){window.open(this.href);return false;});
	goodsHover();
	goodsClearer();
	$('#slide-item li').hide().css({position:'absolute'});
	var slides = $('#slide-item li');
	var currentSlide = -1;
	var prevSlide = null;
	var interval = null;
	var html = '<p id="slide-triggers">'
	for (var i = 0 ;i <= slides.length - 1; i++){
		var url = $('#slide-item').find('a').eq(i).attr('href');
		html += '<a href="'+ url +'" class="slide" id="slide'+ i +'">'+ (i+1) +'</a>' ;
	}
	html += '</p>';
	$('#slide-item').after(html);
	$('#slide-triggers').css({opacity:'0.5'});
	$('#slide-item,#slide-triggers').hover(function(){
		$('#slide-triggers').stop().animate({opacity:'1'}, 500);
	}, function() {
		$('#slide-triggers').stop().animate({opacity:'0.5'}, 300);
	});
	for (var i = 0 ;i <= slides.length - 1; i++){
		$('#slide'+i).bind("mouseover",{index:i},function(event){
			currentSlide = event.data.index;
			gotoSlide(event.data.index);
		});
	};
	if (slides.length <= 1){
		$('.slide').hide();
	}
	nextSlide();
	function nextSlide (){
		if (currentSlide >= slides.length -1){
			currentSlide = 0;
		}else{
			currentSlide++
		}
		gotoSlide(currentSlide);
	}
	function gotoSlide(slideNum){
		if (slideNum != prevSlide){
			if (prevSlide != null){
				$(slides[prevSlide]).stop().hide();
				$('#slide'+prevSlide).removeClass('current');
			}
			$('#slide'+currentSlide).addClass('current');
			$('#slide'+slideNum).addClass('current');
			$('#slide'+prevSlide).removeClass('current');
			$(slides[slideNum]).stop().show();
			prevSlide = currentSlide;
			if (interval != null){
				clearInterval(interval);
			}
			interval = setInterval(nextSlide, 5000);
		}
	}
});
