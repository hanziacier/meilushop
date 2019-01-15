	
	var timer2 = null;//定义定时器变量
	//鼠标移入div1或div2都把定时器关闭了，不让他消失
	var li1=$(".quick_links_panel li");	var li2=$(".quick_toggle li");
	    li1.mouseenter(function(){
	
		$(this).children(".mp_tooltip").animate({left:-92,queue:true});
		$(this).children(".mp_tooltip").css("visibility","visible");
		$(this).children(".ibar_login_box").css("display","block");
	});
	li1.mouseleave(function(){
		
		$(this).children(".mp_tooltip").css("visibility","hidden");
		$(this).children(".mp_tooltip").animate({left:-121,queue:true});
		$(this).children(".ibar_login_box").css("display","none");
	});
	li2.mouseover(function(){
		$(this).children(".mp_qrcode").show();
	});
	li2.mouseleave(function(){
		$(this).children(".mp_qrcode").hide();
	});

	    // 元素以及其他一些变量
var fly = document.querySelector("#flyItem"), 
sidecart = document.querySelector("#shopCart");
	
var ni = 0;
// 抛物线运动
var fline = funParabola(fly, sidecart, {
	speed: 400, //抛物线速度
	curvature: 0.0008, //控制抛物线弧度
	complete: function() {
		fly.style.visibility = "hidden";
		//sidecart.querySelector("span").innerHTML = ++ni;
	}
});		


// 绑定点击事件
if (fly && sidecart) {
	
	[].slice.call(document.getElementsByClassName("jr")).forEach(function(button) {
		button.addEventListener("click", function(event) {
       
				// 滚动大小
			var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,
			    scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
		
			var left=parseInt(event.clientX + scrollLeft);	
		
			fly.style.right =left + "px";
			fly.style.top = event.clientY + scrollTop + "px";
			fly.style.visibility = "visible";
		
			// 需要重定位
			fline.position().move();		
		});
	});
}

function addpaowuxian(){

dos();	

}

 dos();	