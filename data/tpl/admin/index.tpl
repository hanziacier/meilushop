 <!-- 头部 -->
	{include file='public/header'}
<!-- 头部 --> 
		 <script type="text/javascript" src="__COMMON__/laydate/laydate.js"></script>	
			<div class="content">
				<div class="edit_title">{$meta_title|default=""}</div>
				<div class="tips_msg none"><span class="tips">保存成功</span><span class="close_tips"></span></div>
					<div class="search">
					   <form class="search-form"  action="{:url()}" method="post">
						  <div class="group">
							   名称：<input type="text" name="title" class="search_ipt" value="{:input('title')}"/>
						  
						  </div>
							  <div class="group">
							 链接：<input type="text" name="url"  class="search_ipt" value="{:input('url')}"/>
						  </div>
							 <div class="group">
							 创建时间：<input type="text"  name="start_time" id="start_time" class="laydate-icon input_box search_ipt" value="{:input('start_time')}"/> 
						  </div>
						
							 <div class="group">
								 结束时间：<input type="text"  name="end_time" id="end_time" class="laydate-icon input_box search_ipt end" value="{:input('end_time')}"/><input type="button" class="search_btn"value="搜索" onclick="$('.search-form').submit()">
							  </div>
					   </form>
					</div>
				
				<div class="table">
					<div class="edit">
						<div class="edit_left ">
							<a href="{:U('add')}" class="add cur">新增</a>
							<a  data-url="{:U('del')}" class="delete cur">删除</a>
						</div>
						<div class="search_right">
							<input type="text" value="{:input('title')}"/>
							<div class="search_btn"></div>
						</div>
					</div>
					<table class="list_table">
					    <tr>
						   <th> <input class="checkbox check-all" type="checkbox"></th>
						   <th>id</th>
						  
		                 
		                   <th class=""></th>
		                   <th class="">操作</th>
                        </tr>
				          {volist name="res.list" id="vo"}
                               <tr class="even gradeC">
                                    <td><input class="ids row-selected" type="checkbox" name="id[]" value="{$vo.id}"></td>
									<td>{$vo.id} </td>
									<td> </td>
			                       
			                        <td class="list_opr">
                                            <span class="opr_box">
									               <a href="{:url('edit?id='.$vo['id'])}" class="edit_btn cur">编辑</a>
									              <a data-url="{:url('del?id='.$vo['id'])}" class="del_btn cur">删除</a>
								
                                        </span>          
                                    </td>
                                </tr>
											
					    {/volist}
					</table>
					<!--分页-->
					<ul class="pagination">
						  {$res.page}
					</ul>
				</div>
			</div>
		</div>
  <script src="__JS__/style.js"></script>
  <script>
		laydate({
				elem: '#start_time',
				format: 'YYYY-MM-DD hh:mm:ss', 
				min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
				event: 'focus' //响应事件。如果没有传入event，则按照默认的click
		});
			
		laydate({
				  elem: '#end_time',
				  format: 'YYYY-MM-DD hh:mm:ss', 
				  min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
				  event: 'focus' //响应事件。如果没有传入event，则按照默认的click
		});
</script> <!-- 头部 -->
	{include file='public/footer'}
<!-- 头部 --> 

