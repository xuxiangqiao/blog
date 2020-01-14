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
           <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
         <h3>品牌列表</h3>
         <h3>欢迎【{{session('admin')->username??''}}】登录,<a href="{{url('/logout')}}">退出</a>  </h3>
         <a href="{{url('/brand/create')}}">添加</a>  
         <hr/>
         
         <form >
             <input type="text" name="word" value="{{$query['word']??''}}" placeholder="请输入关键字">
             <input type="text" name="desc" value="{{$query['desc']??''}}" placeholder="请输入描述关键字">
             <button>搜索</button>
         </form>
       <table class="table table-striped">
	
	<thead>
		<tr>
                    <th>ID</th>
			<th>名称</th>
			<th>网址</th>
			<th>描述</th>
                        <th>添加时间</th>
                        <th>操作</th>
		</tr>
	</thead>
	<tbody>
            @foreach ($data as $v)
		<tr>
			<td>{{$v->brand_id}}</td>
                        <td><img src="{{env('UPLOAD_URL')}}{{$v->brand_logo}}" width="100"/>{{$v->brand_name}}</td>
			<td>{{$v->brand_url}}</td>
                        <td>{{$v->brand_desc}}</td>
                        <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                        <td><a href="{{url('/brand/edit/'.$v->brand_id)}}" class="btn btn-info">编辑</a>|<a onclick="ajaxdel({{$v->brand_id}})" href="javascript:void(0)" class="btn btn-danger">删除</a></td>
		</tr>
              @endforeach
              
              <tr>
                  <td colspan="4">{{$data->appends($query)->links()}}</td>
              </tr>
	</tbody>
</table>
    </body>
    <script>
        //第一种写法ajax 删除
//        function ajaxdel(id){
//            
//            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
//            $.ajax({
//                method: "POST",
//                url: "/brand/del/"+id,
//                data: '',
//                dataType:'json',
//              }).done(function( res ) {
//                 if(res.code=='00000'){
//                     alert(res.msg);
//                     location.reload();
//                 }
//              });
//        }
         //第二种写法get ajax 删除
        function ajaxdel(id){
            if(!id){
               return; 
            }
            $.get('/brand/del/'+id,function(res){
                if(res.code=='00000'){
                     alert(res.msg);
                     location.reload();
                 }
            },'json') ;  
                
        }
        
        
        //ajax 分页
        //$('.pagination a').click(function(){
       $(document).on('click','.pagination a',function(){    
           //alert(123);
            var url = $(this).attr('href');  
            $.get(url,function(res){
               $('tbody').html(res);
            });
            return false;
        });
        
        
   </script>
</html>
