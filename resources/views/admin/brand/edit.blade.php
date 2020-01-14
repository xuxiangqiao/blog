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
        <h3>品牌修改</h3><hr/>
        <form class="form-horizontal" action="{{url('/brand/update/'.$data->brand_id)}}" role="form" method="post"  enctype="multipart/form-data">
            @csrf
       <div class="form-group">
         <label for="firstname" class="col-sm-2 control-label">品牌名称</label>
         <div class="col-sm-10">
           <input type="text" class="form-control" value="{{$data->brand_name}}" name="brand_name" id="firstname" placeholder="请输入名字">
         </div>
       </div>
        <div class="form-group">
         <label for="firstname" class="col-sm-2 control-label">品牌网址</label>
         <div class="col-sm-10">
           <input type="text" class="form-control" value="{{$data->brand_url}}"  name="brand_url" id="firstname" placeholder="请输入名字">
         </div>
       </div> 
        <div class="form-group">
         <label for="firstname" class="col-sm-2 control-label">品牌LOGO</label>
         <div class="col-sm-10">
             <img src="{{env('UPLOAD_URL')}}{{$data->brand_logo}}" width="100"/>
           <input type="file" class="form-control"  name="brand_logo" id="firstname" placeholder="请输入名字">
         </div>
       </div>
       <div class="form-group">
         <label for="firstname" class="col-sm-2 control-label">品牌描述</label>
         <div class="col-sm-10">
             <textarea type="text" class="form-control"  name="brand_desc" id="firstname" placeholder="请输入名字">{{$data->brand_desc}}</textarea>
         </div>
       </div>          

       <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
           <button type="submit" class="btn btn-default">提交</button>
         </div>
       </div>
     </form>
    </body>
</html>
