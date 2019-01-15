
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-touch-fullscreen" content="yes">
		<meta name="HandheldFriendly" content="True">
		<title>微商城</title>

		<link rel="stylesheet" href="__CSS__/style.css">
		<script type="text/javascript" src="__JS__/jquery-1.10.1.min.js"></script>

	</head>
<body>
		<!--头部-->
		<div class="top_con01">
			<div class="fh_icon">
				<a onClick="javascript :history.go(-1);"></a>
			</div>
			<div class="yc_icon" id="s_ser">
				<a href="#"></a>
			</div>
			<div class="yc_icon fot_nav02" id="h_ser">
				<a href="#"></a>
			</div>
			<h1>收货人信息</h1>
		</div>
		{include file="public/menu"/}

    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #555; font-size: 16px; }
      .p-link input {
    background: none;
    border: none;
    color: #777;
    font-size: 1.6rem;
}p,#href,#wait{ color: #777;}
    </style>

<body> 


  <div  style="text-align:center; margin-top:2.1em; font-size:1.35em;">
            <p style="padding:1.0rem"> <?php echo(strip_tags($msg));?></p>
<div> 
          <span  style="margin-right:0.2em;"> 
	   <p class="jump">
            页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
          </p>
	
	</span>
   
</div>
<div style="width:1px; height:1px; overflow:hidden"></div>
</div>
</div>

    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>

