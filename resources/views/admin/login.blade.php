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
    </head>
    <body>
         <center> <h1>登录</h1>
         <b style="color:red">{{session('msg')}}</b>
         </center>
         <form class="form-horizontal" action="{{url('/dologin')}}" role="form" method="post" enctype="multipart/form-data">
            @csrf
       <div class="form-group">
         <label for="firstname" class="col-sm-4 control-label">用户名：</label>
         <div class="col-sm-4">
           <input type="text" class="form-control" name="username" value="" id="firstname" placeholder="请输入用户名">
           <b style="color:red">{{$errors->first('brand_name')}}</b>
         </div>
       </div>
       <div class="form-group">
         <label for="firstname" class="col-sm-4 control-label">密码：</label>
         <div class="col-sm-4">
           <input type="password" class="form-control" name="password" value="" id="firstname" placeholder="请输入密码">
           <b style="color:red">{{$errors->first('brand_name')}}</b>
         </div>
       </div>

       <div class="form-group">
         <div class="col-sm-offset-5 col-sm-10">
           <button type="submit" class="btn btn-default">提交</button>
         </div>
       </div>
     </form>
    </body>
</html>
