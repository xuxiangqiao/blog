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
         <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <h3>商品添加</h3><hr/>

<!--       @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
        @endif-->
        <form class="form-horizontal" action="{{url('/brand/store')}}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            
            <ul id="myTab" class="nav nav-tabs">
	<li class="active">
		<a href="#home" data-toggle="tab">
			 基本信息
		</a>
	</li>
	<li><a href="#xiangce" data-toggle="tab">商品相册</a></li>
        <li><a href="#desc" data-toggle="tab">商品详情</a></li>
	
        </ul>
        <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="home">
                    <br/>
                         <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="goods_name" value="" id="firstname" placeholder="请输入名字">
                              <b style="color:red">{{$errors->first('brand_name')}}</b>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label">商品货号</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control"  name="brand_url" value="" id="firstname" placeholder="请输入名字">
                              <b style="color:red">{{$errors->first('brand_url')}}</b>
                            </div>
                          </div> 
                          <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label">库存</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control"  name="brand_url" value="" id="firstname" placeholder="请输入名字">
                              <b style="color:red">{{$errors->first('brand_url')}}</b>
                            </div>
                          </div>      
                           <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label">商品缩略图</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control"  name="brand_logo" id="firstname" placeholder="请输入名字">
                            </div>
                          </div>
                </div>
                <div class="tab-pane fade" id="xiangce">
                    <br/>
                         <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">商品相册</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control"  name="brand_logo" id="firstname" placeholder="请输入名字">
                        </div>
                      </div>   
                </div>
                <div class="tab-pane fade" id="desc">
                    <br/>
                       <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">品牌描述</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control"  name="brand_desc" id="firstname" placeholder="请输入名字">{{session('data')['brand_name']}}</textarea>
                        </div>
                      </div>  
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