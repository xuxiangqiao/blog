<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{$goods->goods_name}}</title>
        <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">  
         <script src="/static/admin/js/jquery-3.2.1.min.js"></script>
         <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
         <h3>{{$goods->goods_name}}</h3>
         <span>当前访问量：{{$current}}</span>
         <hr/>
         <p>价格：{{$goods->goods_price}}</p>
         <p>{{$goods->content}}</p>
         <button>购买</button>
    </body>
    <script>
       $('button').click(function(){
           var goods_id = {{$goods->goods_id}};
           $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
           $.post('/goods/addcart',{goods_id:goods_id},function(res){
                alert(res.msg);
               if(res.code=='00001'){
                   location.href='/login';
               }
               if(res.code=='00000'){
                   location.href='/cart';
               }
           },'json');
       });
    </script>
</html>
