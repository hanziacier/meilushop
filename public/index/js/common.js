
function  decNum(obj,id){
         var cur_num = $(obj).siblings('.ipt').val();
		 if(cur_num <= 0){
					$(obj).siblings('.ipt').val(0);
				}else{
					cur_num--;
					$(obj).siblings('.ipt').val(cur_num);
				}
        
	    $.post(dec_url,{id:id},function(data){
				  $('.tNum').text(data.count);
				  $('.tSum').text("¥"+data.total);
				  $('.cart_num').text(data.sum);	
	   });
		
     }

	  function  incNum(obj,id){
         var cur_num = $(obj).siblings('.ipt').val();
		       if(cur_num >= 99){
					$(obj).siblings('.ipt').val(99);
				}else{
					cur_num++;
					$(obj).siblings('.ipt').val(cur_num);
				}
        
	    $.post(inc_url,{id:id},function(data){
				  $('.tNum').text(data.count);
				  $('.tSum').text("¥"+data.total);
				  $('.cart_num').text(data.sum);	
	   });
		
     }	 //购物车删除
	function cancelCart(obj,sku_id){ 
		     if(confirm("确认删除吗？")){  
				$.post(del_url,{id:sku_id},function(data){   
					 if(data.status){ 
						  $('.item'+sku_id).remove();	 
						  $('#item'+sku_id).remove();
						  if(!data.sum){
						   
					        $(" .wdgwc_main_top").html(html);
							var html='<p class="none_tips" style="margin:50px 0;text-align:center;"><i> </i>购物车中没有商品，赶紧去选购！</p>';
						    $(".checkout_box").hide(); 
						    $(".minicart_list .list_detail ul").empty();
						    $(".minicart_list .list_detail ul").append(html);
						  }
						 
						  $('.tNum').text(data.count);
				          $('.tSum').text("¥"+data.total);
						  var num="("+data.sum+")";
				          $('.cart_num').html(num);
					}
					 else{
					    alert(data.info);
					 }
                });
		}
	}

