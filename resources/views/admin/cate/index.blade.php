<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
           <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">  
           <script src="/static/admin/js/jquery-3.2.1.min.js"></script>
    </head>
    <body>
         <h3>分类列表</h3>
         <a href="{{url('/cate/create')}}">添加</a>
         <hr/>
         
        
       <table class="table table-striped">
	
	<thead>
		<tr>
                    <th>ID</th>
			<th>名称</th>
			<th>是否显示</th>
			<th>是否导航显示</th>
                        <th>操作</th>
		</tr>
	</thead>
	<tbody>
            @foreach ($data as $v)
		<tr>
			<td>{{$v->cate_id}}</td>
                        <td>@php echo str_repeat('|—',$v->level); @endphp {{$v->cate_name}}</td>
			<td>@if($v->is_show==1)√ @else × @endif</td>
                        <td>{{$v->is_nav_show==1?'√':'×'}}</td>
                        <td><a href="{{url('/cate/edit/'.$v->cate_id)}}" class="btn btn-info">编辑</a>|<a href="{{url('/cate/del/'.$v->cate_id)}}" class="btn btn-danger">删除</a></td>
		</tr>
              @endforeach
              
              
	</tbody>
</table>
    </body>
    <script>
        //ajax 分页
        //$('.pagination a').click(function(){
       $(document).on('click','.pagination a',function(){    
            var url = $(this).attr('href');  
            $.get(url,function(res){
               $('tbody').html(res);
            });
            return false;
        });
   </script>
</html>
