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
         <h3>购物车列表</h3>
         <h3>欢迎【{{session('admin')->username??''}}】登录,<a href="{{url('/logout')}}">退出</a>  </h3>
       
         <hr/>
         
         
       <table class="table table-striped">
	
	<thead>
		<tr>
                        <th>商品ID</th>
			<th>商品名称</th>
			
			<th>商品价格</th>
                        <th>购买数量</th>
                        <th>添加时间</th>
		</tr>
	</thead>
	<tbody>
            @foreach ($data as $v)
		<tr>
			 <td>{{$v['goods_id']}}</td>
                         <td>{{$v['goods_name']}}</td>
                          <td>{{$v['goods_price']}}</td>
                        <td>{{$v['buy_number']}}</td>
                        <td>{{date('Y-m-d H:i:s',$v['addtime'])}}</td>
		</tr>
              @endforeach  
              <tr>     
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
